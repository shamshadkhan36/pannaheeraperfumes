import os
import sys
import json
import re
import ast
import pandas as pd

BASE_DIR = '.'
FRA_CSV_PATH = os.path.join(BASE_DIR, 'data', 'fra_cleaned.csv')
COMB_CSV_PATH = os.path.join(BASE_DIR, 'scratch_fragrantica_combined.csv')
SITE_DATA_PATH = os.path.join(BASE_DIR, 'data', 'site_data.json')

sys.path.insert(0, os.path.join(BASE_DIR, 'scripts'))
from sync_fragrantica_notes import clean_brand, clean_title, parse_pyramid_list, brand_matches, EMBEDDED_BRAND_PATTERNS

# Load Fragrantica records
df_fra = pd.read_csv(FRA_CSV_PATH, sep=';', encoding='latin1', on_bad_lines='skip')
frag_records = []
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
            'url': str(row.get('url', ''))
        })

print(f"Loaded {len(frag_records)} records.")

test_queries = [
    ('ARMANI', 'ARMANI - AQUA DI GIO ABS.', 'acqua di gio absolu'),
    ('CHANEL', 'CHANEL - ALLURE SPORTS', 'allure sports'),
    ('DIOR', 'DIOR - DIOR HOMME INTENSE', 'dior homme intense'),
    ('BOSS', 'BOSS - BOSS BOTTLED OUDH', 'boss bottled oudh'),
    ('RALPH LAUREN', 'RALPH LAUREN - POLO BLACK', 'polo black'),
    ('RALPH LAUREN', 'RALPH LAUREN - POLO OUD SUPREME', 'polo supreme oud')
]

for b_raw, title_raw, short_raw in test_queries:
    b_slug = clean_brand(b_raw)
    s_clean = clean_title(short_raw)
    s_words = set(s_clean.split())
    
    brand_candidates = [r for r in frag_records if brand_matches(b_slug, r['clean_brand'])]
    
    # Score each candidate by:
    # 1. token overlap count (intersection)
    # 2. whether specific flanker words are present
    scored = []
    for c in brand_candidates:
        overlap = len(s_words.intersection(c['words']))
        if overlap > 0:
            # Jaccard similarity
            jaccard = overlap / len(s_words.union(c['words']))
            scored.append((overlap, jaccard, -len(c['clean_perfume']), c))
            
    scored.sort(key=lambda x: (x[0], x[1], x[2]), reverse=True)
    winner = scored[0][3] if scored else None
    print(f"\nQuery: [{b_raw}] {title_raw} (words: {s_words})")
    if winner:
        print(f"  WINNER: {winner['raw_perfume']} (score: overlap={scored[0][0]}, jaccard={scored[0][1]:.2f})")
        print(f"  Top: {winner['top']}")
        print(f"  Mid: {winner['middle']}")
        print(f"  Base: {winner['base']}")
    else:
        print("  NO MATCH")
