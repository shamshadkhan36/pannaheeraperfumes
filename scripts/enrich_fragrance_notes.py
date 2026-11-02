import os
import json
import re

BASE_DIR = r'c:\Users\Shamshad\Desktop\panna heera perfume'
DATA_PATH = os.path.join(BASE_DIR, 'data', 'site_data.json')
NOTES_LIB_PATH = os.path.join(BASE_DIR, 'data', 'notes_library.json')

with open(NOTES_LIB_PATH, 'r', encoding='utf-8') as f:
    notes_lib = json.load(f)

NOTE_IMG_MAP = {n['name'].lower(): n['image'] for n in notes_lib}

SYNONYMS = {
    'sicilian lemon': 'lemon', 'italian lemon': 'lemon', 'calabrian bergamot': 'bergamot',
    'grapefruit': 'grapefruit', 'blood orange': 'orange', 'mandarin': 'mandarin orange',
    'mandarin orange': 'mandarin orange', 'bitter orange': 'orange', 'petitgrain': 'orange',
    'cassis': 'black-currant', 'black currant': 'black-currant', 'black cherry': 'sour-cherry',
    'sour cherry': 'sour-cherry', 'wild berries': 'raspberry', 'red berries': 'raspberry',
    'grasse rose': 'rose', 'damask rose': 'rose', 'turkish rose': 'rose', 'bulgarian rose': 'rose',
    'sambac jasmine': 'jasmine', 'white jasmine': 'jasmine', 'french lavender': 'lavender',
    'bourbon vanilla': 'vanilla', 'madagascar vanilla': 'vanilla', 'virginian cedar': 'cedarwood',
    'atlas cedar': 'cedarwood', 'cedar': 'cedarwood', 'mysore sandalwood': 'sandalwood',
    'sandalwood': 'sandalwood', 'haitian vetiver': 'vetiver', 'vetiver': 'vetiver',
    'white musk': 'musk', 'crystal musk': 'musk', 'musk': 'musk', 'ambergris': 'amber',
    'amberwood': 'amber', 'amber': 'amber', 'agarwood': 'oud', 'cambodian oud': 'oud',
    'oud': 'oud', 'cardamom': 'cardamom', 'cinnamon': 'cinnamon', 'pink pepper': 'pink-pepper',
    'black pepper': 'pink-pepper', 'saffron': 'saffron', 'tobacco': 'tobacco leaf',
    'tobacco leaf': 'tobacco leaf', 'coffee': 'coffee', 'cacao': 'cacao / cocoa',
    'cocoa': 'cacao / cocoa', 'tonka': 'tonka bean', 'tonka bean': 'tonka bean',
    'sea notes': 'sea-notes', 'marine notes': 'sea-notes', 'aquatic notes': 'sea-notes',
    'oakmoss': 'oakmoss', 'moss': 'oakmoss', 'patchouli': 'patchouli', 'mint': 'mint',
    'apple': 'apple', 'green apple': 'apple', 'pineapple': 'pineapple', 'peach': 'peach',
    'rosemary': 'rosemary', 'incense': 'incense', 'iris': 'iris', 'violet': 'violet',
    'leather': 'leather', 'wormwood': 'wormwood', 'neroli': 'neroli'
}

def resolve_note(note_name):
    clean = note_name.strip()
    low = clean.lower()
    if low in NOTE_IMG_MAP:
        return {'name': clean, 'image': NOTE_IMG_MAP[low]}
    if low in SYNONYMS:
        syn = SYNONYMS[low]
        if syn.lower() in NOTE_IMG_MAP:
            return {'name': clean, 'image': NOTE_IMG_MAP[syn.lower()]}
    for k, p in NOTE_IMG_MAP.items():
        if k in low or low in k:
            return {'name': clean, 'image': p}
    # Fallback mappings
    if any(w in low for w in ['citrus', 'lime', 'yuzu']):
        return {'name': clean, 'image': 'assets/images/notes/lemon.png'}
    elif any(w in low for w in ['flower', 'blossom', 'petal', 'flora', 'lily', 'freesia', 'orchid']):
        return {'name': clean, 'image': 'assets/images/notes/jasmine.png'}
    elif any(w in low for w in ['berry', 'cherry', 'fruit', 'plum', 'fig', 'currant']):
        return {'name': clean, 'image': 'assets/images/notes/raspberry.png'}
    elif any(w in low for w in ['wood', 'tree', 'pine', 'cypress', 'birch']):
        return {'name': clean, 'image': 'assets/images/notes/cedarwood.png'}
    elif any(w in low for w in ['sweet', 'sugar', 'honey', 'caramel', 'chocolate']):
        return {'name': clean, 'image': 'assets/images/notes/vanilla.png'}
    elif any(w in low for w in ['spice', 'ginger', 'nutmeg', 'clove']):
        return {'name': clean, 'image': 'assets/images/notes/cardamom.png'}
    return {'name': clean, 'image': 'assets/images/notes/amber.png'}

# Curated benchmark pyramids dictionary: (brand/title pattern -> (top, mid, base))
KNOWN_PYRAMIDS = {
    # Armaf
    'CLUB D NUIT': (['Lemon', 'Pineapple', 'Bergamot', 'Black Currant', 'Apple'], ['Birch', 'Jasmine', 'Rose'], ['Musk', 'Ambergris', 'Patchouli', 'Vanilla']),
    'SILLAGE': (['Bergamot', 'Black Currant', 'Lemon', 'Violet'], ['Iris', 'Rose', 'Jasmine'], ['Ambroxan', 'Musk', 'Cedarwood', 'Sandalwood']),
    'TRES NUIT': (['Lemon', 'Iris', 'Lemon'], ['Violet', 'Lavender', 'Spicy Notes'], ['Ambergris', 'Sandalwood']),
    'TAG HIM': (['Grapefruit', 'Lemon', 'Bergamot', 'Pink Pepper'], ['Ginger', 'Mint', 'Nutmeg'], ['Cedarwood', 'Patchouli', 'Sandalwood', 'Vetiver']),
    'ODYSSEY': (['Cacao / Cocoa', 'Coffee', 'Vanilla'], ['Tonka Bean', 'Cinnamon'], ['Amber', 'Sandalwood', 'Caramel']),
    # Ajmal
    'ARISTOCRAT': (['Watermelon', 'Bergamot', 'Lime'], ['Musk', 'Jasmine', 'Lily'], ['Musk', 'Amber', 'Cedarwood', 'Oud', 'Patchouli']),
    '1001 NIGHTS': (['Smoky Notes', 'Spicy Notes'], ['Floral Notes', 'Woody Notes'], ['Oud', 'Amber', 'Musk']),
    'ALF LAIL': (['Smoky Notes', 'Spicy Notes'], ['Floral Notes', 'Woody Notes'], ['Oud', 'Amber', 'Musk']),
    'AMBERWOOD': (['Cardamom', 'Apple', 'White Pepper', 'Lavender'], ['Iris', 'Cedarwood'], ['Amber', 'Woody Notes', 'Patchouli']),
    'WISHAL': (['Floral Notes', 'Fresh Spices'], ['Rose'], ['Sandalwood', 'Musk']),
    'WISAL': (['Floral Notes', 'Fresh Spices'], ['Rose'], ['Sandalwood', 'Musk']),
    'MIZYAAN': (['Floral Notes', 'Spices'], ['Amber', 'Saffron'], ['Musk', 'Woody Notes']),
    'AL SHAMS': (['Oud', 'Woody Notes'], ['Amber', 'Floral Notes'], ['Musk', 'Oud']),
    'BLUE': (['Bergamot', 'Lavender', 'Watermelon'], ['Lotus', 'Jasmine'], ['Sandalwood', 'Amber', 'Musk']),
    'RAINDROP': (['Fruity Notes', 'Floral Notes'], ['Woody Notes'], ['Amber', 'Musk']),
    'AURUM': (['Raspberry', 'Lemon'], ['Gardenia', 'Orange Blossom', 'Jasmine'], ['Vanilla', 'Amber', 'Musk']),
    # Gissah
    'IMPERIAL VALLEY': (['Davana', 'Bergamot', 'Pink Pepper'], ['Amber', 'Rosemary', 'Oud'], ['Leather', 'Vetiver', 'Musk']),
    'SAVA': (['Apple', 'Peach'], ['Jasmine', 'Lily'], ['Sandalwood', 'Vanilla', 'Musk']),
    'HUDSON VALLEY': (['Black Currant', 'Bergamot'], ['Rose', 'Jasmine'], ['Patchouli', 'Amber']),
    'CAPRI': (['Bergamot', 'Mandarin Orange'], ['Sea Notes', 'Neroli'], ['Amber', 'Musk']),
    # CK
    'CK ONE': (['Lemon', 'Bergamot', 'Pineapple', 'Mandarin Orange'], ['Jasmine', 'Violet', 'Rose'], ['Cedarwood', 'Sandalwood', 'Amber', 'Musk']),
    'CK BE': (['Lavender', 'Mint', 'Mandarin Orange'], ['Peach', 'Jasmine'], ['Sandalwood', 'Amber', 'Musk', 'Cedarwood']),
    'ETERNITY': (['Lavender', 'Mandarin Orange', 'Bergamot', 'Lemon'], ['Jasmine', 'Sage', 'Rose'], ['Sandalwood', 'Amber', 'Musk', 'Vetiver']),
    'OBSESSION': (['Vanilla', 'Bergamot', 'Mandarin Orange'], ['Spices', 'Sandalwood', 'Cedarwood'], ['Amber', 'Incense', 'Vanilla', 'Musk']),
    # Boss
    'BOSS BOTTLED': (['Apple', 'Plum', 'Lemon', 'Bergamot'], ['Cinnamon', 'Mahogany'], ['Vanilla', 'Sandalwood', 'Cedarwood', 'Vetiver']),
    'THE SCENT': (['Ginger', 'Mandarin Orange', 'Bergamot'], ['Lavender'], ['Leather', 'Woody Notes']),
    'HUGO MAN': (['Apple', 'Lavender', 'Mint', 'Grapefruit'], ['Sage', 'Geranium', 'Jasmine'], ['Cedarwood', 'Patchouli']),
    # Gucci
    'GUCCI GUILTY': (['Pink Pepper', 'Mandarin Orange', 'Bergamot'], ['Peach', 'Raspberry', 'Jasmine'], ['Patchouli', 'Amber', 'Musk', 'Vanilla']),
    'GUCCI BLOOM': (['Jasmine'], ['Tuberose', 'Jasmine'], ['White Musk', 'Sandalwood']),
    'GUCCI FLORA': (['Pear', 'Raspberry', 'Mandarin Orange'], ['Gardenia', 'Jasmine'], ['Patchouli', 'Brown Sugar']),
    # Jo Malone
    'WOOD SAGE': (['Sea Notes', 'Grapefruit'], ['Sage', 'Sea Notes'], ['Cedarwood', 'Musk']),
    'ENGLISH PEAR': (['Pear', 'Melon'], ['Rose', 'Freesia'], ['Musk', 'Patchouli', 'Amber']),
    'BLACKBERRY': (['Blackberry', 'Grapefruit'], ['Bay Leaf', 'Floral Notes'], ['Cedarwood', 'Vetiver']),
    # Davidoff
    'COOL WATER': (['Sea Notes', 'Mint', 'Lavender', 'Rosemary'], ['Sandalwood', 'Jasmine', 'Neroli'], ['Tobacco Leaf', 'Musk', 'Cedarwood', 'Oakmoss', 'Amber']),
    # Victoria's Secret
    'BOMBSHELL': (['Passion Fruit', 'Grapefruit', 'Pineapple', 'Strawberry'], ['Peony', 'Vanilla', 'Raspberry', 'Jasmine'], ['Musk', 'Oakmoss']),
    'PURE SEDUCTION': (['Plum', 'Melon'], ['Freesia', 'Floral Notes'], ['Musk', 'Vanilla']),
    'BARE VANILLA': (['Vanilla', 'Whipped Cream'], ['Apple', 'Cashmere'], ['Sandalwood', 'Musk']),
    # Montblanc
    'LEGEND': (['Lavender', 'Pineapple', 'Bergamot', 'Lemon'], ['Apple', 'Oakmoss', 'Rose'], ['Tonka Bean', 'Sandalwood']),
    'EXPLORER': (['Bergamot', 'Pink Pepper'], ['Vetiver', 'Leather'], ['Ambroxan', 'Patchouli', 'Cacao / Cocoa']),
    'INDIVIDUEL': (['Cinnamon', 'Lavender', 'Pineapple', 'Mint', 'Bergamot'], ['Orange', 'Violet', 'Jasmine'], ['Raspberry', 'Vanilla', 'Sandalwood', 'Musk']),
    # Jean Paul Gaultier
    'ULTRA MALE': (['Pear', 'Lavender', 'Mint', 'Bergamot', 'Lemon'], ['Cinnamon', 'Sage'], ['Vanilla', 'Amber', 'Cedarwood', 'Patchouli']),
    'LE MALE': (['Lavender', 'Mint', 'Cardamom', 'Bergamot'], ['Cinnamon', 'Orange'], ['Vanilla', 'Tonka Bean', 'Amber', 'Sandalwood', 'Cedarwood']),
    'SCANDAL': (['Mandarin Orange', 'Orange'], ['Honey', 'Peach', 'Jasmine'], ['Caramel', 'Patchouli']),
    # Kayali
    'VANILLA 28': (['Vanilla', 'Jasmine'], ['Tonka Bean', 'Brown Sugar'], ['Amber', 'Patchouli', 'Musk']),
    'EDEN JUICY APPLE': (['Apple', 'Black Currant', 'Grapefruit'], ['Raspberry', 'Jasmine'], ['Vanilla', 'Amber', 'Musk']),
    # Dolce & Gabbana
    'LIGHT BLUE': (['Lemon', 'Apple', 'Cedarwood'], ['Bamboo', 'Jasmine', 'Rose'], ['Cedarwood', 'Musk', 'Amber']),
    'THE ONE': (['Grapefruit', 'Coriander', 'Basil'], ['Cardamom', 'Ginger', 'Orange'], ['Amber', 'Tobacco Leaf', 'Cedarwood']),
    # Prada
    'PARADOXE': (['Pear', 'Tangerine', 'Bergamot'], ['Orange', 'Jasmine', 'Neroli'], ['Vanilla', 'Musk', 'Amber']),
    'LUNA ROSSA': (['Lavender', 'Orange'], ['Mint', 'Sage'], ['Amber', 'Musk']),
    # Abercrombie
    'FIERCE': (['Cardamom', 'Lemon', 'Orange'], ['Rosemary', 'Jasmine', 'Rose'], ['Musk', 'Vetiver', 'Sandalwood']),
    # Armani
    'IN LOVE WITH YOU': (['Raspberry', 'Black Currant', 'Sour Cherry'], ['Rose', 'Jasmine', 'Wormwood'], ['Patchouli']),
    'AQUA DI GIO': (['Lime', 'Lemon', 'Bergamot'], ['Sea Notes', 'Rosemary', 'Jasmine'], ['White Musk', 'Cedarwood', 'Patchouli']),
    'AQUA DI ESSENZA': (['Bergamot', 'Grapefruit', 'Sea Notes'], ['Jasmine', 'Floral Notes', 'Basil'], ['Patchouli', 'Cedarwood', 'Amber']),
    'AQUA DI PROFUMO': (['Bergamot', 'Sea Notes'], ['Rosemary', 'Incense'], ['Patchouli', 'Incense']),
    'ARMANI CODE': (['Bergamot', 'Lemon'], ['Star Anise', 'Olive Blossom'], ['Leather', 'Tobacco Leaf', 'Tonka Bean']),
    'CODE ABSOLU': (['Green Apple', 'Mandarin Orange'], ['Nutmeg', 'Orange Blossom', 'Carrot Seeds'], ['Vanilla', 'Tonka Bean', 'Suede']),
    'STRONGER WITH YOU': (['Cardamom', 'Pink Pepper', 'Mint'], ['Pineapple', 'Melon', 'Sage'], ['Vanilla', 'Chestnut', 'Cedarwood']),
    'SI': (['Cassis', 'Black Currant'], ['Rose', 'Freesia'], ['Vanilla', 'Patchouli', 'Woody Notes']),
    'MY WAY': (['Orange Blossom', 'Bergamot'], ['Tuberose', 'Jasmine'], ['Vanilla', 'White Musk', 'Cedarwood']),
    'OUD ROYALE': (['Saffron', 'Incense'], ['Oud', 'Rose'], ['Amber', 'Sandalwood', 'Patchouli']),
    # Creed
    'AVENTUS': (['Pineapple', 'Bergamot', 'Black Currant', 'Apple'], ['Birch', 'Patchouli', 'Moroccan Jasmine', 'Rose'], ['Musk', 'Oakmoss', 'Ambergris', 'Vanilla']),
    'SILVER MOUNTAIN': (['Bergamot', 'Mandarin Orange'], ['Green Tea', 'Black Currant'], ['Musk', 'Petitgrain', 'Sandalwood']),
    'GREEN IRISH TWEED': (['Lemon Verbena', 'Iris'], ['Violet Leaf'], ['Ambergris', 'Sandalwood']),
    'MILLISIME IMPERIAL': (['Fruity Notes', 'Sea Salt'], ['Sicilian Lemon', 'Bergamot', 'Iris'], ['Sea Notes', 'Musk', 'Woody Notes']),
    'VIRGIN ISLAND': (['Coconut', 'Lime', 'White Bergamot'], ['Ginger', 'Ylang-Ylang', 'Jasmine'], ['White Rum', 'Sugar Cane', 'Musk']),
    'ROYAL OUD': (['Pink Pepper', 'Lemon', 'Sicilian Bergamot'], ['Cedarwood', 'Angelica', 'Galbanum'], ['Sandalwood', 'Oud', 'Musk']),
    # Dior
    'SAUVAGE': (['Calabrian Bergamot', 'Pepper'], ['Sichuan Pepper', 'Lavender', 'Pink Pepper', 'Vetiver'], ['Ambroxan', 'Cedarwood', 'Labdanum']),
    'SAUVAGE ELIXIR': (['Nutmeg', 'Cinnamon', 'Cardamom', 'Grapefruit'], ['Lavender'], ['Licorice', 'Sandalwood', 'Amber', 'Patchouli', 'Haitian Vetiver']),
    'FAHRENHEIT': (['Nutmeg Flower', 'Lavender', 'Cedarwood', 'Mandarin'], ['Violet Leaf', 'Nutmeg', 'Carnation', 'Sandalwood'], ['Leather', 'Vetiver', 'Musk', 'Amber']),
    'DIOR HOMME': (['Lavender', 'Bergamot', 'Sage'], ['Iris', 'Cacao', 'Amber'], ['Leather', 'Patchouli', 'Vetiver']),
    'JADORE': (['Pear', 'Melon', 'Magnolia', 'Peach', 'Mandarin'], ['Jasmine', 'Lily-of-the-Valley', 'Tuberose', 'Freesia', 'Rose'], ['Musk', 'Vanilla', 'Cedarwood', 'Blackberry']),
    'JOY': (['Bergamot', 'Mandarin Orange'], ['Grasse Rose', 'Jasmine', 'Cassis', 'Peach'], ['White Musk', 'Sandalwood', 'Cedarwood', 'Patchouli']),
    'OUD ISPAHAN': (['Labdanum'], ['Rose', 'Patchouli', 'Saffron'], ['Oud', 'Sandalwood', 'Cedarwood']),
    # Tom Ford
    'TOBACCO VANILLE': (['Tobacco Leaf', 'Spicy Notes'], ['Vanilla', 'Cacao', 'Tonka Bean', 'Tobacco Blossom'], ['Dried Fruits', 'Woody Notes']),
    'OUD WOOD': (['Rosewood', 'Cardamom', 'Chinese Pepper'], ['Oud', 'Sandalwood', 'Vetiver'], ['Tonka Bean', 'Vanilla', 'Amber']),
    'BLACK ORCHID': (['Truffle', 'Gardenia', 'Black Currant', 'Ylang-Ylang'], ['Orchid', 'Spices', 'Gardenia', 'Fruity Notes'], ['Mexican Chocolate', 'Patchouli', 'Vanilla', 'Incense', 'Amber']),
    'OMBRE LEATHER': (['Cardamom'], ['Leather', 'Jasmine Sambac'], ['Amber', 'Moss', 'Patchouli']),
    'TUSCAN LEATHER': (['Raspberry', 'Saffron', 'Thyme'], ['Olibanum', 'Jasmine'], ['Leather', 'Suede', 'Amber', 'Woody Notes']),
    'LOST CHERRY': (['Sour Cherry', 'Bitter Almond', 'Liquor'], ['Sour Cherry', 'Plum', 'Turkish Rose', 'Jasmine'], ['Tonka Bean', 'Vanilla', 'Peru Balsam', 'Cinnamon', 'Sandalwood', 'Cedarwood']),
    'NEROLI PORTOFINO': (['Bergamot', 'Mandarin Orange', 'Lemon', 'Bitter Orange'], ['African Orange Flower', 'Neroli', 'Jasmine'], ['Amber', 'Angelica', 'Ambrette']),
    'CAFE ROSE': (['May Rose', 'Saffron', 'Black Pepper'], ['Turkish Rose', 'Bulgarian Rose', 'Coffee'], ['Patchouli', 'Incense', 'Sandalwood', 'Amber']),
    # MFK
    'BACCARAT ROUGE': (['Saffron', 'Jasmine'], ['Amberwood', 'Ambergris'], ['Fir Resin', 'Cedarwood']),
    'GRAND SOIR': (['Spanish Labdanum'], ['Benzoin Siam'], ['Brazilian Tonka Bean', 'Vanilla', 'Amber']),
    'OUD SATIN MOOD': (['Bulgarian Rose', 'Turkish Rose'], ['Violet', 'Laotian Oud'], ['Vanilla', 'Amber', 'Benzoin']),
    # Chanel
    'BLEU DE CHANEL': (['Grapefruit', 'Lemon', 'Mint', 'Pink Pepper'], ['Ginger', 'Nutmeg', 'Jasmine', 'Iso E Super'], ['Incense', 'Vetiver', 'Cedarwood', 'Sandalwood', 'Patchouli']),
    'COCO MADEMOISELLE': (['Orange', 'Mandarin Orange', 'Bergamot'], ['Turkish Rose', 'Jasmine', 'Mimosa', 'Ylang-Ylang'], ['Patchouli', 'White Musk', 'Vanilla', 'Vetiver', 'Tonka Bean']),
    'ALLURE HOMME SPORT': (['Orange', 'Sea Notes', 'Aldehydes', 'Blood Mandarin'], ['Pepper', 'Neroli', 'Cedarwood'], ['Tonka Bean', 'Vanilla', 'White Musk', 'Amber', 'Vetiver']),
    'PLATINUM EGOISTE': (['Rosemary', 'Lavender', 'Neroli', 'Petitgrain'], ['Galbanum', 'Clary Sage', 'Jasmine', 'Geranium'], ['Oakmoss', 'Vetiver', 'Cedarwood', 'Sandalwood', 'Amber']),
    # Paco Rabanne
    '1 MILLION': (['Blood Mandarin', 'Grapefruit', 'Mint'], ['Cinnamon', 'Spicy Notes', 'Rose'], ['Amber', 'Leather', 'Woody Notes', 'Indian Patchouli']),
    'INVICTUS': (['Sea Notes', 'Grapefruit', 'Mandarin Orange'], ['Bay Leaf', 'Jasmine'], ['Ambergris', 'Guaiac Wood', 'Oakmoss', 'Patchouli']),
    'OLYMPEA': (['Water Jasmine', 'Green Mandarin', 'Ginger Lily'], ['Salt', 'Vanilla'], ['Ambergris', 'Cashmere Wood', 'Sandalwood']),
    # Versace
    'EROS': (['Mint', 'Green Apple', 'Lemon'], ['Tonka Bean', 'Ambroxan', 'Geranium'], ['Madagascar Vanilla', 'Virginian Cedarwood', 'Atlas Cedar', 'Vetiver', 'Oakmoss']),
    'DYLAN BLUE': (['Calabrian Bergamot', 'Water Notes', 'Grapefruit', 'Fig Leaf'], ['Ambroxan', 'Black Pepper', 'Patchouli', 'Violet Leaf'], ['Incense', 'Musk', 'Tonka Bean', 'Saffron']),
    'BRIGHT CRYSTAL': (['Yuzu', 'Pomegranate', 'Ice'], ['Peony', 'Lotus', 'Magnolia'], ['Musk', 'Mahogany', 'Amber']),
    # YSL
    'BLACK OPIUM': (['Pear', 'Pink Pepper', 'Orange Blossom'], ['Coffee', 'Jasmine', 'Bitter Almond', 'Licorice'], ['Vanilla', 'Patchouli', 'Cashmere Wood', 'Cedarwood']),
    'LIBRE': (['Lavender', 'Mandarin Orange', 'Black Currant', 'Petitgrain'], ['Lavender', 'Orange Blossom', 'Jasmine'], ['Madagascar Vanilla', 'Musk', 'Cedarwood', 'Ambergris']),
    'Y EDP': (['Apple', 'Ginger', 'Bergamot'], ['Sage', 'Juniper Berries', 'Geranium'], ['Amberwood', 'Tonka Bean', 'Cedarwood', 'Vetiver', 'Olibanum']),
    'LA NUIT': (['Cardamom'], ['Lavender', 'Virginia Cedar', 'Bergamot'], ['Vetiver', 'Caraway']),
    # Carolina Herrera
    'GOOD GIRL': (['Almond', 'Coffee', 'Bergamot', 'Lemon'], ['Tuberose', 'Jasmine Sambac', 'Orange Blossom', 'Orris', 'Bulgarian Rose'], ['Tonka Bean', 'Cacao', 'Vanilla', 'Praline', 'Sandalwood', 'Musk', 'Amber', 'Cashmere Wood']),
    'BAD BOY': (['White Pepper', 'Black Pepper', 'Bergamot'], ['Cedarwood', 'Sage'], ['Tonka Bean', 'Cacao', 'Amberwood']),
    '212 VIP': (['Passionfruit', 'Rum'], ['Musk', 'Gardenia'], ['Tonka Bean', 'Vanilla']),
    # Parfums de Marly
    'LAYTON': (['Apple', 'Lavender', 'Bergamot', 'Mandarin Orange'], ['Geranium', 'Violet', 'Jasmine'], ['Vanilla', 'Cardamom', 'Sandalwood', 'Pepper', 'Patchouli', 'Guaiac Wood']),
    'DELINA': (['Lychee', 'Rhubarb', 'Bergamot', 'Nutmeg'], ['Turkish Rose', 'Peony', 'Musk', 'Petalia', 'Vanilla'], ['Cashmeran', 'Cedarwood', 'Haitian Vetiver', 'Incense']),
    'HEROD': (['Cinnamon', 'Pepperwood'], ['Tobacco Leaf', 'Incense', 'Osmanthus', 'Labdanum'], ['Vanilla', 'Iso E Super', 'Cedarwood', 'Musk', 'Cypriol']),
    # Kilian
    'ANGELS SHARE': (['Cognac'], ['Cinnamon', 'Tonka Bean', 'Oak'], ['Praline', 'Vanilla', 'Sandalwood']),
    'BLACK PHANTOM': (['Rum', 'Sugar Cane'], ['Dark Chocolate', 'Coffee', 'Caramel', 'Almond'], ['Heliotrope', 'Sandalwood']),
    # Louis Vuitton
    'OMBRE NOMADE': (['Oud', 'Incense'], ['Rose', 'Raspberry', 'Saffron'], ['Benzoin', 'Amberwood', 'Geranium']),
    'IMAGINATION': (['Citron', 'Calabrian Bergamot', 'Sicilian Orange'], ['Tunisian Neroli', 'Nigerian Ginger', 'Ceylon Cinnamon'], ['Chinese Black Tea', 'Ambroxan', 'Olibanum', 'Guaiac Wood']),
    'AFTERNOON SWIM': (['Mandarin Orange', 'Sicilian Orange'], ['Bergamot'], ['Ambergris']),
    # Mancera
    'CEDRAT BOISE': (['Sicilian Lemon', 'Black Currant', 'Bergamot', 'Spicy Notes'], ['Fruity Notes', 'Patchouli Leaf', 'Water Jasmine'], ['Cedarwood', 'Leather', 'Sandalwood', 'Vanilla', 'White Musk']),
    'RED TOBACCO': (['Cinnamon', 'Oud', 'Incense', 'Saffron', 'Nutmeg', 'Green Apple', 'White Peach'], ['Patchouli', 'Jasmine'], ['Tobacco', 'Madagascar Vanilla', 'Amber', 'Sandalwood', 'Guaiac Wood', 'White Musk', 'Haitian Vetiver']),
    # Lattafa
    'KHAMRAH': (['Cinnamon', 'Nutmeg', 'Bergamot'], ['Dates', 'Praline', 'Tuberose', 'Mahonial'], ['Vanilla', 'Tonka Bean', 'Benzoin', 'Myrrh', 'Amberwood', 'Akigalawood']),
    'ASAD': (['Black Pepper', 'Pineapple', 'Tobacco'], ['Coffee', 'Patchouli', 'Iris'], ['Amber', 'Vanilla', 'Woody Notes', 'Benzoin', 'Labdanum']),
    'YARA': (['Heliotrope', 'Orchid', 'Tangerine'], ['Gourmand Accord', 'Tropical Fruits'], ['Vanilla', 'Sandalwood', 'Musk']),
    'COOKE CRAVE': (['Vanilla', 'Almond', 'Sugar'], ['Praline', 'Cacao', 'Tonka Bean'], ['Caramel', 'Amber', 'Musk']),
    # Rasasi
    'HAWAS': (['Apple', 'Bergamot', 'Lemon', 'Cinnamon'], ['Watery Notes', 'Plum', 'Orange Blossom', 'Cardamom'], ['Ambergris', 'Musk', 'Patchouli', 'Driftwood']),
    'LA YUQUAWAM': (['Raspberry', 'Saffron', 'Thyme'], ['Olibanum', 'Jasmine', 'Artemisia'], ['Leather', 'Suede', 'Amber', 'Woody Notes']),
    # Swiss Arabian
    'SHAGHAF OUD': (['Saffron'], ['Oud', 'Rose'], ['Oud', 'Praline', 'Vanilla']),
    # Al Rehab
    'CHOCO MUSK': (['Milk Chocolate', 'White Musk'], ['Vanilla', 'Cinnamon'], ['Amber', 'Sandalwood', 'Myrrh']),
    'SILVER': (['Citrus', 'Sea Notes'], ['Green Tea', 'Black Currant'], ['Musk', 'Sandalwood']),
    # Traditional Oud & Mukhallats
    'KASHMIRI OUD': (['Saffron', 'Rose'], ['Kashmiri Oud', 'Amber', 'Cardamom'], ['Sandalwood', 'Musk', 'Patchouli']),
    'WHITE OUD': (['White Musk', 'Bergamot'], ['Lily', 'Jasmine', 'Soft Oud'], ['White Amber', 'Sandalwood', 'Cedarwood']),
    'PURPLE OUD': (['Saffron', 'Pink Pepper'], ['Rose', 'Violet', 'Cambodian Oud'], ['Amber', 'White Musk', 'Patchouli']),
    'ROYAL OUD': (['Citrus', 'Cardamom'], ['Assam Oud', 'Rose'], ['Sandalwood', 'Ambergris', 'Musk']),
    'MUKHALLAT': (['Rose', 'Saffron'], ['Amber', 'Oud', 'Cardamom'], ['Sandalwood', 'Musk', 'Frankincense']),
    'AMBER OUD': (['Amber', 'Bergamot'], ['Agarwood (Oud)', 'Cedarwood'], ['Vanilla', 'Musk', 'Sandalwood']),
    'DEHN AL OUD': (['Spicy Wood', 'Saffron'], ['Aged Assam Oud', 'Leather'], ['Earthy Oud', 'Amber', 'Musk']),
    'ROSE TAIF': (['Taif Rose', 'Bergamot'], ['Damascena Rose', 'Geranium'], ['White Musk', 'Amber', 'Sandalwood']),
    # Fruit Collection
    'LITCHI': (['Lychee', 'Mandarin Orange'], ['Rose', 'Peony', 'Raspberry'], ['White Musk', 'Vanilla', 'Cedarwood']),
    'MANGO': (['Mango', 'Passion Fruit', 'Peach'], ['Jasmine', 'Ylang-Ylang'], ['Vanilla', 'White Musk', 'Coconut']),
    'BLACKBERRY': (['Blackberry', 'Black Currant', 'Lemon'], ['Jasmine', 'Rose'], ['White Musk', 'Cedarwood', 'Vanilla']),
    'PINEAPPLE': (['Pineapple', 'Bergamot'], ['Apple', 'Patchouli'], ['Ambergris', 'Vanilla', 'Musk']),
    'STRAWBERRY': (['Wild Strawberry', 'Raspberry'], ['Jasmine', 'Violet'], ['Vanilla', 'White Musk']),
    'GREEN APPLE': (['Green Apple', 'Cucumber', 'Grapefruit'], ['Magnolia', 'Tuberose', 'Rose'], ['Sandalwood', 'Amber'])
}

# Category general templates for unmatched items
CATEGORY_FALLBACKS = {
    'oriental-arabic': (
        ['Saffron', 'Bergamot', 'Rose'],
        ['Oud', 'Amber', 'Cardamom'],
        ['Sandalwood', 'Musk', 'Patchouli']
    ),
    'niche-luxury': (
        ['Calabrian Bergamot', 'Cardamom', 'Pink Pepper'],
        ['Iris', 'Leather', 'Cedarwood'],
        ['Amber', 'Vanilla', 'Haitian Vetiver', 'White Musk']
    ),
    'floral-botanical': (
        ['Bergamot', 'Mandarin Orange', 'Neroli'],
        ['Grasse Rose', 'Jasmine', 'Lily-of-the-Valley'],
        ['White Musk', 'Sandalwood', 'Cedarwood']
    ),
    'fruits-gourmand': (
        ['Raspberry', 'Peach', 'Mandarin Orange'],
        ['Vanilla', 'Praline', 'Tonka Bean'],
        ['Caramel', 'White Musk', 'Amber']
    ),
    'designer-fragrance': (
        ['Bergamot', 'Lemon', 'Apple'],
        ['Lavender', 'Rosemary', 'Geranium'],
        ['Cedarwood', 'Patchouli', 'White Musk', 'Amber']
    )
}

def get_notes_for_product(product):
    title = (product.get('title') or '').upper()
    short = (product.get('short_title') or '').upper()
    brand = (product.get('brand') or '').upper()
    cat = product.get('category', 'designer-fragrance')
    
    # 1. Search in KNOWN_PYRAMIDS by keyword
    for key, (top, mid, base) in KNOWN_PYRAMIDS.items():
        if key in short or key in title or (key in brand and len(key) > 4):
            return {
                'top': [resolve_note(n) for n in top],
                'middle': [resolve_note(n) for n in mid],
                'base': [resolve_note(n) for n in base]
            }
            
    # 2. Check title cues
    if 'OUD' in title or 'AGAR' in title:
        return {
            'top': [resolve_note('Saffron'), resolve_note('Bergamot'), resolve_note('Rose')],
            'middle': [resolve_note('Oud'), resolve_note('Amber'), resolve_note('Cardamom')],
            'base': [resolve_note('Sandalwood'), resolve_note('Musk'), resolve_note('Patchouli')]
        }
    elif 'ROSE' in title:
        return {
            'top': [resolve_note('Bergamot'), resolve_note('Pink Pepper'), resolve_note('Mandarin Orange')],
            'middle': [resolve_note('Grasse Rose'), resolve_note('Jasmine'), resolve_note('Violet')],
            'base': [resolve_note('Patchouli'), resolve_note('White Musk'), resolve_note('Amber')]
        }
    elif 'VANILLA' in title or 'CHOCO' in title or 'CARAMEL' in title:
        return {
            'top': [resolve_note('Almond'), resolve_note('Orange')],
            'middle': [resolve_note('Vanilla'), resolve_note('Tonka Bean'), resolve_note('Cacao / Cocoa')],
            'base': [resolve_note('Caramel'), resolve_note('Sandalwood'), resolve_note('Amber')]
        }
    elif any(w in title for w in ['AQUA', 'BLUE', 'WATER', 'MARINE', 'SPORT', 'FRESH']):
        return {
            'top': [resolve_note('Lemon'), resolve_note('Bergamot'), resolve_note('Grapefruit')],
            'middle': [resolve_note('Sea Notes'), resolve_note('Rosemary'), resolve_note('Lavender')],
            'base': [resolve_note('Cedarwood'), resolve_note('White Musk'), resolve_note('Patchouli')]
        }
    elif 'LEATHER' in title or 'BLACK' in title or 'NOIR' in title:
        return {
            'top': [resolve_note('Cardamom'), resolve_note('Bergamot'), resolve_note('Pink Pepper')],
            'middle': [resolve_note('Leather'), resolve_note('Incense'), resolve_note('Iris')],
            'base': [resolve_note('Patchouli'), resolve_note('Amber'), resolve_note('Vetiver')]
        }

    # 3. Category Fallback
    top, mid, base = CATEGORY_FALLBACKS.get(cat, CATEGORY_FALLBACKS['designer-fragrance'])
    return {
        'top': [resolve_note(n) for n in top],
        'middle': [resolve_note(n) for n in mid],
        'base': [resolve_note(n) for n in base]
    }

def main():
    print(f"Reading {DATA_PATH}...")
    with open(DATA_PATH, 'r', encoding='utf-8') as f:
        site_data = json.load(f)

    products = site_data.get('products', [])
    total = len(products)
    print(f"Total products to enrich with Olfactory Pyramids: {total}")

    enriched = 0
    for p in products:
        p_notes = get_notes_for_product(p)
        p['notes'] = p_notes
        enriched += 1

    print(f"Successfully enriched {enriched}/{total} products with full Top, Heart, Base notes!")

    # Save to site_data.json
    print(f"Writing updated data to {DATA_PATH}...")
    with open(DATA_PATH, 'w', encoding='utf-8') as f:
        json.dump(site_data, f, indent=2, ensure_ascii=False)

    print("Fragrance notes enrichment complete!")

if __name__ == '__main__':
    main()
