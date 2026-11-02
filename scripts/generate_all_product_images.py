import os
import sys
import json
import time
from PIL import Image, ImageDraw, ImageFont

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
TEMPLATE_PATH = os.path.join(BASE_DIR, 'assets', 'images', 'templates', 'bottle_amber_base.jpg')
OUTPUT_DIR = os.path.join(BASE_DIR, 'assets', 'images', 'products')
SITE_DATA_PATH = os.path.join(BASE_DIR, 'data', 'site_data.json')
FRAGRANCE_DATA_JS = os.path.join(BASE_DIR, 'assets', 'js', 'fragrance-data.js')

os.makedirs(OUTPUT_DIR, exist_ok=True)

# 5 Category luxury themes
THEMES = {
    'designer-fragrance': {
        'label_bg': (249, 247, 242),
        'border_primary': (195, 155, 85),     # Classic Gold
        'border_secondary': (220, 185, 120),
        'text_main': (25, 22, 18),
        'text_accent': (180, 140, 70),
        'tag': 'DESIGNER FLACON'
    },
    'niche-luxury': {
        'label_bg': (246, 248, 250),
        'border_primary': (155, 170, 185),    # Platinum / Silver
        'border_secondary': (190, 205, 220),
        'text_main': (18, 24, 32),
        'text_accent': (110, 130, 150),
        'tag': 'PRIVATE RESERVE'
    },
    'oriental-arabic': {
        'label_bg': (250, 245, 235),
        'border_primary': (189, 121, 51),     # Rich Oud Amber
        'border_secondary': (219, 151, 81),
        'text_main': (35, 22, 12),
        'text_accent': (170, 100, 35),
        'tag': 'ORIENTAL COMPOUND'
    },
    'floral-botanical': {
        'label_bg': (252, 246, 246),
        'border_primary': (200, 125, 133),    # Rose Gold
        'border_secondary': (225, 155, 163),
        'text_main': (36, 18, 22),
        'text_accent': (185, 105, 115),
        'tag': 'BOTANICAL ESSENCE'
    },
    'fruits-gourmand': {
        'label_bg': (252, 248, 240),
        'border_primary': (212, 136, 46),     # Golden Honey / Caramel
        'border_secondary': (235, 165, 80),
        'text_main': (35, 24, 12),
        'text_accent': (190, 115, 30),
        'tag': 'GOURMAND ACCORD'
    }
}
DEFAULT_THEME = THEMES['designer-fragrance']

# Label bounding box in 1024x1024 template (Wider & tighter for big bold typography)
LX1, LY1, LX2, LY2 = 345, 430, 675, 715
LW = LX2 - LX1
LH = LY2 - LY1
CX = (LX1 + LX2) // 2

# Pre-load Windows fonts (significantly larger!)
FONT_BRAND = ImageFont.truetype(r'C:\Windows\Fonts\georgiab.ttf', 24)
FONT_SUB = ImageFont.truetype(r'C:\Windows\Fonts\georgia.ttf', 11)
FONT_INSP = ImageFont.truetype(r'C:\Windows\Fonts\segoeuib.ttf', 13)
FONT_SPEC = ImageFont.truetype(r'C:\Windows\Fonts\segoeui.ttf', 11)
FONT_LOT = ImageFont.truetype(r'C:\Windows\Fonts\segoeuib.ttf', 11)

# Pre-load font size options for titles (every size from 8 to 42)
TITLE_FONTS = {
    sz: ImageFont.truetype(r'C:\Windows\Fonts\palab.ttf', sz)
    for sz in range(8, 42)
}

print(f"Loading template from {TEMPLATE_PATH}...")
template_img = Image.open(TEMPLATE_PATH).convert('RGB')

def render_bottle_image(product):
    img = template_img.copy()
    draw = ImageDraw.Draw(img)

    cat_key = product.get('category', 'designer-fragrance')
    theme = THEMES.get(cat_key, DEFAULT_THEME)

    # 1. Label background with rounded corners
    draw.rounded_rectangle([LX1, LY1, LX2, LY2], radius=8, fill=theme['label_bg'])

    # 2. Luxury borders (Double-line gold foil look)
    draw.rounded_rectangle([LX1 + 5, LY1 + 5, LX2 - 5, LY2 - 5], radius=6, outline=theme['border_primary'], width=3)
    draw.rounded_rectangle([LX1 + 10, LY1 + 10, LX2 - 10, LY2 - 10], radius=4, outline=theme['border_secondary'], width=1)

    # 3. Top Header: PANNA HEERA (Bold luxury serif)
    draw.text((CX, LY1 + 28), "PANNA HEERA", font=FONT_BRAND, fill=(26, 22, 18), anchor="mm")

    # 4. Category Tag
    draw.text((CX, LY1 + 50), theme['tag'], font=FONT_SUB, fill=theme['text_accent'], anchor="mm")

    # Divider
    draw.line([(CX - 75, LY1 + 63), (CX + 75, LY1 + 63)], fill=theme['border_secondary'], width=1)

    # 5. Benchmark Inspiration Brand
    brand_name = (product.get('brand') or '').upper().strip()
    if brand_name:
        if len(brand_name) > 30:
            brand_name = brand_name[:28] + '..'
        draw.text((CX, LY1 + 82), brand_name, font=FONT_INSP, fill=(85, 70, 55), anchor="mm")

    # 6. Fragrance Name (Auto-sized and wrapped)
    frag_name = (product.get('short_title') or product.get('title') or '').upper().strip()
    if ' - ' in frag_name:
        frag_name = frag_name.split(' - ')[-1].strip()

    title_y = LY1 + 120
    chosen_font = None
    lines = [frag_name]

    # Try single line first (up to 34pt!)
    for test_sz in (34, 30, 26, 22, 18, 15):
        f = TITLE_FONTS[test_sz]
        bb = draw.textbbox((0, 0), frag_name, font=f)
        if (bb[2] - bb[0]) <= (LW - 34):
            chosen_font = f
            lines = [frag_name]
            break

    # If single line doesn't fit, wrap into 2 lines
    if chosen_font is None:
        words = frag_name.split()
        if len(words) > 1:
            mid = len(words) // 2
            l1, l2 = ' '.join(words[:mid]), ' '.join(words[mid:])
            for test_sz in (24, 21, 18, 15, 13):
                f = TITLE_FONTS[test_sz]
                bb1 = draw.textbbox((0, 0), l1, font=f)
                bb2 = draw.textbbox((0, 0), l2, font=f)
                if max(bb1[2] - bb1[0], bb2[2] - bb2[0]) <= (LW - 28):
                    chosen_font = f
                    lines = [l1, l2]
                    break

    if chosen_font is None:
        chosen_font = TITLE_FONTS[14]
        lines = [frag_name[:26] + '..' if len(frag_name) > 26 else frag_name]

    if len(lines) == 1:
        draw.text((CX, title_y), lines[0], font=chosen_font, fill=theme['text_main'], anchor="mm")
    else:
        draw.text((CX, title_y - 12), lines[0], font=chosen_font, fill=theme['text_main'], anchor="mm")
        draw.text((CX, title_y + 16), lines[1], font=chosen_font, fill=theme['text_main'], anchor="mm")

    # 7. Classification
    draw.line([(CX - 65, LY1 + 160), (CX + 65, LY1 + 160)], fill=theme['border_secondary'], width=1)
    draw.text((CX, LY1 + 182), "100% PURE CONCENTRATE", font=FONT_SUB, fill=(75, 65, 55), anchor="mm")

    # 8. Specs
    draw.text((CX, LY1 + 206), "ALCOHOL FREE • LONG LASTING", font=FONT_SPEC, fill=(95, 85, 75), anchor="mm")

    # 9. Lot Number & Pack Sizing
    sno = product.get('sno', 1)
    lot_str = f"LOT NO. PH-{sno:04d} • 100G / 1KG"
    draw.text((CX, LY1 + 234), lot_str, font=FONT_LOT, fill=theme['border_primary'], anchor="mm")

    # ZOOM CROP: Zoom in tightly on the bottle (720x720 centered square crop)
    # Bottle now occupies ~92% of frame height, text is 2x-3x larger and crystal clear!
    zoomed_img = img.crop((152, 45, 872, 765))
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
