import pandas as pd

df = pd.read_csv('data/fra_cleaned.csv', sep=';', encoding='latin1', on_bad_lines='skip')

queries = [
    ('chanel', 'allure'),
    ('dior', 'dior-homme'),
    ('guerlain', 'ideal'),
    ('ralph-lauren', 'polo'),
    ('paco-rabanne', 'olympea'),
    ('paco-rabanne', 'invictus'),
    ('tom-ford', 'tubereuse'),
    ('creed', 'aventus'),
    ('hugo-boss', 'bottled'),
    ('giorgio-armani', 'acqua-di-gio')
]

for brand, term in queries:
    b_df = df[df['Brand'] == brand]
    hits = b_df[b_df['Perfume'].str.contains(term, case=False, na=False)]
    print(f"\n--- {brand} / {term} ({len(hits)} hits) ---")
    for idx, r in hits.iterrows():
        print(f"{r['Perfume']} | Gender: {r['Gender']}")
        print(f"   Top: {r['Top']}")
        print(f"   Mid: {r['Middle']}")
        print(f"   Base: {r['Base']}")
