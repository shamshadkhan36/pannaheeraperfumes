import os
import sys
import json
import re
import ast
import pandas as pd

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SITE_DATA_PATH = os.path.join(BASE_DIR, 'data', 'site_data.json')
FRA_CSV_PATH = os.path.join(BASE_DIR, 'data', 'fra_cleaned.csv')
COMB_CSV_PATH = os.path.join(BASE_DIR, 'scratch_fragrantica_combined.csv')
PRODUCTS_JS_PATH = os.path.join(BASE_DIR, 'assets', 'js', 'products-data.js')
NOTES_LIB_PATH = os.path.join(BASE_DIR, 'data', 'notes_library.json')

with open(NOTES_LIB_PATH, 'r', encoding='utf-8') as f:
    notes_lib = json.load(f)

NOTE_IMG_MAP = {n['name'].lower(): n['image'] for n in notes_lib}

SYNONYMS = {
    'sicilian lemon': 'lemon', 'italian lemon': 'lemon', 'lemon zest': 'lemon', 'lime': 'lemon', 'yuzu': 'lemon', 'citron': 'lemon', 'citruses': 'lemon',
    'calabrian bergamot': 'bergamot', 'bergamot orange': 'bergamot', 'sicilian bergamot': 'bergamot',
    'grapefruit': 'grapefruit', 'pink grapefruit': 'grapefruit',
    'blood orange': 'orange', 'bitter orange': 'orange', 'orange peel': 'orange', 'orange': 'orange',
    'mandarin': 'mandarin orange', 'mandarin orange': 'mandarin orange', 'green mandarin': 'mandarin orange', 'tangerine': 'mandarin orange', 'clementine': 'mandarin orange',
    'cassis': 'black currant', 'black currant': 'black currant', 'black-currant': 'black currant', 'blackberry': 'black currant',
    'black cherry': 'sour cherry', 'sour cherry': 'sour cherry', 'cherry': 'sour cherry',
    'wild berries': 'raspberry', 'red berries': 'raspberry', 'raspberry': 'raspberry', 'strawberry': 'raspberry',
    'grasse rose': 'rose', 'damask rose': 'rose', 'turkish rose': 'rose', 'bulgarian rose': 'rose', 'may rose': 'rose', 'taif rose': 'rose', 'rose': 'rose', 'rosa': 'rose',
    'sambac jasmine': 'jasmine', 'white jasmine': 'jasmine', 'jasmine': 'jasmine', 'jasmine sambac': 'jasmine', 'water jasmine': 'jasmine',
    'french lavender': 'lavender', 'lavender': 'lavender',
    'bourbon vanilla': 'vanilla', 'madagascar vanilla': 'vanilla', 'vanilla': 'vanilla', 'vanilla orchid': 'vanilla', 'vanilla caviar': 'vanilla',
    'virginian cedar': 'cedarwood', 'atlas cedar': 'cedarwood', 'cedar': 'cedarwood', 'cedarwood': 'cedarwood', 'virginia cedar': 'cedarwood',
    'mysore sandalwood': 'sandalwood', 'sandalwood': 'sandalwood',
    'haitian vetiver': 'vetiver', 'vetiver': 'vetiver', 'bourbon vetiver': 'vetiver', 'java vetiver': 'vetiver',
    'white musk': 'musk', 'crystal musk': 'musk', 'musk': 'musk', 'cashmeran': 'musk', 'ambroxan': 'amber',
    'ambergris': 'amber', 'amberwood': 'amber', 'amber': 'amber', 'benzoin': 'amber', 'labdanum': 'amber', 'amber xtreme': 'amber',
    'agarwood': 'oud', 'cambodian oud': 'oud', 'agarwood (oud)': 'oud', 'oud': 'oud', 'laotian oud': 'oud', 'assam oud': 'oud',
    'cardamom': 'cardamom', 'green cardamom': 'cardamom', 'guatemalan cardamom': 'cardamom',
    'cinnamon': 'cinnamon', 'ceylon cinnamon': 'cinnamon', 'cinnamon bark': 'cinnamon',
    'pink pepper': 'pink pepper', 'pink-pepper': 'pink pepper', 'black pepper': 'pink pepper', 'sichuan pepper': 'pink pepper', 'pepper': 'pink pepper', 'white pepper': 'pink pepper',
    'saffron': 'saffron', 'red saffron': 'saffron',
    'tobacco': 'tobacco leaf', 'tobacco leaf': 'tobacco leaf', 'cured tobacco': 'tobacco leaf', 'white tobacco': 'tobacco leaf',
    'coffee': 'coffee', 'roasted coffee': 'coffee', 'espresso': 'coffee', 'coffee beans': 'coffee',
    'cacao': 'cacao / cocoa', 'cocoa': 'cacao / cocoa', 'chocolate': 'cacao / cocoa', 'dark chocolate': 'cacao / cocoa', 'praline': 'cacao / cocoa',
    'tonka': 'tonka bean', 'tonka bean': 'tonka bean', 'coumarin': 'tonka bean',
    'sea notes': 'sea-notes', 'marine notes': 'sea-notes', 'aquatic notes': 'sea-notes', 'ocean notes': 'sea-notes', 'sea salt': 'sea-notes', 'water notes': 'sea-notes', 'calone': 'sea-notes',
    'oakmoss': 'oakmoss', 'moss': 'oakmoss', 'tree moss': 'oakmoss',
    'patchouli': 'patchouli', 'indonesian patchouli': 'patchouli', 'patchouli leaf': 'patchouli',
    'mint': 'mint', 'spearmint': 'mint', 'peppermint': 'mint',
    'apple': 'apple', 'green apple': 'apple', 'red apple': 'apple',
    'pineapple': 'pineapple', 'peach': 'peach', 'white peach': 'peach',
    'rosemary': 'rosemary',
    'incense': 'incense', 'frankincense': 'incense', 'olibanum': 'incense', 'myrrh': 'incense',
    'iris': 'iris', 'orris': 'iris', 'orris root': 'iris',
    'violet': 'violet', 'violet leaf': 'violet',
    'leather': 'leather', 'suede': 'leather', 'tuscan leather': 'leather',
    'wormwood': 'wormwood', 'artemisia': 'wormwood', 'clary sage': 'wormwood', 'sage': 'wormwood',
    'neroli': 'neroli', 'orange blossom': 'neroli', 'african orange flower': 'neroli', 'petitgrain': 'neroli',
    'tuberose': 'jasmine', 'gardenia': 'jasmine', 'magnolia': 'jasmine', 'lily': 'jasmine', 'lily-of-the-valley': 'jasmine', 'freesia': 'jasmine'
}

def resolve_note(note_name):
    clean = str(note_name).strip()
    disp_name = ' '.join(w.capitalize() for w in clean.split())
    low = clean.lower()
    
    if low in NOTE_IMG_MAP:
        return {'name': disp_name, 'image': NOTE_IMG_MAP[low]}
        
    if low in SYNONYMS:
        syn = SYNONYMS[low]
        if syn.lower() in NOTE_IMG_MAP:
            return {'name': disp_name, 'image': NOTE_IMG_MAP[syn.lower()]}
            
    for k, syn in SYNONYMS.items():
        if k in low or low in k:
            if syn.lower() in NOTE_IMG_MAP:
                return {'name': disp_name, 'image': NOTE_IMG_MAP[syn.lower()]}
                
    if any(w in low for w in ['citrus', 'lime', 'yuzu', 'lemon']):
        return {'name': disp_name, 'image': 'assets/images/notes/lemon.png'}
    elif any(w in low for w in ['orange', 'mandarin', 'tangerine', 'clementine']):
        return {'name': disp_name, 'image': 'assets/images/notes/orange.png'}
    elif any(w in low for w in ['flower', 'blossom', 'petal', 'flora', 'lily', 'freesia', 'orchid', 'jasmine', 'gardenia', 'tuberose']):
        return {'name': disp_name, 'image': 'assets/images/notes/jasmine.png'}
    elif any(w in low for w in ['rose', 'peony']):
        return {'name': disp_name, 'image': 'assets/images/notes/rose.png'}
    elif any(w in low for w in ['berry', 'cherry', 'fruit', 'plum', 'fig', 'currant', 'raspberry']):
        return {'name': disp_name, 'image': 'assets/images/notes/raspberry.png'}
    elif any(w in low for w in ['wood', 'tree', 'pine', 'cypress', 'birch', 'cedar']):
        return {'name': disp_name, 'image': 'assets/images/notes/cedarwood.png'}
    elif any(w in low for w in ['sandal']):
        return {'name': disp_name, 'image': 'assets/images/notes/sandalwood.png'}
    elif any(w in low for w in ['oud', 'agar']):
        return {'name': disp_name, 'image': 'assets/images/notes/oud.png'}
    elif any(w in low for w in ['sweet', 'sugar', 'honey', 'caramel', 'chocolate', 'vanilla']):
        return {'name': disp_name, 'image': 'assets/images/notes/vanilla.png'}
    elif any(w in low for w in ['spice', 'ginger', 'nutmeg', 'clove', 'pepper', 'cardamom', 'cinnamon']):
        return {'name': disp_name, 'image': 'assets/images/notes/cardamom.png'}
    elif any(w in low for w in ['water', 'sea', 'marine', 'ocean', 'aqua', 'salt']):
        return {'name': disp_name, 'image': 'assets/images/notes/sea-notes.png'}
    elif any(w in low for w in ['leather', 'suede']):
        return {'name': disp_name, 'image': 'assets/images/notes/leather.png'}
        
    return {'name': disp_name, 'image': 'assets/images/notes/amber.png'}

BRAND_MAP = {
    'abercrombie g fitch': 'abercrombie fitch',
    'swiss': 'swiss arabian',
    'paco rabbane': 'paco rabanne',
    'paco rabanne': 'paco rabanne',
    'caroline harerra': 'carolina herrera',
    'monte blanc': 'montblanc',
    'tomford': 'tom ford',
    'jpg': 'jean paul gaultier',
    'ck': 'calvin klein',
    'boss': 'hugo boss',
    'victoria sec': 'victoria s secret',
    'd g g': 'dolce gabbana',
    'dgg': 'dolce gabbana',
    'parfums d marly': 'parfums de marly',
    'al rehab': 'al rehab',
    'jo malone': 'jo malone london',
    'kilian': 'by kilian',
    'valentino uomo': 'valentino',
    'valentino donna': 'valentino',
    'ysl': 'yves saint laurent',
    'roja dove': 'roja dove',
    'mfk': 'maison francis kurkdjian',
    'dyptique': 'diptyque',
    'diptyque': 'diptyque'
}

TITLE_REPLACEMENTS = {
    'club d nuit sillage': 'club de nuit sillage',
    'club d nuit intense (m)': 'club de nuit intense man',
    'club d nuit intense (w)': 'club de nuit intense',
    'club d nuit': 'club de nuit intense man',
    'one million': '1 million',
    'black x.s.': 'black xs',
    'black xs': 'black xs',
    'oudh for greatness': 'oud for greatness',
    'arabian tonka': 'arabians tonka',
    'café intense': 'intense cafe',
    'cafe intense': 'intense cafe',
    'tam dao edt': 'tam dao',
    'l\'ombre dans leau': 'l ombre dans l eau',
    'eau d capital': 'eau capitale',
    'coeur buttant': 'coeur battant',
    'oudh lime': 'aoud lime',
    'aqua di ': 'acqua di ',
    'aqua ': 'acqua ',
    'd nuit': 'de nuit',
    'oud royale prive': 'oud royal',
    'black code': 'armani code',
    'homme intense': 'dior homme intense',
    'blue d chanel': 'bleu de chanel',
    'blue de chanel': 'bleu de chanel',
    'farhaneit': 'fahrenheit',
    'jadore': 'j adore',
    'angle s share': 'angels share',
    'vanilla sxx': 'vanilla sex',
    'silver mountain river': 'silver mountain water',
    'vikings': 'viking',
    'le gemme tyger': 'tygar',
    'eou fraiche': 'eau fraiche',
    'dylan blue men': 'dylan blue',
    'dylan blue women': 'dylan blue pour femme',
    'weekend (m)': 'weekend for men',
    'weekend (w)': 'weekend for women',
    'game (m)': 'cool water game for him',
    'game (w)': 'cool water game for her',
    'reflection men': 'reflection man',
    'oudh g bargamot': 'oud bergamot',
    'wood sage g sea salt': 'wood sage sea salt',
    'lime basil g mandarine': 'lime basil mandarin',
    'nactarine blossom g honey': 'nectarine blossom honey',
    'peony g blush leather': 'peony blush suede',
    'tobacco g mandarine': 'tobacco mandarin',
    'gucci flora gorgeous mangolia': 'flora gorgeous magnolia',
    'guilty men': 'guilty pour homme',
    'guilty women': 'guilty',
    'guilty absolu men': 'guilty absolute',
    'voice of the snake': 'the voice of the snake'
}

def clean_brand(b):
    s = re.sub(r'[^a-z0-9 ]', ' ', str(b).lower()).strip()
    return BRAND_MAP.get(s, s)

def clean_title(t):
    s = str(t).lower()
    
    # Specific known title mappings first
    for k, v in TITLE_REPLACEMENTS.items():
        if k in s:
            s = s.replace(k, v)
            
    # Clean out non-alphanumeric except spaces
    s = re.sub(r'\(m\)', ' man ', s)
    s = re.sub(r'\(w\)', ' woman ', s)
    s = re.sub(r' - new\b', '', s)
    s = re.sub(r' - premium\b', '', s)
    s = re.sub(r'\bpremium\b', '', s)
    s = re.sub(r'\bregular\b', '', s)
    s = re.sub(r'\bg\b', 'and', s)
    s = re.sub(r'[^a-z0-9 ]', ' ', s).strip()
    return re.sub(r'\s+', ' ', s)

def parse_pyramid_list(val):
    if not val or pd.isna(val) or str(val).lower() == 'nan':
        return []
    s = str(val).strip()
    if s.startswith('[') and s.endswith(']'):
        try:
            return [x.strip() for x in ast.literal_eval(s) if str(x).strip()]
        except:
            pass
    return [x.strip() for x in s.split(',') if x.strip() and x.lower() != 'nan']

def main():
    print("Loading Fragrantica database sources...")
    frag_records = []

    # Source 1: Combined dataset (211 modern hits)
    if os.path.exists(COMB_CSV_PATH):
        df_comb = pd.read_csv(COMB_CSV_PATH, encoding='latin1')
        for idx, row in df_comb.iterrows():
            top = parse_pyramid_list(row.get('top notes'))
            mid = parse_pyramid_list(row.get('middle notes'))
            base = parse_pyramid_list(row.get('base notes'))
            if top or mid or base:
                frag_records.append({
                    'raw_brand': str(row.get('company', '')),
                    'raw_perfume': str(row.get('name', '')),
                    'clean_brand': clean_brand(row.get('company', '')),
                    'clean_perfume': clean_title(row.get('name', '')),
                    'words': set(clean_title(row.get('name', '')).split()),
                    'top': top,
                    'middle': mid,
                    'base': base,
                    'url': f"https://www.fragrantica.com/perfume/{row.get('company', '')}/{row.get('name', '')}.html",
                    'source': 'Fragrantica Official'
                })
        print(f"Loaded {len(frag_records)} records from Source 1 (Combined).")

    # Source 2: fra_cleaned.csv (24k perfumes)
    if os.path.exists(FRA_CSV_PATH):
        df_fra = pd.read_csv(FRA_CSV_PATH, encoding='latin1', sep=';', on_bad_lines='skip')
        s2_count = 0
        for idx, row in df_fra.iterrows():
            top = parse_pyramid_list(row.get('Top'))
            mid = parse_pyramid_list(row.get('Middle'))
            base = parse_pyramid_list(row.get('Base'))
            if top or mid or base:
                frag_records.append({
                    'raw_brand': str(row.get('Brand', '')),
                    'raw_perfume': str(row.get('Perfume', '')),
                    'clean_brand': clean_brand(row.get('Brand', '')),
                    'clean_perfume': clean_title(row.get('Perfume', '')),
                    'words': set(clean_title(row.get('Perfume', '')).split()),
                    'top': top,
                    'middle': mid,
                    'base': base,
                    'url': str(row.get('url', '')),
                    'source': 'Fragrantica 24k Archive'
                })
                s2_count += 1
        print(f"Loaded {s2_count} records from Source 2 (fra_cleaned).")

    print(f"Total unified Fragrantica index size: {len(frag_records)} perfumes.")

    # Load site_data.json
    print(f"Loading {SITE_DATA_PATH}...")
    with open(SITE_DATA_PATH, 'r', encoding='utf-8') as f:
        site_data = json.load(f)

    products = site_data.get('products', [])
    total = len(products)
    print(f"Total catalog products: {total}")

    matched_count = 0
    cleared_count = 0

    for p in products:
        brand_raw = p.get('brand', '')
        short_title_raw = p.get('short_title') or p.get('title') or ''
        
        # User explicitly requested: REMOVE all notes not on Fragrantica
        if brand_raw == 'Panna Heera Originals':
            p['notes'] = {'top': [], 'middle': [], 'base': []}
            p['fragrantica_matched'] = False
            p['fragrantica_url'] = None
            p['fragrantica_reference'] = None
            p['notes_source'] = None
            cleared_count += 1
            continue

        b_clean = clean_brand(brand_raw)
        s_clean = clean_title(short_title_raw)
        s_words = set(s_clean.split())

        found = None

        # Level 1: EXACT MATCH (Brand + Perfume name exact)
        for rec in frag_records:
            if b_clean and (b_clean in rec['clean_brand'] or rec['clean_brand'] in b_clean):
                if s_clean == rec['clean_perfume']:
                    found = rec
                    break

        # Level 2: EXACT PERFUME NAME anywhere in database
        if not found and s_clean:
            for rec in frag_records:
                if s_clean == rec['clean_perfume']:
                    found = rec
                    break

        # Level 3: Brand match + Shortest matching substring (prefers flagship over flankers)
        if not found and s_clean:
            candidates = []
            for rec in frag_records:
                if b_clean and (b_clean in rec['clean_brand'] or rec['clean_brand'] in b_clean):
                    if s_clean in rec['clean_perfume']:
                        candidates.append(rec)
            if candidates:
                candidates.sort(key=lambda x: len(x['clean_perfume']))
                found = candidates[0]

        # Level 4: Brand match + Token subset
        if not found and s_words:
            candidates = []
            for rec in frag_records:
                if b_clean and (b_clean in rec['clean_brand'] or rec['clean_brand'] in b_clean):
                    if s_words.issubset(rec['words']) or rec['words'].issubset(s_words):
                        candidates.append(rec)
            if candidates:
                candidates.sort(key=lambda x: len(x['clean_perfume']))
                found = candidates[0]

        # Level 5: Global substring match for distinctive titles (>= 5 chars)
        if not found and len(s_clean) >= 5:
            candidates = []
            for rec in frag_records:
                if s_clean in rec['clean_perfume']:
                    candidates.append(rec)
            if candidates:
                candidates.sort(key=lambda x: len(x['clean_perfume']))
                found = candidates[0]

        # Level 6: Token subset across database for multi-word titles
        if not found and len(s_words) >= 2:
            candidates = []
            for rec in frag_records:
                if s_words.issubset(rec['words']):
                    candidates.append(rec)
            if candidates:
                candidates.sort(key=lambda x: len(x['clean_perfume']))
                found = candidates[0]

        if found:
            matched_count += 1
            # STRICT: Only notes that exist on Fragrantica; empty list otherwise
            p['notes'] = {
                'top': [resolve_note(n) for n in found['top']] if found['top'] else [],
                'middle': [resolve_note(n) for n in found['middle']] if found['middle'] else [],
                'base': [resolve_note(n) for n in found['base']] if found['base'] else []
            }
            p['fragrantica_matched'] = True
            p['fragrantica_url'] = found['url']
            p['fragrantica_reference'] = f"{found['raw_perfume']} by {found['raw_brand']}"
            p['notes_source'] = f"Fragrantica ({found['raw_perfume']})"
        else:
            # STRICT: Not on Fragrantica -> REMOVE all notes
            p['notes'] = {
                'top': [],
                'middle': [],
                'base': []
            }
            p['fragrantica_matched'] = False
            p['fragrantica_url'] = None
            p['fragrantica_reference'] = None
            p['notes_source'] = None
            cleared_count += 1

    print(f"\n=======================================================")
    print(f"FRAGRANTICA HARMONIZATION RESULTS:")
    print(f"  Total catalog products: {total}")
    print(f"  Fragrantica Matched (Kept authentic notes): {matched_count} products")
    print(f"  Not on Fragrantica (Notes completely removed): {cleared_count} products")
    print(f"=======================================================\n")

    # Save to site_data.json
    print(f"Saving updated data to {SITE_DATA_PATH}...")
    with open(SITE_DATA_PATH, 'w', encoding='utf-8') as f:
        json.dump(site_data, f, indent=2, ensure_ascii=False)

    # Sync assets/js/products-data.js
    print(f"Syncing {PRODUCTS_JS_PATH}...")
    js_content = '/**\n * Panna Heera Perfumery - Auto-Generated Product Catalog\n */\nconst PRODUCTS_DATA = ' + json.dumps(products, indent=2, ensure_ascii=False) + ';\n'
    with open(PRODUCTS_JS_PATH, 'w', encoding='utf-8') as f:
        f.write(js_content)

    print("Fragrantica notes synchronization complete!")

if __name__ == '__main__':
    main()
