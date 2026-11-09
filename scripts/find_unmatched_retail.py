import json

data = json.load(open('data/site_data.json', encoding='utf-8'))
prods = data['products']

target_brands = {'AJMAL', 'LATTAFA', 'IBRAHIM AL QURASHI', 'GISSAH', 'NASEEM', 'AL REHAB', 'AL MAJED OUD', 'ARD AL ZAAFRAN', 'JOVAN MUSK', 'SWISS'}

print("Unmatched items in retail/niche brands:")
for p in prods:
    if p.get('brand') in target_brands and (not p.get('notes') or not any(p['notes'].values())):
        print(f"{p['id']:8} | {p['brand']:20} | {p['title']}")
