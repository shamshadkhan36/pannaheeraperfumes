import json
from collections import Counter

with open('data/site_data.json', encoding='utf-8') as f:
    d = json.load(f)

brands = Counter(p.get('brand', '') for p in d['products'])
print(f"Total unique brands: {len(brands)}")
for b, count in brands.most_common(60):
    print(f"'{b}': {count},")
