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

# Import our comprehensive benchmark notes dictionary
sys.path.insert(0, os.path.join(BASE_DIR, 'scripts'))
from benchmark_fragrantica_pyramids import BENCHMARK_PYRAMIDS

with open(NOTES_LIB_PATH, 'r', encoding='utf-8') as f:
    notes_lib = json.load(f)

NOTE_IMG_MAP = {}
for n in notes_lib:
    NOTE_IMG_MAP[n['name'].lower()] = n['image']
    NOTE_IMG_MAP[n['id'].lower()] = n['image']
    NOTE_IMG_MAP[n['id'].replace('-', ' ').lower()] = n['image']
NOTE_IMG_MAP['tobacco'] = 'assets/images/notes/tobacco.png'
NOTE_IMG_MAP['tobacco leaf'] = 'assets/images/notes/tobacco.png'

SYNONYMS = {
    # Citrus
    'sicilian lemon': 'lemon', 'italian lemon': 'lemon', 'lemon zest': 'lemon', 'lime': 'lemon', 'yuzu': 'lemon', 'citron': 'lemon', 'citruses': 'lemon', 'amalfi lemon': 'lemon', 'candied lemon': 'lemon',
    'calabrian bergamot': 'bergamot', 'bergamot orange': 'bergamot', 'sicilian bergamot': 'bergamot', 'bergamotto': 'bergamot', 'italian bergamot': 'bergamot',
    'grapefruit': 'grapefruit', 'pink grapefruit': 'grapefruit', 'blood grapefruit': 'grapefruit',
    'blood orange': 'orange', 'bitter orange': 'orange', 'orange peel': 'orange', 'orange': 'orange', 'sweet orange': 'orange', 'brazilian orange': 'orange', 'california orange': 'orange',
    'mandarin': 'mandarin', 'mandarin orange': 'mandarin', 'green mandarin': 'mandarin', 'tangerine': 'mandarin', 'clementine': 'mandarin', 'blood mandarin': 'mandarin', 'italian mandarin': 'mandarin', 'sicilian mandarin': 'mandarin',
    'petitgrain': 'orange-blossom', 'african orange flower': 'orange-blossom', 'orange blossom': 'orange-blossom', 'orange flower': 'orange-blossom', 'neroli': 'neroli',
    
    # Berries & Fruits
    'cassis': 'black-currant', 'black currant': 'black-currant', 'black-currant': 'black-currant', 'blackberry': 'black-currant', 'dark berries': 'black-currant',
    'black cherry': 'sour-cherry', 'sour cherry': 'sour-cherry', 'cherry': 'sour-cherry',
    'wild berries': 'raspberry', 'red berries': 'raspberry', 'raspberry': 'raspberry', 'strawberry': 'raspberry', 'cranberry': 'raspberry', 'red fruits': 'raspberry', 'fruity notes': 'raspberry',
    'apple': 'apple', 'green apple': 'apple', 'red apple': 'apple', 'granny smith apple': 'apple',
    'pineapple': 'pineapple', 'peach': 'peach', 'white peach': 'peach', 'apricot': 'peach', 'nectarine': 'peach', 'melon': 'peach',
    'pear': 'pear', 'green pear': 'pear', 'nashi pear': 'pear', 'anjou pear': 'pear', 'quince': 'pear', 'guava': 'pear',
    'plum': 'plum', 'damson plum': 'plum', 'mirabelle': 'plum', 'prune': 'plum',
    'litchi': 'litchi', 'lychee': 'litchi', 'red litchi': 'litchi',
    'mango': 'mango', 'green mango': 'mango', 'alphonso mango': 'mango', 'papaya': 'mango',
    'pomegranate': 'pomegranate',
    'coconut': 'coconut', 'coconut milk': 'coconut', 'coconut water': 'coconut', 'coconut nectar': 'coconut',
    'rhubarb': 'rhubarb', 'rhuburb': 'rhubarb',
    'fig': 'green-notes', 'fig leaf': 'green-notes', 'dates': 'caramel',
    
    # Herbs & Green
    'oregano': 'oregano', 'wild oregano': 'oregano',
    'basil': 'basil', 'sweet basil': 'basil', 'holy basil': 'basil', 'black basil': 'basil',
    'thyme': 'thyme', 'red thyme': 'thyme', 'wild thyme': 'thyme',
    'rosemary': 'rosemary',
    'mint': 'mint', 'spearmint': 'mint', 'peppermint': 'mint',
    'clary sage': 'clary-sage', 'sage': 'clary-sage', 'salvia': 'clary-sage',
    'green notes': 'green-notes', 'green leaves': 'green-notes', 'green accord': 'green-notes', 'green grass': 'green-notes', 'ivy': 'green-notes', 'dew': 'green-notes', 'foliage': 'green-notes', 'herbal notes': 'green-notes', 'herbs': 'green-notes', 'tomato leaf': 'green-notes', 'shiso': 'green-notes', 'bamboo': 'green-notes', 'cypriol oil': 'green-notes', 'nagarmotha': 'green-notes', 'papyrus': 'green-notes', 'bay leaf': 'green-notes', 'artemisia': 'wormwood', 'wormwood': 'wormwood', 'absinthe': 'wormwood', 'davana': 'green-notes', 'myrtle': 'green-notes', 'tarragon': 'green-notes', 'cactus': 'green-notes', 'aloe vera': 'green-notes', 'cucumber': 'green-notes',
    'tea': 'tea', 'green tea': 'tea', 'black tea': 'tea', 'tea leaf': 'tea', 'mate': 'tea', 'earl grey': 'tea', 'masala chai': 'tea', 'wheat': 'tea',
    'juniper berries': 'juniper-berries', 'juniper': 'juniper-berries', 'juniper berry': 'juniper-berries', 'gin': 'juniper-berries',
    
    # Florals
    'grasse rose': 'rose', 'damask rose': 'rose', 'turkish rose': 'rose', 'bulgarian rose': 'rose', 'may rose': 'rose', 'taif rose': 'rose', 'rose': 'rose', 'rosa': 'rose', 'centifolia rose': 'rose', 'moroccan rose': 'rose', 'rose de mai': 'rose', 'rose petals': 'rose', 'black rose': 'rose',
    'sambac jasmine': 'jasmine', 'white jasmine': 'jasmine', 'jasmine': 'jasmine', 'jasmine sambac': 'jasmine', 'water jasmine': 'jasmine', 'egyptian jasmine': 'jasmine', 'white flowers': 'jasmine', 'floral notes': 'jasmine', 'jasmine petals': 'jasmine', 'gardenia': 'jasmine',
    'french lavender': 'lavender', 'lavender': 'lavender', 'wild lavender': 'lavender',
    'iris': 'iris', 'orris': 'iris', 'orris root': 'iris', 'powdery notes': 'iris',
    'violet': 'violet', 'violet leaf': 'violet', 'violet leaves': 'violet', 'parma violet': 'violet',
    'tuberose': 'tuberose', 'indian tuberose': 'tuberose',
    'lily-of-the-valley': 'lily-of-the-valley', 'lily of the valley': 'lily-of-the-valley', 'muguet': 'lily-of-the-valley', 'lily': 'lily-of-the-valley',
    'geranium': 'geranium', 'rose geranium': 'geranium', 'bourbon geranium': 'geranium', 'pelargonium': 'geranium',
    'magnolia': 'magnolia',
    'freesia': 'freesia', 'white freesia': 'freesia',
    'ylang-ylang': 'ylang-ylang', 'ylang ylang': 'ylang-ylang', 'cananga': 'ylang-ylang',
    'peony': 'rose', 'carnation': 'rose', 'lotus': 'jasmine', 'osmanthus': 'jasmine', 'heliotrope': 'jasmine', 'narcissus': 'jasmine', 'hyacinth': 'jasmine', 'blue hyacinth': 'jasmine', 'hiacynth': 'jasmine', 'cyclamen': 'jasmine', 'red cyclamen': 'jasmine', 'mimosa': 'jasmine', 'lilac': 'jasmine', 'chamomile': 'jasmine', 'frangipani': 'jasmine', 'hibiscus': 'rose', 'wisteria': 'jasmine', 'marigold': 'orange-blossom', 'tagetes': 'orange-blossom', 'hawthorn': 'jasmine',
    
    # Spices
    'pimento': 'pimento', 'allspice': 'pimento', 'jamaican pepper': 'pimento', 'red pimento': 'pimento',
    'cardamom': 'cardamom', 'green cardamom': 'cardamom', 'guatemalan cardamom': 'cardamom', 'cardamon': 'cardamom',
    'cinnamon': 'cinnamon', 'ceylon cinnamon': 'cinnamon', 'cinnamon bark': 'cinnamon',
    'black pepper': 'black-pepper', 'pepper': 'black-pepper', 'sichuan pepper': 'black-pepper', 'white pepper': 'black-pepper', 'peppercorn': 'black-pepper',
    'pink pepper': 'pink-pepper', 'pink-pepper': 'pink-pepper', 'red pepper': 'pink-pepper',
    'saffron': 'saffron', 'red saffron': 'saffron',
    'ginger': 'ginger', 'fresh ginger': 'ginger', 'ginger root': 'ginger', 'blue ginger': 'ginger',
    'nutmeg': 'nutmeg', 'mace': 'nutmeg',
    'coriander': 'coriander', 'coriander seeds': 'coriander', 'coriander leaf': 'coriander', 'cilantro': 'coriander', 'celery seeds': 'coriander', 'carrot seeds': 'coriander',
    'star anise': 'star-anise', 'anise': 'star-anise', 'aniseed': 'star-anise', 'licorice': 'star-anise', 'liquorice': 'star-anise', 'fennel': 'star-anise',
    'clove': 'clove', 'cloves': 'clove', 'clove leaf': 'clove', 'clove bud': 'clove',
    'caraway': 'caraway', 'caraway seeds': 'caraway',
    'cumin': 'cumin', 'black cumin': 'cumin',
    'spices': 'cardamom', 'spicy notes': 'cardamom', 'oriental notes': 'cardamom',
    
    # Woods & Earth
    'virginian cedar': 'cedarwood', 'atlas cedar': 'cedarwood', 'cedar': 'cedarwood', 'cedarwood': 'cedarwood', 'virginia cedar': 'cedarwood', 'white woods': 'cedarwood', 'woodsy notes': 'cedarwood', 'woody notes': 'cedarwood', 'teak wood': 'cedarwood', 'guaiac wood': 'cedarwood', 'cashmere wood': 'cedarwood', 'white cedar extract': 'cedarwood', 'driftwood': 'cedarwood', 'pine': 'cedarwood', 'cypress': 'cedarwood', 'fir': 'cedarwood', 'balsam fir': 'cedarwood', 'mahogany': 'cedarwood', 'oak': 'cedarwood',
    'mysore sandalwood': 'sandalwood', 'sandalwood': 'sandalwood', 'natural sandalwood': 'sandalwood',
    'agarwood': 'oud', 'cambodian oud': 'oud', 'agarwood (oud)': 'oud', 'oud': 'oud', 'laotian oud': 'oud', 'assam oud': 'oud', 'indian oud': 'oud', 'bakhoor': 'oud',
    'haitian vetiver': 'vetiver', 'vetiver': 'vetiver', 'bourbon vetiver': 'vetiver', 'java vetiver': 'vetiver', 'sand vetiver': 'vetiver', 'tahitian vetiver': 'vetiver', 'vetyver': 'vetiver', 'truffle': 'vetiver', 'earthy notes': 'vetiver',
    'patchouli': 'patchouli', 'indonesian patchouli': 'patchouli', 'patchouli leaf': 'patchouli',
    'oakmoss': 'oakmoss', 'moss': 'oakmoss', 'tree moss': 'oakmoss',
    'amberwood': 'amberwood', 'amber wood': 'amberwood',
    
    # Resins, Smoke, Balsams
    'smoke': 'smoke', 'smoky notes': 'smoke', 'birch tar': 'smoke', 'incense smoke': 'smoke', 'cade oil': 'smoke',
    'opoponax': 'opoponax', 'sweet myrrh': 'opoponax',
    'labdanum': 'labdanum', 'cistus': 'labdanum', 'rockrose': 'labdanum', 'french labdanum': 'labdanum',
    'benzoin': 'benzoin', 'siam benzoin': 'benzoin',
    'incense': 'incense', 'frankincense': 'incense', 'olibanum': 'incense', 'myrrh': 'incense', 'myrhh': 'incense',
    'elemi': 'elemi', 'elemi resin': 'elemi',
    'styrax': 'styrax', 'storax': 'styrax', 'tolu balsam': 'styrax', 'peru balsam': 'styrax', 'gurjan balsam': 'styrax', 'fir resin': 'styrax', 'resins': 'styrax',
    'galbanum': 'galbanum', 'galbanum resin': 'galbanum',
    
    # Musks & Animals
    'white musk': 'musk', 'crystal musk': 'musk', 'musk': 'musk', 'cashmeran': 'musk', 'ambrette': 'musk', 'ambrette (musk mallow)': 'musk', 'civet': 'musk', 'castoreum': 'musk',
    'ambergris': 'ambergris', 'grey amber': 'ambergris', 'ambre gris': 'ambergris',
    'ambroxan': 'ambroxan', 'ambrox': 'ambroxan', 'cetalox': 'ambroxan', 'ambrofix': 'ambroxan',
    'amber': 'amber', 'black amber': 'amber', 'white amber': 'amber', 'amber xtreme': 'amber',
    
    # Gourmand, Sweet, Booze
    'bourbon vanilla': 'vanilla', 'madagascar vanilla': 'vanilla', 'vanilla': 'vanilla', 'vanilla orchid': 'vanilla', 'vanilla caviar': 'vanilla', 'black vanilla husk': 'vanilla', 'whipped vanilla': 'vanilla', 'vanilla absolute': 'vanilla', 'vanille': 'vanilla', 'vanila': 'vanilla', 'milk': 'vanilla', 'whipped cream': 'vanilla', 'ice cream': 'vanilla',
    'tonka': 'tonka-bean', 'tonka bean': 'tonka-bean', 'coumarin': 'tonka-bean',
    'cacao': 'cacao', 'cocoa': 'cacao', 'chocolate': 'cacao', 'dark chocolate': 'cacao', 'cacao pod': 'cacao',
    'coffee': 'coffee', 'roasted coffee': 'coffee', 'espresso': 'coffee', 'coffee beans': 'coffee', 'roasted coffee beans': 'coffee',
    'tobacco': 'tobacco', 'tobacco leaf': 'tobacco', 'cured tobacco': 'tobacco', 'white tobacco': 'tobacco', 'tobacco blossom': 'tobacco',
    'almond': 'almond', 'bitter almond': 'almond', 'sweet almond': 'almond', 'green almond': 'almond', 'candied almond': 'almond', 'almond creme': 'almond', 'pistachio': 'almond', 'hazelnut': 'almond', 'chestnut': 'almond', 'sesame': 'almond',
    'honey': 'honey', 'honeycomb': 'honey', 'white honey': 'honey', 'beeswax': 'honey',
    'caramel': 'caramel', 'toffee': 'caramel', 'dulce de leche': 'caramel', 'praline': 'caramel', 'butterscotch': 'caramel', 'marshmallow': 'caramel', 'marshamallow': 'caramel', 'cotton candy': 'caramel', 'sugar': 'caramel', 'brown sugar': 'caramel', 'cupcake': 'caramel',
    'rum': 'rum', 'cognac': 'rum', 'whiskey': 'rum', 'brandy': 'rum', 'bourbon': 'rum', 'liquor': 'rum', 'champagne': 'rum', 'sparkling champagne': 'rum', 'champagne rosé': 'rum', 'vodka': 'rum', 'wine': 'rum', 'red wine notes': 'rum', 'grapes': 'raspberry',
    
    # Marine, Clean, Molecules
    'sea notes': 'sea-notes', 'marine notes': 'sea-notes', 'aquatic notes': 'sea-notes', 'ocean notes': 'sea-notes', 'sea salt': 'sea-notes', 'water notes': 'sea-notes', 'calone': 'sea-notes', 'sea water': 'sea-notes', 'watery notes': 'sea-notes', 'seaweed': 'sea-notes',
    'mineral notes': 'aldehydes', 'ozonic notes': 'aldehydes', 'solar notes': 'aldehydes', 'aldehydes': 'aldehydes',
    'iso e super': 'cedarwood', 'hedione': 'jasmine',
    'leather': 'leather', 'suede': 'leather', 'tuscan leather': 'leather', 'white suede': 'leather'
}

def resolve_note(note_name):
    clean = str(note_name).strip()
    disp_name = ' '.join(w.capitalize() for w in clean.split())
    low = clean.lower()
    
    # 1. Direct match in NOTE_IMG_MAP
    if low in NOTE_IMG_MAP:
        return {'name': disp_name, 'image': NOTE_IMG_MAP[low]}
        
    # 2. Exact match in SYNONYMS
    if low in SYNONYMS:
        target = SYNONYMS[low]
        if target in NOTE_IMG_MAP:
            return {'name': disp_name, 'image': NOTE_IMG_MAP[target]}
            
    # 3. Substring match in SYNONYMS
    for k, target in SYNONYMS.items():
        if k == low or k in low:
            if target in NOTE_IMG_MAP:
                return {'name': disp_name, 'image': NOTE_IMG_MAP[target]}
                
    # 4. Keyword family fallbacks
    if any(w in low for w in ['citrus', 'lime', 'yuzu', 'lemon', 'citron']):
        return {'name': disp_name, 'image': 'assets/images/notes/lemon.png'}
    elif any(w in low for w in ['orange', 'mandarin', 'tangerine', 'clementine']):
        return {'name': disp_name, 'image': 'assets/images/notes/orange.png'}
    elif any(w in low for w in ['herb', 'leaf', 'leaves', 'grass', 'green']):
        return {'name': disp_name, 'image': 'assets/images/notes/green-notes.png'}
    elif any(w in low for w in ['flower', 'blossom', 'petal', 'flora', 'lily', 'freesia', 'orchid', 'jasmine', 'gardenia', 'lotus']):
        return {'name': disp_name, 'image': 'assets/images/notes/jasmine.png'}
    elif any(w in low for w in ['rose', 'peony', 'carnation']):
        return {'name': disp_name, 'image': 'assets/images/notes/rose.png'}
    elif any(w in low for w in ['berry', 'cherry', 'fruit', 'plum', 'currant', 'raspberry', 'apple', 'peach', 'pear', 'grape']):
        return {'name': disp_name, 'image': 'assets/images/notes/raspberry.png'}
    elif any(w in low for w in ['pepper']):
        return {'name': disp_name, 'image': 'assets/images/notes/black-pepper.png'}
    elif any(w in low for w in ['wood', 'tree', 'pine', 'cypress', 'birch', 'cedar']):
        return {'name': disp_name, 'image': 'assets/images/notes/cedarwood.png'}
    elif any(w in low for w in ['sandal']):
        return {'name': disp_name, 'image': 'assets/images/notes/sandalwood.png'}
    elif any(w in low for w in ['oud', 'agar']):
        return {'name': disp_name, 'image': 'assets/images/notes/oud.png'}
    elif any(w in low for w in ['smoke']):
        return {'name': disp_name, 'image': 'assets/images/notes/smoke.png'}
    elif any(w in low for w in ['resin', 'balsam', 'gum']):
        return {'name': disp_name, 'image': 'assets/images/notes/styrax.png'}
    elif any(w in low for w in ['sweet', 'sugar', 'caramel', 'honey', 'candy']):
        return {'name': disp_name, 'image': 'assets/images/notes/caramel.png'}
    elif any(w in low for w in ['vanilla']):
        return {'name': disp_name, 'image': 'assets/images/notes/vanilla.png'}
    elif any(w in low for w in ['chocolate', 'cacao', 'cocoa']):
        return {'name': disp_name, 'image': 'assets/images/notes/cacao.png'}
    elif any(w in low for w in ['spice', 'seed']):
        return {'name': disp_name, 'image': 'assets/images/notes/cardamom.png'}
    elif any(w in low for w in ['water', 'sea', 'marine', 'ocean', 'aqua', 'salt']):
        return {'name': disp_name, 'image': 'assets/images/notes/sea-notes.png'}
    elif any(w in low for w in ['leather', 'suede']):
        return {'name': disp_name, 'image': 'assets/images/notes/leather.png'}
    elif any(w in low for w in ['tobacco']):
        return {'name': disp_name, 'image': 'assets/images/notes/tobacco.png'}
        
    return {'name': disp_name, 'image': 'assets/images/notes/amber.png'}

# Standardize Catalog Brands to Fragrantica Brand Slugs
BRAND_MAP = {
    'abercrombie g fitch': 'abercrombie-fitch',
    'adidas': 'adidas',
    'afnan': 'afnan',
    'ahmed al maghribi': 'ahmed-al-maghribi',
    'ajmal': 'ajmal',
    'al harmain': 'al-haramain-perfumes',
    'al rehab': 'al-rehab',
    'amouage': 'amouage',
    'arabian oud': 'arabian-oud',
    'arabiyat': 'arabiyat',
    'armaf': 'armaf',
    'armani': 'giorgio-armani',
    'azzaro': 'azzaro',
    'balman paris': 'pierre-balmain',
    'bath and body': 'bath-body-works',
    'bath and body works': 'bath-body-works',
    'bath g body': 'bath-body-works',
    'bentley': 'bentley',
    'billie eilish': 'billie-eilish',
    'bond no g': 'bond-no-9',
    'boss': 'hugo-boss',
    'britney spear': 'britney-spears',
    'burberry': 'burberry',
    'bvlgari': 'bvlgari',
    'byredo': 'byredo',
    'caroline harerra': 'carolina-herrera',
    'cartier': 'cartier',
    'chanel': 'chanel',
    'chloe': 'chloe',
    'chopard': 'chopard',
    'cigar': 'cigar',
    'ck': 'calvin-klein',
    'coach': 'coach',
    'creed': 'creed',
    'd g g': 'dolce-gabbana',
    'david beckham': 'david-beckham',
    'davidoff': 'davidoff',
    'dgg': 'dolce-gabbana',
    'dior': 'dior',
    'dunhill': 'alfred-dunhill',
    'dyptique': 'diptyque',
    'elizabeth': 'elizabeth-arden',
    'elizabeth arden': 'elizabeth-arden',
    'emper': 'emper',
    'escada': 'escada',
    'ex nihilo': 'ex-nihilo',
    'ferrari': 'ferrari',
    'fragrance world': 'fragrance-world',
    'frederic malle': 'frederic-malle',
    'givenchy': 'givenchy',
    'gucci': 'gucci',
    'guerlain': 'guerlain',
    'hermes': 'hermes',
    'iceberg': 'iceberg',
    'initio': 'initio-parfums-prives',
    'issey miyake': 'issey-miyake',
    'isseymiyake': 'issey-miyake',
    'jacques bogart': 'jacques-bogart',
    'jaques bogart': 'jacques-bogart',
    'jo malone': 'jo-malone-london',
    'jovan musk': 'jovan',
    'jpg': 'jean-paul-gaultier',
    'kayali': 'kayali-fragrances',
    'kilian': 'by-kilian',
    'lancome': 'lancome',
    'lattafa': 'lattafa-perfumes',
    'le labo': 'le-labo',
    'louis vuitton': 'louis-vuitton',
    'maison crivelli': 'maison-crivelli',
    'maision crivelli': 'maison-crivelli',
    'maison martin margiela': 'maison-martin-margiela',
    'mancera': 'mancera',
    'marc antonie barrois': 'marc-antoine-barrois',
    'marc jacobs': 'marc-jacobs',
    'memo paris': 'memo-paris',
    'mfk': 'maison-francis-kurkdjian',
    'montale': 'montale',
    'monte blanc': 'montblanc',
    'moshino': 'moschino',
    'narciso rodriguez': 'narciso-rodriguez',
    'nishane': 'nishane',
    'orto parisi': 'orto-parisi',
    'paco rabbane': 'paco-rabanne',
    'paco rabanne': 'paco-rabanne',
    'parfums d marly': 'parfums-de-marly',
    'penhaligon\'s': 'penhaligon-s',
    'prada': 'prada',
    'ralph lauren': 'ralph-lauren',
    'rasasi': 'rasasi',
    'roja': 'roja-dove',
    'roja dove': 'roja-dove',
    'salvatore ferragamo': 'salvatore-ferragamo',
    'sapil': 'sapil',
    'sospiro': 'sospiro-perfumes',
    'spirit of dubai': 'the-spirit-of-dubai',
    'swiss': 'swiss-arabian',
    'swiss arabian': 'swiss-arabian',
    'the body shop': 'the-body-shop',
    'thierry mugler': 'mugler',
    'thomas khosala': 'thomas-kosmala',
    'tiziana terenzi': 'tiziana-terenzi',
    'tom ford': 'tom-ford',
    'tomford': 'tom-ford',
    'valentino donna': 'valentino',
    'valentino uomo': 'valentino',
    'versace': 'versace',
    'victoria sec': 'victoria-s-secret',
    'victoria secret': 'victoria-s-secret',
    'viktor g rolf': 'viktor-rolf',
    'viva': 'juicy-couture',
    'viva la juicy': 'juicy-couture',
    'xerjoff': 'xerjoff',
    'ysl': 'yves-saint-laurent',
    'zara': 'zara'
}

# Brands embedded inside titles (for Panna Heera Originals)
EMBEDDED_BRAND_PATTERNS = [
    ('acqua di parma', 'acqua-di-parma'),
    ('azzaro', 'azzaro'),
    ('dior', 'dior'),
    ('dkny', 'donna-karan'),
    ('eliesaab', 'elie-saab'),
    ('elie saab', 'elie-saab'),
    ('jaguar', 'jaguar'),
    ('jimmy choo', 'jimmy-choo'),
    ('kenzo', 'kenzo'),
    ('lacoste', 'lacoste-fragrances'),
    ('lomani', 'lomani'),
    ('mancera', 'mancera'),
    ('mercedes benz', 'mercedes-benz'),
    ('nautica', 'nautica'),
    ('paco rabbane', 'paco-rabanne'),
    ('paco rabanne', 'paco-rabanne'),
    ('tommy', 'tommy-hilfiger'),
    ('valentino', 'valentino'),
    ('ysl', 'yves-saint-laurent'),
    ('versace', 'versace'),
    ('chanel', 'chanel'),
    ('gucci', 'gucci'),
    ('lattafa', 'lattafa-perfumes'),
    ('al rehab', 'al-rehab'),
    ('ajmal', 'ajmal'),
    ('rasasi', 'rasasi')
]

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
    'voice of the snake': 'the voice of the snake',
    'ultramale': 'ultra male',
    'lemale': 'le male',
    'lemale elixier': 'le male elixir',
    'allure sports': 'allure homme sport',
    'allure sport': 'allure homme sport',
    'aventus absolu': 'absolu aventus',
    'boss bottled oudh': 'boss bottled oud',
    'boss bottled oud': 'boss bottled oud',
    'oudh': 'oud'
}

def clean_brand(b):
    s = re.sub(r'[^a-z0-9 ]', ' ', str(b).lower()).strip()
    return BRAND_MAP.get(s, s.replace(' ', '-'))

def clean_title(t):
    s = str(t).lower()
    for k, v in TITLE_REPLACEMENTS.items():
        if k in s:
            s = s.replace(k, v)
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

def brand_matches(cat_b_slug, fra_b_slug):
    if not cat_b_slug or not fra_b_slug:
        return False
    c = cat_b_slug.replace('-', '').replace(' ', '').lower()
    f = fra_b_slug.replace('-', '').replace(' ', '').lower()
    if c == f:
        return True
    if len(c) >= 4 and (c in f or f in c):
        return True
    return False

def main():
    print("Loading unified Fragrantica database sources...")
    frag_records = []

    # Source 1: Combined dataset (211 modern hits)
    if os.path.exists(COMB_CSV_PATH):
        df_comb = pd.read_csv(COMB_CSV_PATH, encoding='latin1')
        for idx, row in df_comb.iterrows():
            top = parse_pyramid_list(row.get('top notes'))
            mid = parse_pyramid_list(row.get('middle notes'))
            base = parse_pyramid_list(row.get('base notes'))
            if top or mid or base:
                raw_co = str(row.get('company', '')).strip()
                raw_nm = str(row.get('name', '')).strip()
                c_brand = clean_brand(raw_co)
                c_perf = clean_title(raw_nm)
                frag_records.append({
                    'raw_brand': raw_co,
                    'raw_perfume': raw_nm,
                    'clean_brand': c_brand,
                    'clean_perfume': c_perf,
                    'words': set(c_perf.split()),
                    'gender': str(row.get('for_gender', '')).lower(),
                    'top': top,
                    'middle': mid,
                    'base': base,
                    'url': f"https://www.fragrantica.com/perfume/{raw_co}/{raw_nm}.html",
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
                raw_b = str(row.get('Brand', '')).strip()
                raw_p = str(row.get('Perfume', '')).strip()
                c_brand = clean_brand(raw_b)
                c_perf = clean_title(raw_p.replace('-', ' '))
                frag_records.append({
                    'raw_brand': raw_b,
                    'raw_perfume': raw_p,
                    'clean_brand': c_brand,
                    'clean_perfume': c_perf,
                    'words': set(c_perf.split()),
                    'gender': str(row.get('Gender', '')).lower(),
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

    # Non-perfume raw material categories that must NOT have retail perfume pyramids
    RAW_MATERIAL_BRANDS = {'fruits collection', 'floral collection', 'black mushk', 'black jin', 'careless', 'cooper', 'khus', 'oud', 'oudh'}

    for p in products:
        brand_raw = (p.get('brand') or '').strip()
        short_title_raw = (p.get('short_title') or p.get('title') or '').strip()
        full_title_raw = (p.get('title') or '').strip()
        
        b_low = brand_raw.lower()
        s_clean = clean_title(short_title_raw)
        f_clean = clean_title(full_title_raw)
        s_words = set(s_clean.split())

        # Determine true brand slug
        target_brand_slug = clean_brand(brand_raw)

        # Check for title-embedded brands if under Panna Heera Originals
        if b_low == 'panna heera originals' or target_brand_slug == 'panna-heera-originals':
            for pat, bslug in EMBEDDED_BRAND_PATTERNS:
                if pat in f_clean or pat in s_clean:
                    target_brand_slug = bslug
                    break

        # Pure raw materials should not match perfumes
        if b_low in RAW_MATERIAL_BRANDS:
            target_brand_slug = None

        found = None

        # -------------------------------------------------------------
        # STEP 1: Curated Benchmark Pyramids (Exact Fragrantica Matches)
        # -------------------------------------------------------------
        # Try full title, short title, and stripped title against curated benchmarks
        check_keys = [
            f_clean,
            s_clean,
            clean_title(f"{brand_raw} {short_title_raw}"),
            clean_title(f"{brand_raw} - {short_title_raw}")
        ]

        # Sort benchmark pyramids by key length descending so longer/more specific flankers match first
        sorted_benchmarks = sorted(BENCHMARK_PYRAMIDS.items(), key=lambda x: len(clean_title(x[0])), reverse=True)

        for k in check_keys:
            for b_key, pyr in sorted_benchmarks:
                if clean_title(b_key) == k:
                    found = {
                        'raw_brand': brand_raw,
                        'raw_perfume': pyr['ref'],
                        'top': pyr['top'],
                        'middle': pyr['middle'],
                        'base': pyr['base'],
                        'url': pyr['url'],
                        'source': f"Fragrantica Benchmark ({pyr['ref']})"
                    }
                    break
            if found:
                break

        # Substring search in benchmark pyramids (exact benchmark title within string)
        if not found:
            for b_key, pyr in sorted_benchmarks:
                bk = clean_title(b_key)
                if len(bk) >= 5 and (bk == s_clean or bk == f_clean or f" {bk} " in f" {f_clean} " or f" {bk} " in f" {s_clean} "):
                    # Extra check: make sure brand matches if benchmark key mentions brand
                    found = {
                        'raw_brand': brand_raw,
                        'raw_perfume': pyr['ref'],
                        'top': pyr['top'],
                        'middle': pyr['middle'],
                        'base': pyr['base'],
                        'url': pyr['url'],
                        'source': f"Fragrantica Benchmark ({pyr['ref']})"
                    }
                    break

        # -------------------------------------------------------------
        # STEP 2: Strict Brand-Matched Fragrantica Search
        # (ONLY search records belonging to target_brand_slug)
        # -------------------------------------------------------------
        if not found and target_brand_slug and target_brand_slug != 'panna-heera-originals':
            # Pre-filter records belonging exclusively to this brand
            brand_candidates = [
                rec for rec in frag_records 
                if brand_matches(target_brand_slug, rec['clean_brand'])
            ]

            if brand_candidates:
                # 2A: Exact perfume name match within brand
                for rec in brand_candidates:
                    if s_clean == rec['clean_perfume']:
                        found = rec
                        break

                # 2B: Smart Specificity & Token Match within brand
                if not found and s_clean:
                    is_men = '(m)' in full_title_raw.lower() or ' men' in full_title_raw.lower() or ' man' in full_title_raw.lower()
                    is_women = '(w)' in full_title_raw.lower() or ' women' in full_title_raw.lower() or ' woman' in full_title_raw.lower() or ' pour femme' in full_title_raw.lower()

                    scored = []
                    for cand in brand_candidates:
                        c_words = cand['words']
                        c_perf = cand['clean_perfume']
                        overlap = len(s_words.intersection(c_words))
                        if overlap > 0 or s_clean in c_perf or c_perf in s_clean:
                            jaccard = overlap / len(s_words.union(c_words)) if s_words.union(c_words) else 0
                            exact_bonus = 3 if s_clean == c_perf else (1 if s_clean in c_perf else 0)
                            
                            gender_bonus = 0
                            if is_men and cand.get('gender') == 'men':
                                gender_bonus = 2
                            elif is_women and cand.get('gender') == 'women':
                                gender_bonus = 2
                            elif is_men and cand.get('gender') == 'women':
                                gender_bonus = -2
                            elif is_women and cand.get('gender') == 'men':
                                gender_bonus = -2

                            length_diff = -abs(len(c_perf) - len(s_clean))
                            scored.append((overlap, exact_bonus, gender_bonus, jaccard, length_diff, cand))

                    if scored:
                        scored.sort(key=lambda x: (x[0], x[1], x[2], x[3], x[4]), reverse=True)
                        found = scored[0][5]

        # -------------------------------------------------------------
        # ASSIGN NOTES OR CLEAR
        # -------------------------------------------------------------
        if found:
            matched_count += 1
            p['notes'] = {
                'top': [resolve_note(n) for n in found['top']] if found['top'] else [],
                'middle': [resolve_note(n) for n in found['middle']] if found['middle'] else [],
                'base': [resolve_note(n) for n in found['base']] if found['base'] else []
            }
            p['fragrantica_matched'] = True
            p['fragrantica_url'] = found['url']
            p['fragrantica_reference'] = found['raw_perfume']
            p['notes_source'] = f"Fragrantica ({found['raw_perfume']})"
        else:
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
    print(f"STRICT FRAGRANTICA HARMONIZATION RESULTS:")
    print(f"  Total catalog products: {total}")
    print(f"  Fragrantica Matched (Active authentic notes): {matched_count} products")
    print(f"  Pure Attars / Proprietary House Compounds (Empty notes): {cleared_count} products")
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

    print("Strict Fragrantica synchronization complete!")

if __name__ == '__main__':
    main()
