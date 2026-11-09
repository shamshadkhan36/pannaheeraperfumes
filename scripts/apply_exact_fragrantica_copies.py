import os
import sys

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
sys.path.insert(0, os.path.join(BASE_DIR, 'scripts'))
from benchmark_fragrantica_pyramids import BENCHMARK_PYRAMIDS

EXACT_FRAGRANTICA_COPIES = {
    # Acqua di Parma Colonia - Verbatim Fragrantica page
    "acqua di parma colonia": {
        "ref": "Colonia by Acqua di Parma",
        "url": "https://www.fragrantica.com/perfume/Acqua-di-Parma/Acqua-di-Parma-Colonia-1681.html",
        "top": ["Sicilian Citrus", "Lemon", "Calabrian Bergamot", "Sweet Orange"],
        "middle": ["Lavender", "Rosemary", "Verbena", "Bulgarian Rose"],
        "base": ["Vetiver", "Sandalwood", "Patchouli"]
    },
    
    # Chanel Allure Homme Sport
    "allure sports": {
        "ref": "Allure Homme Sport by Chanel",
        "url": "https://www.fragrantica.com/perfume/Chanel/Allure-Homme-Sport-607.html",
        "top": ["Orange", "Sea Notes", "Aldehydes", "Blood Mandarin"],
        "middle": ["Pepper", "Neroli", "Cedar"],
        "base": ["Tonka Bean", "Vanilla", "White Musk", "Amber", "Vetiver", "Elemi resin"]
    },
    "chanel - allure sports": {
        "ref": "Allure Homme Sport by Chanel",
        "url": "https://www.fragrantica.com/perfume/Chanel/Allure-Homme-Sport-607.html",
        "top": ["Orange", "Sea Notes", "Aldehydes", "Blood Mandarin"],
        "middle": ["Pepper", "Neroli", "Cedar"],
        "base": ["Tonka Bean", "Vanilla", "White Musk", "Amber", "Vetiver", "Elemi resin"]
    },

    # Dior Homme Intense
    "dior homme intense": {
        "ref": "Dior Homme Intense by Dior",
        "url": "https://www.fragrantica.com/perfume/Dior/Dior-Homme-Intense-2011-13016.html",
        "top": ["Lavender"],
        "middle": ["Iris", "Ambrette (Musk Mallow)", "Pear"],
        "base": ["Virginia Cedar", "Vetiver"]
    },
    "dior - dior homme intense": {
        "ref": "Dior Homme Intense by Dior",
        "url": "https://www.fragrantica.com/perfume/Dior/Dior-Homme-Intense-2011-13016.html",
        "top": ["Lavender"],
        "middle": ["Iris", "Ambrette (Musk Mallow)", "Pear"],
        "base": ["Virginia Cedar", "Vetiver"]
    },

    # Creed Absolu Aventus
    "creed aventus absolu": {
        "ref": "Absolu Aventus by Creed",
        "url": "https://www.fragrantica.com/perfume/Creed/Absolu-Aventus-84724.html",
        "top": ["Grapefruit", "Bergamot", "Black Currant"],
        "middle": ["Ginger", "Cinnamon", "Cardamom", "Citron"],
        "base": ["Pink Pepper", "Patchouli", "Vetiver"]
    },
    "creed - creed aventus absolu": {
        "ref": "Absolu Aventus by Creed",
        "url": "https://www.fragrantica.com/perfume/Creed/Absolu-Aventus-84724.html",
        "top": ["Grapefruit", "Bergamot", "Black Currant"],
        "middle": ["Ginger", "Cinnamon", "Cardamom", "Citron"],
        "base": ["Pink Pepper", "Patchouli", "Vetiver"]
    },

    # Boss Bottled Oud
    "boss bottled oudh": {
        "ref": "Boss Bottled Oud by Hugo Boss",
        "url": "https://www.fragrantica.com/perfume/Hugo-Boss/Boss-Bottled-Oud-30818.html",
        "top": ["Apple", "Citruses"],
        "middle": ["Cinnamon", "Saffron", "Clove", "Labdanum"],
        "base": ["Agarwood (Oud)", "Sandalwood", "Cypriol Oil"]
    },
    "boss – boss bottled oudh": {
        "ref": "Boss Bottled Oud by Hugo Boss",
        "url": "https://www.fragrantica.com/perfume/Hugo-Boss/Boss-Bottled-Oud-30818.html",
        "top": ["Apple", "Citruses"],
        "middle": ["Cinnamon", "Saffron", "Clove", "Labdanum"],
        "base": ["Agarwood (Oud)", "Sandalwood", "Cypriol Oil"]
    },

    # Guerlain L'Homme Ideal EDP
    "l’homme ideal edp": {
        "ref": "L'Homme Idéal Eau de Parfum by Guerlain",
        "url": "https://www.fragrantica.com/perfume/Guerlain/L-Homme-Ideal-Eau-de-Parfum-37735.html",
        "top": ["Almond", "Spices", "Lavender", "Thyme", "Rosemary", "Bergamot"],
        "middle": ["Cherry", "Vanilla", "Incense", "Bulgarian Rose"],
        "base": ["Leather", "Tonka Bean", "Sandalwood"]
    },
    "guerlain - l’homme ideal edp": {
        "ref": "L'Homme Idéal Eau de Parfum by Guerlain",
        "url": "https://www.fragrantica.com/perfume/Guerlain/L-Homme-Ideal-Eau-de-Parfum-37735.html",
        "top": ["Almond", "Spices", "Lavender", "Thyme", "Rosemary", "Bergamot"],
        "middle": ["Cherry", "Vanilla", "Incense", "Bulgarian Rose"],
        "base": ["Leather", "Tonka Bean", "Sandalwood"]
    },

    # YSL Libre Intense
    "ysl libre intense": {
        "ref": "Libre Intense by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/Libre-Intense-62310.html",
        "top": ["Lavender", "Mandarin Orange", "Bergamot"],
        "middle": ["Lavender", "Tunisian Orange Blossom", "Jasmine Sambac", "Orchid"],
        "base": ["Madagascar Vanilla", "Tonka Bean", "Ambergris", "Vetiver"]
    },
    "ysl - libre intense": {
        "ref": "Libre Intense by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/Libre-Intense-62310.html",
        "top": ["Lavender", "Mandarin Orange", "Bergamot"],
        "middle": ["Lavender", "Tunisian Orange Blossom", "Jasmine Sambac", "Orchid"],
        "base": ["Madagascar Vanilla", "Tonka Bean", "Ambergris", "Vetiver"]
    },

    # Ralph Lauren Polo Black
    "polo black": {
        "ref": "Polo Black by Ralph Lauren",
        "url": "https://www.fragrantica.com/perfume/Ralph-Lauren/Polo-Black-1198.html",
        "top": ["Mango", "Tangerine", "Lemon"],
        "middle": ["Sage", "Wormwood", "Calone"],
        "base": ["Sandalwood", "Patchouli", "Tonka Bean"]
    },
    "ralph lauren - polo black": {
        "ref": "Polo Black by Ralph Lauren",
        "url": "https://www.fragrantica.com/perfume/Ralph-Lauren/Polo-Black-1198.html",
        "top": ["Mango", "Tangerine", "Lemon"],
        "middle": ["Sage", "Wormwood", "Calone"],
        "base": ["Sandalwood", "Patchouli", "Tonka Bean"]
    },

    # Ralph Lauren Polo Supreme Oud
    "polo oud supreme": {
        "ref": "Polo Supreme Oud by Ralph Lauren",
        "url": "https://www.fragrantica.com/perfume/Ralph-Lauren/Polo-Supreme-Oud-29759.html",
        "top": ["Cinnamon", "Pink Pepper"],
        "middle": ["Indian Oud"],
        "base": ["Guaiac Wood", "Vetiver"]
    },
    "ralph lauren - polo oud supreme": {
        "ref": "Polo Supreme Oud by Ralph Lauren",
        "url": "https://www.fragrantica.com/perfume/Ralph-Lauren/Polo-Supreme-Oud-29759.html",
        "top": ["Cinnamon", "Pink Pepper"],
        "middle": ["Indian Oud"],
        "base": ["Guaiac Wood", "Vetiver"]
    },

    # Tom Ford Tubereuse Nue
    "tubereuse nue": {
        "ref": "Tubéreuse Nue by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Tubereuse-Nue-64747.html",
        "top": ["Lily", "Jasmine", "Sichuan Pepper"],
        "middle": ["Tuberose", "Suede", "Styrax", "Benzoin"],
        "base": ["White Suede", "Musk", "Tonka Bean", "Agarwood (Oud)"]
    },
    "tomford - tuberose": {
        "ref": "Tubéreuse Nue by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Tubereuse-Nue-64747.html",
        "top": ["Lily", "Jasmine", "Sichuan Pepper"],
        "middle": ["Tuberose", "Suede", "Styrax", "Benzoin"],
        "base": ["White Suede", "Musk", "Tonka Bean", "Agarwood (Oud)"]
    },

    # Lattafa Fakhar
    "lattafa fakhir": {
        "ref": "Fakhar Black by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Fakhar-Black-70388.html",
        "top": ["Apple", "Bergamot", "Ginger"],
        "middle": ["Lavender", "Sage", "Juniper Berries", "Geranium"],
        "base": ["Tonka Bean", "Amberwood", "Cedar", "Vetiver"]
    },
    "lattafa - fakhir": {
        "ref": "Fakhar Black by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Fakhar-Black-70388.html",
        "top": ["Apple", "Bergamot", "Ginger"],
        "middle": ["Lavender", "Sage", "Juniper Berries", "Geranium"],
        "base": ["Tonka Bean", "Amberwood", "Cedar", "Vetiver"]
    },

    # Lattafa Teriaq Intense
    "lattafa - teriaq intense": {
        "ref": "Teriaq Intense by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Teriaq-Intense-97305.html",
        "top": ["Bergamot", "Saffron"],
        "middle": ["Cinnamon", "Plum", "Liquor"],
        "base": ["Amber", "Tonka Bean", "Benzoin"]
    },

    # Lattafa Maahir Black
    "lattafa - maahir black": {
        "ref": "Maahir Black Edition by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Maahir-Black-Edition-65238.html",
        "top": ["Black Pepper", "Pink Pepper", "Saffron"],
        "middle": ["Rhubarb", "Cade Oil", "Labdanum", "Gurjan Balsam"],
        "base": ["Leather", "Cedar", "Patchouli", "Guaiac Wood", "Musk", "Moss"]
    },

    # Ajmal Amber Wood Noir
    "ajmal - amberwood noir": {
        "ref": "Amber Wood Noir by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Wood-Noir-62424.html",
        "top": ["Cardamom", "White Pepper", "Apple"],
        "middle": ["Cedarwood", "Orris", "Floral Notes"],
        "base": ["Amber", "Woody Notes", "Patchouli"]
    },

    # Ajmal Amber Gold
    "ajmal – amber gold": {
        "ref": "Amber Gold by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Gold-38932.html",
        "top": ["Bergamot", "Lemon"],
        "middle": ["Rose", "Jasmine", "Spices"],
        "base": ["Amber", "Sandalwood", "Musk"]
    },

    # Al Haramain Amber Oud
    "al harmain - amber oudh": {
        "ref": "Amber Oud by Al Haramain",
        "url": "https://www.fragrantica.com/perfume/Al-Haramain-Perfumes/Amber-Oud-51846.html",
        "top": ["Rosemary", "Cedar", "Lemon", "Bergamot"],
        "middle": ["Cedar", "Spices", "Guaiac Wood"],
        "base": ["Amber", "Musk", "Resins"]
    },

    # Paco Rabanne Olympea Intense
    "paco rabbane - olympea intense": {
        "ref": "Olympéa Intense by Paco Rabanne",
        "url": "https://www.fragrantica.com/perfume/Paco-Rabanne/Olympea-Intense-41484.html",
        "top": ["Salt", "Vanilla"],
        "middle": ["Ambergris", "Orange Blossom"],
        "base": ["White Amber", "Cedar"]
    },

    # Valentino Born in Roma Intense
    "valentino uomo - born in roma intense": {
        "ref": "Valentino Uomo Born In Roma Intense by Valentino",
        "url": "https://www.fragrantica.com/perfume/Valentino/Valentino-Uomo-Born-in-Roma-Intense-78716.html",
        "top": ["Vanilla", "Bourbon Vanilla"],
        "middle": ["Lavender"],
        "base": ["Vetiver"]
    },

    # Victoria's Secret Bombshell Oud
    "victoria sec - bombshell oudh": {
        "ref": "Bombshell Oud by Victoria's Secret",
        "url": "https://www.fragrantica.com/perfume/Victoria-s-Secret/Bombshell-Oud-66633.html",
        "top": ["Saffron", "Mandarin Orange", "Violet Leaf"],
        "middle": ["White Suede", "Peony"],
        "base": ["Agarwood (Oud)", "Ambroxan"]
    },

    # Zara Tobacco Collection Intense Dark Exclusive
    "zara - tobacco intense": {
        "ref": "Tobacco Collection Intense Dark Exclusive by Zara",
        "url": "https://www.fragrantica.com/perfume/Zara/Tobacco-Collection-Intense-Dark-Exclusive-41258.html",
        "top": ["Apple"],
        "middle": ["Black Pepper", "Mint"],
        "base": ["Tobacco", "Tonka Bean", "Cedar"]
    },

    # Chloé
    "chanel - chloe": {
        "ref": "Chloé Eau de Parfum by Chloé",
        "url": "https://www.fragrantica.com/perfume/Chloe/Chloe-Eau-de-Parfum-1733.html",
        "top": ["Peony", "Litchi", "Freesia"],
        "middle": ["Rose", "Lily-of-the-Valley", "Magnolia"],
        "base": ["Virginia Cedar", "Amber"]
    }
}

BENCHMARK_PYRAMIDS.update(EXACT_FRAGRANTICA_COPIES)

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
