import os
import sys
import json
import time
from PIL import Image, ImageDraw, ImageFont

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
TEMPLATES_DIR = os.path.join(BASE_DIR, 'assets', 'images', 'templates')
OUTPUT_DIR = os.path.join(BASE_DIR, 'assets', 'images', 'products')
SITE_DATA_PATH = os.path.join(BASE_DIR, 'data', 'site_data.json')
FRAGRANCE_DATA_JS = os.path.join(BASE_DIR, 'assets', 'js', 'fragrance-data.js')

os.makedirs(OUTPUT_DIR, exist_ok=True)

# 3 Luxury Perfume Flacons ONLY (NO DROPPER BOTTLE)
BOTTLE_CONFIGS = {
    'crystal_gold': {
        'file': 'bottle_crystal_gold.jpg',
        'label': (425, 430, 670, 675),
        'zoom': (240, 120, 840, 720),
        'label_bg': (255, 252, 246),
        'border_gold': (195, 155, 85),
        'border_sub': (225, 195, 135),
        'text_main': (20, 16, 12),
        'tag': 'FINE FLACON'
    },
    'obsidian_slate': {
        'file': 'bottle_obsidian_slate.jpg',
        'label': (345, 430, 675, 715),
        'zoom': (180, 100, 840, 760),
        'label_bg': (248, 248, 250),
        'border_gold': (160, 175, 190),
        'border_sub': (205, 215, 225),
        'text_main': (18, 22, 28),
        'tag': 'PRIVATE RESERVE'
    },
    'arabic_oud': {
        'file': 'bottle_arabic_oud.jpg',
        'label': (350, 420, 670, 700),
        'zoom': (200, 100, 820, 720),
        'label_bg': (253, 248, 238),
        'border_gold': (189, 121, 51),
        'border_sub': (225, 165, 95),
        'text_main': (30, 20, 12),
        'tag': 'ORIENTAL FLACON'
    }
}

# Pre-load all template images into memory
LOADED_TEMPLATES = {}
for k, cfg in BOTTLE_CONFIGS.items():
    p = os.path.join(TEMPLATES_DIR, cfg['file'])
    LOADED_TEMPLATES[k] = Image.open(p).convert('RGB')
    print(f"Loaded master template: {k} ({cfg['file']})")

# Fonts
FONT_BRAND = ImageFont.truetype(r'C:\Windows\Fonts\georgiab.ttf', 24)
FONT_CAT = ImageFont.truetype(r'C:\Windows\Fonts\georgia.ttf', 11)
FONT_INSP = ImageFont.truetype(r'C:\Windows\Fonts\segoeuib.ttf', 13)
FONT_SPEC = ImageFont.truetype(r'C:\Windows\Fonts\segoeui.ttf', 10)
FONT_LOT = ImageFont.truetype(r'C:\Windows\Fonts\segoeuib.ttf', 10)

TITLE_FONTS = {
    sz: ImageFont.truetype(r'C:\Windows\Fonts\palab.ttf', sz)
    for sz in range(8, 70)
}

def choose_bottle_style(product):
    cat = product.get('category', 'designer-fragrance')
    sno = product.get('sno', 1)
    
    if cat == 'oriental-arabic':
        return 'arabic_oud'
    elif cat == 'niche-luxury':
        return 'obsidian_slate'
    elif cat == 'floral-botanical':
        return 'crystal_gold'
    elif cat == 'fruits-gourmand':
        return 'crystal_gold' if sno % 2 == 1 else 'arabic_oud'
    else: # designer-fragrance
        # Alternate between Clear Crystal & Gold and Obsidian Slate
        return 'crystal_gold' if sno % 2 == 1 else 'obsidian_slate'

def render_bottle_image(product):
    style_key = choose_bottle_style(product)
    cfg = BOTTLE_CONFIGS[style_key]
    template_img = LOADED_TEMPLATES[style_key]

    img = template_img.copy()
    draw = ImageDraw.Draw(img)

    lx1, ly1, lx2, ly2 = cfg['label']
    lw = lx2 - lx1
    lh = ly2 - ly1
    cx = (lx1 + lx2) // 2

    # Draw luxury rounded label with double gold foil borders
    draw.rounded_rectangle([lx1, ly1, lx2, ly2], radius=8, fill=cfg['label_bg'])
    draw.rounded_rectangle([lx1 + 4, ly1 + 4, lx2 - 4, ly2 - 4], radius=6, outline=cfg['border_gold'], width=2)
    draw.rounded_rectangle([lx1 + 8, ly1 + 8, lx2 - 8, ly2 - 8], radius=4, outline=cfg['border_sub'], width=1)

    # 1. Header: PANNA HEERA
    draw.text((cx, ly1 + 24), "PANNA HEERA", font=FONT_BRAND, fill=(24, 20, 16), anchor="mm")

    # 2. Category Tag
    tag_text = cfg['tag']
    draw.text((cx, ly1 + 44), tag_text, font=FONT_CAT, fill=cfg['border_gold'], anchor="mm")
    draw.line([(cx - 70, ly1 + 56), (cx + 70, ly1 + 56)], fill=cfg['border_sub'], width=1)

    # 3. Brand Inspiration
    brand_name = (product.get('brand') or '').upper().strip()
    if brand_name:
        if len(brand_name) > 28:
            brand_name = brand_name[:26] + '..'
        draw.text((cx, ly1 + 74), brand_name, font=FONT_INSP, fill=(80, 65, 50), anchor="mm")

    # 4. Fragrance Name (Auto-scaled to fit label)
    frag_name = (product.get('short_title') or product.get('title') or '').upper().strip()
    if ' - ' in frag_name:
        frag_name = frag_name.split(' - ')[-1].strip()

    title_y = ly1 + 115
    chosen_font = None
    lines = [frag_name]
    max_title_w = lw - 24

    for sz in range(48, 22, -2):
        f = TITLE_FONTS[sz]
        bb = draw.textbbox((0, 0), frag_name, font=f)
        if (bb[2] - bb[0]) <= max_title_w:
            chosen_font = f
            lines = [frag_name]
            break

    if chosen_font is None:
        words = frag_name.split()
        if len(words) > 1:
            mid = len(words) // 2
            l1, l2 = ' '.join(words[:mid]), ' '.join(words[mid:])
            for sz in range(36, 16, -2):
                f = TITLE_FONTS[sz]
                bb1 = draw.textbbox((0, 0), l1, font=f)
                bb2 = draw.textbbox((0, 0), l2, font=f)
                if max(bb1[2] - bb1[0], bb2[2] - bb2[0]) <= max_title_w:
                    chosen_font = f
                    lines = [l1, l2]
                    break

    if chosen_font is None:
        chosen_font = TITLE_FONTS[18]
        lines = [frag_name[:24] + '..' if len(frag_name) > 24 else frag_name]

    if len(lines) == 1:
        draw.text((cx, title_y), lines[0], font=chosen_font, fill=cfg['text_main'], anchor="mm")
    else:
        draw.text((cx, title_y - 12), lines[0], font=chosen_font, fill=cfg['text_main'], anchor="mm")
        draw.text((cx, title_y + 14), lines[1], font=chosen_font, fill=cfg['text_main'], anchor="mm")

    # 5. Divider & Specs
    draw.line([(cx - 60, ly1 + 154), (cx + 60, ly1 + 154)], fill=cfg['border_sub'], width=1)
    draw.text((cx, ly1 + 172), "100% PURE CONCENTRATE", font=FONT_CAT, fill=(70, 60, 50), anchor="mm")
    draw.text((cx, ly1 + 192), "ALCOHOL FREE • LONG LASTING", font=FONT_SPEC, fill=(90, 80, 70), anchor="mm")

    # 6. Lot Stamp
    sno = product.get('sno', 1)
    lot_str = f"LOT NO. PH-{sno:04d} • 100G / 1KG"
    draw.text((cx, ly1 + 214), lot_str, font=FONT_LOT, fill=cfg['border_gold'], anchor="mm")

    # Zoom crop & resize to 800x800
    zoomed_img = img.crop(cfg['zoom'])
    final_img = zoomed_img.resize((800, 800), Image.Resampling.LANCZOS)
    
    prod_id = product.get('id', f'oil-{sno}')
    out_rel = f"assets/images/products/{prod_id}.webp"
    out_path = os.path.join(BASE_DIR, out_rel.replace('/', os.sep))
    final_img.save(out_path, format="WEBP", quality=86, method=4)
    return out_rel

def main():
    t0 = time.time()
    print("Reading site_data.json...")
    with open(SITE_DATA_PATH, 'r', encoding='utf-8') as f:
        site_data = json.load(f)

    products = site_data.get('products', [])
    total = len(products)
    print(f"Total products to generate: {total}")

    for idx, p in enumerate(products, 1):
        rel_img = render_bottle_image(p)
        p['image'] = rel_img
        if idx % 100 == 0 or idx == total:
            elapsed = time.time() - t0
            rate = idx / elapsed if elapsed > 0 else 0
            print(f"Progress: {idx}/{total} ({idx/total*100:.1f}%) - {rate:.1f} img/sec")

    # Save updated site_data.json
    print("Saving updated data/site_data.json...")
    with open(SITE_DATA_PATH, 'w', encoding='utf-8') as f:
        json.dump(site_data, f, indent=2, ensure_ascii=False)

    # Update assets/js/fragrance-data.js
    print("Updating assets/js/fragrance-data.js...")
    if os.path.exists(FRAGRANCE_DATA_JS):
        with open(FRAGRANCE_DATA_JS, 'r', encoding='utf-8') as f:
            js_raw = f.read()
        s_idx = js_raw.find('[')
        e_idx = js_raw.rfind(']') + 1
        if s_idx != -1 and e_idx != -1:
            frag_list = json.loads(js_raw[s_idx:e_idx])
            img_map = {p['id']: p['image'] for p in products}
            for it in frag_list:
                it_id = it.get('id')
                if it_id in img_map:
                    it['image'] = img_map[it_id]
            new_js = js_raw[:s_idx] + json.dumps(frag_list, ensure_ascii=False) + js_raw[e_idx:]
            with open(FRAGRANCE_DATA_JS, 'w', encoding='utf-8') as f:
                f.write(new_js)
            print("fragrance-data.js updated with image paths.")

    total_time = time.time() - t0
    print(f"\nCOMPLETED SUCCESSFULLY in {total_time:.2f} seconds!")
    print(f"Generated {total} WebP images in {OUTPUT_DIR}")

if __name__ == '__main__':
    main()
