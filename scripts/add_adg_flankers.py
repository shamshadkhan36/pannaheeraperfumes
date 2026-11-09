import os
import sys

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
sys.path.insert(0, os.path.join(BASE_DIR, 'scripts'))
from benchmark_fragrantica_pyramids import BENCHMARK_PYRAMIDS

ADG_EXACT = {
    # Acqua di Gio Absolu
    "armani - aqua di gio abs.": {
        "ref": "Acqua di Gio Absolu by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Absolu-48259.html",
        "top": ["Sea Notes", "Bergamot", "Pear", "Apple", "Grapefruit", "Lemon"],
        "middle": ["Lavender", "Rosemary", "Geranium"],
        "base": ["Woody Notes", "Tonka Bean", "Patchouli", "Amberwood", "Labdanum"]
    },
    "acqua di gio abs.": {
        "ref": "Acqua di Gio Absolu by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Absolu-48259.html",
        "top": ["Sea Notes", "Bergamot", "Pear", "Apple", "Grapefruit", "Lemon"],
        "middle": ["Lavender", "Rosemary", "Geranium"],
        "base": ["Woody Notes", "Tonka Bean", "Patchouli", "Amberwood", "Labdanum"]
    },
    "acqua di gio absolu": {
        "ref": "Acqua di Gio Absolu by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Absolu-48259.html",
        "top": ["Sea Notes", "Bergamot", "Pear", "Apple", "Grapefruit", "Lemon"],
        "middle": ["Lavender", "Rosemary", "Geranium"],
        "base": ["Woody Notes", "Tonka Bean", "Patchouli", "Amberwood", "Labdanum"]
    },
    
    # Acqua di Gio Essenza
    "armani - aqua di essenza": {
        "ref": "Acqua di Gio Essenza by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Essenza-14825.html",
        "top": ["Water Notes", "Bergamot", "Grapefruit", "Calone"],
        "middle": ["Basil", "Floral Notes", "Jasmine", "Sage"],
        "base": ["Pepper", "Cedar", "Musk", "Vetiver", "Ambergris", "Clary Sage", "Amber", "Patchouli"]
    },
    "aqua di essenza": {
        "ref": "Acqua di Gio Essenza by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Essenza-14825.html",
        "top": ["Water Notes", "Bergamot", "Grapefruit", "Calone"],
        "middle": ["Basil", "Floral Notes", "Jasmine", "Sage"],
        "base": ["Pepper", "Cedar", "Musk", "Vetiver", "Ambergris", "Clary Sage", "Amber", "Patchouli"]
    },

    # Acqua di Gio Profumo
    "armani - aqua di profumo": {
        "ref": "Acqua di Giò Profumo by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Profumo-29727.html",
        "top": ["Sea Notes", "Bergamot"],
        "middle": ["Rosemary", "Sage", "Geranium"],
        "base": ["Incense", "Patchouli"]
    },
    "aqua di profumo": {
        "ref": "Acqua di Giò Profumo by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-Profumo-29727.html",
        "top": ["Sea Notes", "Bergamot"],
        "middle": ["Rosemary", "Sage", "Geranium"],
        "base": ["Incense", "Patchouli"]
    }
}

BENCHMARK_PYRAMIDS.update(ADG_EXACT)

pyramids_path = os.path.join(BASE_DIR, 'scripts', 'benchmark_fragrantica_pyramids.py')
with open(pyramids_path, 'w', encoding='utf-8') as f:
    f.write('BENCHMARK_PYRAMIDS = {\n')
    for k, v in BENCHMARK_PYRAMIDS.items():
        f.write(f'    {repr(k)}: {{\n')
        f.write(f'        "ref": {repr(v["ref"])},\n')
        f.write(f'        "url": {repr(v["url"])},\n')
        f.write(f'        "top": {repr(v["top"])},\n')
        f.write(f'        "middle": {repr(v["middle"])},\n')
        f.write(f'        "base": {repr(v["base"])}\n')
        f.write('    },\n')
    f.write('}\n')

print(f"Updated benchmark_fragrantica_pyramids.py with {len(BENCHMARK_PYRAMIDS)} verbatim pyramids!")
