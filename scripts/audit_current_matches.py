import json

with open('data/site_data.json', encoding='utf-8') as f:
    d = json.load(f)

products = d['products']

with open('scripts/audit_matches.txt', 'w', encoding='utf-8') as f:
    for p in products:
        sno = p.get('sno')
        brand = p.get('brand', '')
        title = p.get('title', '')
        short = p.get('short_title', '')
        matched = p.get('fragrantica_matched')
        ref = p.get('fragrantica_reference', '')
        url = p.get('fragrantica_url', '')
        top = [n['name'] for n in p.get('notes', {}).get('top', [])]
        mid = [n['name'] for n in p.get('notes', {}).get('middle', [])]
        base = [n['name'] for n in p.get('notes', {}).get('base', [])]
        f.write(f"#{sno} | [{brand}] {title} (short: {short})\n")
        f.write(f"   MATCHED: {matched} | REF: {ref}\n")
        f.write(f"   URL: {url}\n")
        f.write(f"   TOP: {', '.join(top)}\n")
        f.write(f"   MID: {', '.join(mid)}\n")
        f.write(f"   BASE: {', '.join(base)}\n\n")

print(f"Audited {len(products)} products to scripts/audit_matches.txt")
