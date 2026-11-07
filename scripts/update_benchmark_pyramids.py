# Script to expand benchmark_fragrantica_pyramids.py with exact Fragrantica pyramids
import os
import sys

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
sys.path.insert(0, os.path.join(BASE_DIR, 'scripts'))
from benchmark_fragrantica_pyramids import BENCHMARK_PYRAMIDS

NEW_PYRAMIDS = {
    # Armani
    "acqua di gio": {
        "ref": "Acqua di Gio Pour Homme by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-410.html",
        "top": ["Lime", "Lemon", "Bergamot", "Jasmine", "Orange", "Mandarin Orange", "Neroli"],
        "middle": ["Sea Notes", "Jasmine", "Calone", "Peach", "Freesia", "Rosemary", "Hyacinth", "Cyclamen", "Violet", "Coriander", "Nutmeg", "Rose"],
        "base": ["White Musk", "Cedar", "Oakmoss", "Patchouli", "Amber"]
    },
    "armani - aqua di gio": {
        "ref": "Acqua di Gio Pour Homme by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gio-410.html",
        "top": ["Lime", "Lemon", "Bergamot", "Jasmine", "Orange", "Mandarin Orange", "Neroli"],
        "middle": ["Sea Notes", "Jasmine", "Calone", "Peach", "Freesia", "Rosemary", "Hyacinth", "Cyclamen", "Violet", "Coriander", "Nutmeg", "Rose"],
        "base": ["White Musk", "Cedar", "Oakmoss", "Patchouli", "Amber"]
    },
    "acqua di gio (w)": {
        "ref": "Acqua di Gioia by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gioia-8442.html",
        "top": ["Amalfi Lemon", "Mint"],
        "middle": ["Jasmine", "Peony", "Pink Pepper"],
        "base": ["Virginia Cedar", "Brown Sugar", "Labdanum"]
    },
    "armani - aqua di gio (w)": {
        "ref": "Acqua di Gioia by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Acqua-di-Gioia-8442.html",
        "top": ["Amalfi Lemon", "Mint"],
        "middle": ["Jasmine", "Peony", "Pink Pepper"],
        "base": ["Virginia Cedar", "Brown Sugar", "Labdanum"]
    },
    "armani si passione": {
        "ref": "Sì Passione by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/S-Passione-48058.html",
        "top": ["Pear", "Black Currant", "Pink Pepper", "Grapefruit"],
        "middle": ["Pineapple", "Rose", "Jasmine", "Heliotrope"],
        "base": ["Vanilla", "Cedar", "Amberwood", "Patchouli"]
    },
    "armani – armani si passione": {
        "ref": "Sì Passione by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/S-Passione-48058.html",
        "top": ["Pear", "Black Currant", "Pink Pepper", "Grapefruit"],
        "middle": ["Pineapple", "Rose", "Jasmine", "Heliotrope"],
        "base": ["Vanilla", "Cedar", "Amberwood", "Patchouli"]
    },
    "armani my way nectar": {
        "ref": "My Way Nectar by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/My-Way-Nectar-89033.html",
        "top": ["Pear", "Orange Blossom", "Bergamot"],
        "middle": ["Tuberose", "Jasmine", "Violet Leaf"],
        "base": ["White Musk", "Bourbon Vanilla", "Cedarwood"]
    },
    "armani - armani my way nectar": {
        "ref": "My Way Nectar by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/My-Way-Nectar-89033.html",
        "top": ["Pear", "Orange Blossom", "Bergamot"],
        "middle": ["Tuberose", "Jasmine", "Violet Leaf"],
        "base": ["White Musk", "Bourbon Vanilla", "Cedarwood"]
    },
    "oud royale prive": {
        "ref": "Armani Privé Oud Royal by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Armani-Prive-Oud-Royal-10884.html",
        "top": ["Saffron", "Incense"],
        "middle": ["Oud", "Rose", "Amber"],
        "base": ["Sandalwood", "Myrrh", "Patchouli"]
    },
    "armani - oud royale prive": {
        "ref": "Armani Privé Oud Royal by Giorgio Armani",
        "url": "https://www.fragrantica.com/perfume/Giorgio-Armani/Armani-Prive-Oud-Royal-10884.html",
        "top": ["Saffron", "Incense"],
        "middle": ["Oud", "Rose", "Amber"],
        "base": ["Sandalwood", "Myrrh", "Patchouli"]
    },

    # Burberry
    "burberry her": {
        "ref": "Burberry Her by Burberry",
        "url": "https://www.fragrantica.com/perfume/Burberry/Burberry-Her-51694.html",
        "top": ["Strawberry", "Raspberry", "Blackberry", "Sour Cherry", "Black Currant", "Mandarin Orange", "Lemon"],
        "middle": ["Violet", "Jasmine"],
        "base": ["Musk", "Vanilla", "Cashmeran", "Woody Notes", "Amber", "Oakmoss", "Patchouli"]
    },
    "burberry - her": {
        "ref": "Burberry Her by Burberry",
        "url": "https://www.fragrantica.com/perfume/Burberry/Burberry-Her-51694.html",
        "top": ["Strawberry", "Raspberry", "Blackberry", "Sour Cherry", "Black Currant", "Mandarin Orange", "Lemon"],
        "middle": ["Violet", "Jasmine"],
        "base": ["Musk", "Vanilla", "Cashmeran", "Woody Notes", "Amber", "Oakmoss", "Patchouli"]
    },
    "burberry sports": {
        "ref": "Burberry Sport for Men by Burberry",
        "url": "https://www.fragrantica.com/perfume/Burberry/Burberry-Sport-for-Men-7848.html",
        "top": ["Ginger", "Grapefruit", "Wheat"],
        "middle": ["Sea Water", "Juniper Berries"],
        "base": ["Musk", "Cedar", "Amber"]
    },
    "burberry - sports": {
        "ref": "Burberry Sport for Men by Burberry",
        "url": "https://www.fragrantica.com/perfume/Burberry/Burberry-Sport-for-Men-7848.html",
        "top": ["Ginger", "Grapefruit", "Wheat"],
        "middle": ["Sea Water", "Juniper Berries"],
        "base": ["Musk", "Cedar", "Amber"]
    },

    # Bvlgari
    "bvlgari extreme men": {
        "ref": "Bvlgari Pour Homme Extreme by Bvlgari",
        "url": "https://www.fragrantica.com/perfume/Bvlgari/Bvlgari-Extreme-157.html",
        "top": ["Tea", "Grapefruit", "Bergamot", "Neroli", "Petitgrain", "Coriander", "Lavender", "Galbanum"],
        "middle": ["Balsam Fir", "Pepper", "Guaiac Wood", "Brazilian Rosewood", "Nutmeg", "Cardamom"],
        "base": ["Musk", "Cedar", "Oakmoss", "Sandalwood", "Iris"]
    },
    "bvlgari - extreme men": {
        "ref": "Bvlgari Pour Homme Extreme by Bvlgari",
        "url": "https://www.fragrantica.com/perfume/Bvlgari/Bvlgari-Extreme-157.html",
        "top": ["Tea", "Grapefruit", "Bergamot", "Neroli", "Petitgrain", "Coriander", "Lavender", "Galbanum"],
        "middle": ["Balsam Fir", "Pepper", "Guaiac Wood", "Brazilian Rosewood", "Nutmeg", "Cardamom"],
        "base": ["Musk", "Cedar", "Oakmoss", "Sandalwood", "Iris"]
    },
    "bvlgari aqua": {
        "ref": "Aqva Pour Homme by Bvlgari",
        "url": "https://www.fragrantica.com/perfume/Bvlgari/Aqva-Pour-Homme-153.html",
        "top": ["Mandarin Orange", "Orange", "Petitgrain"],
        "middle": ["Seaweed", "Lavender", "Cotton Flower"],
        "base": ["Virginia Cedar", "Woodsy Notes", "Patchouli", "Clary Sage", "Amber"]
    },
    "bvlgari - aqua": {
        "ref": "Aqva Pour Homme by Bvlgari",
        "url": "https://www.fragrantica.com/perfume/Bvlgari/Aqva-Pour-Homme-153.html",
        "top": ["Mandarin Orange", "Orange", "Petitgrain"],
        "middle": ["Seaweed", "Lavender", "Cotton Flower"],
        "base": ["Virginia Cedar", "Woodsy Notes", "Patchouli", "Clary Sage", "Amber"]
    },
    "bvlgari - men in black": {
        "ref": "Bvlgari Man In Black by Bvlgari",
        "url": "https://www.fragrantica.com/perfume/Bvlgari/Bvlgari-Man-In-Black-26358.html",
        "top": ["Spices", "Rum", "Tobacco"],
        "middle": ["Leather", "Iris", "Tuberose"],
        "base": ["Tonka Bean", "Guaiac Wood", "Benzoin"]
    },

    # Al-Rehab
    "al rehab lovely": {
        "ref": "Lovely by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Lovely-20152.html",
        "top": ["Citruses", "Green Notes"],
        "middle": ["Floral Notes", "White Flowers"],
        "base": ["White Musk"]
    },
    "al rehab - lovely": {
        "ref": "Lovely by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Lovely-20152.html",
        "top": ["Citruses", "Green Notes"],
        "middle": ["Floral Notes", "White Flowers"],
        "base": ["White Musk"]
    },
    "al rehab sultan": {
        "ref": "Sultan by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Sultan-20153.html",
        "top": ["Bergamot", "Cardamom"],
        "middle": ["Juniper", "Cinnamon", "Vanilla"],
        "base": ["Cedar", "Sandalwood", "Musk"]
    },
    "al rehab - sultan": {
        "ref": "Sultan by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Sultan-20153.html",
        "top": ["Bergamot", "Cardamom"],
        "middle": ["Juniper", "Cinnamon", "Vanilla"],
        "base": ["Cedar", "Sandalwood", "Musk"]
    },
    "al rehab silver": {
        "ref": "Silver by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Silver-20154.html",
        "top": ["Bergamot", "Mandarin Orange"],
        "middle": ["Green Tea", "Black Currant"],
        "base": ["Musk", "Woodsy Notes"]
    },
    "al rehab - silver": {
        "ref": "Silver by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Silver-20154.html",
        "top": ["Bergamot", "Mandarin Orange"],
        "middle": ["Green Tea", "Black Currant"],
        "base": ["Musk", "Woodsy Notes"]
    },
    "al rehab chelsea": {
        "ref": "Chelsea by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Chelsea-20147.html",
        "top": ["Floral Notes", "Green Notes"],
        "middle": ["Spices", "Amber"],
        "base": ["Woodsy Notes", "Oud"]
    },
    "al rehab - chelsea": {
        "ref": "Chelsea by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Chelsea-20147.html",
        "top": ["Floral Notes", "Green Notes"],
        "middle": ["Spices", "Amber"],
        "base": ["Woodsy Notes", "Oud"]
    },
    "al rehab lord": {
        "ref": "Lord by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Lord-20144.html",
        "top": ["Herbal Notes", "Spices"],
        "middle": ["Woodsy Notes", "Resins"],
        "base": ["Patchouli", "Amber"]
    },
    "al rehab – lord": {
        "ref": "Lord by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Lord-20144.html",
        "top": ["Herbal Notes", "Spices"],
        "middle": ["Woodsy Notes", "Resins"],
        "base": ["Patchouli", "Amber"]
    },
    "al rehab aseel": {
        "ref": "Aseel by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Aseel-20145.html",
        "top": ["Red Rose", "Saffron"],
        "middle": ["Sandalwood", "Mint"],
        "base": ["Oud", "Caramel", "Vanilla"]
    },
    "al rehab - aseel": {
        "ref": "Aseel by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Aseel-20145.html",
        "top": ["Red Rose", "Saffron"],
        "middle": ["Sandalwood", "Mint"],
        "base": ["Oud", "Caramel", "Vanilla"]
    },
    "al rehab rasha": {
        "ref": "Rasha by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Rasha-20148.html",
        "top": ["Peach", "Freesia"],
        "middle": ["Jasmine", "Rose", "Coriander"],
        "base": ["Vanilla", "Patchouli", "Vetiver"]
    },
    "al rehab – rasha": {
        "ref": "Rasha by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Rasha-20148.html",
        "top": ["Peach", "Freesia"],
        "middle": ["Jasmine", "Rose", "Coriander"],
        "base": ["Vanilla", "Patchouli", "Vetiver"]
    },
    "al rehab soft": {
        "ref": "Soft by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Soft-20140.html",
        "top": ["Caramel", "Citruses"],
        "middle": ["Vanilla", "Jasmine", "Orchid"],
        "base": ["White Musk", "Woodsy Notes", "Cardamom"]
    },
    "al rehab – soft": {
        "ref": "Soft by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Soft-20140.html",
        "top": ["Caramel", "Citruses"],
        "middle": ["Vanilla", "Jasmine", "Orchid"],
        "base": ["White Musk", "Woodsy Notes", "Cardamom"]
    },
    "choco musk": {
        "ref": "Choco Musk by Al-Rehab",
        "url": "https://www.fragrantica.com/perfume/Al-Rehab/Choco-Musk-20146.html",
        "top": ["Milk Chocolate", "White Musk"],
        "middle": ["Vanilla", "Cinnamon", "Spices"],
        "base": ["Amber", "Sandalwood", "Myrrh"]
    },

    # Ajmal
    "ajmal blue": {
        "ref": "Blu by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Blu-20593.html",
        "top": ["Watermelon", "Lavender", "Bergamot"],
        "middle": ["Lotus", "Jasmine"],
        "base": ["Sandalwood", "Amber", "Musk"]
    },
    "ajmal – blue": {
        "ref": "Blu by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Blu-20593.html",
        "top": ["Watermelon", "Lavender", "Bergamot"],
        "middle": ["Lotus", "Jasmine"],
        "base": ["Sandalwood", "Amber", "Musk"]
    },
    "ajmal amberwood": {
        "ref": "Amber Wood by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Wood-26367.html",
        "top": ["Cardamom", "Apple", "White Pepper", "Lavender"],
        "middle": ["Cedarwood", "Orris"],
        "base": ["Amber", "Woody Notes", "Patchouli"]
    },
    "ajmal - amberwood": {
        "ref": "Amber Wood by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Wood-26367.html",
        "top": ["Cardamom", "Apple", "White Pepper", "Lavender"],
        "middle": ["Cedarwood", "Orris"],
        "base": ["Amber", "Woody Notes", "Patchouli"]
    },
    "ajmal hathkora wood": {
        "ref": "Hathkora Wood by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Hathkora-Wood-26368.html",
        "top": ["Hathkora Lemon", "Peach", "Lavender"],
        "middle": ["Ginger", "Saffron", "Rose", "Plum"],
        "base": ["Agarwood (Oud)", "Sandalwood", "Cedar", "Amber"]
    },
    "ajmal - hathkora wood": {
        "ref": "Hathkora Wood by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Hathkora-Wood-26368.html",
        "top": ["Hathkora Lemon", "Peach", "Lavender"],
        "middle": ["Ginger", "Saffron", "Rose", "Plum"],
        "base": ["Agarwood (Oud)", "Sandalwood", "Cedar", "Amber"]
    },
    "ajmal amber rose": {
        "ref": "Amber Rose by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Rose-38933.html",
        "top": ["Rose", "Citrus"],
        "middle": ["Spicy Notes", "Floral Notes"],
        "base": ["Amber", "Woodsy Notes"]
    },
    "ajmal – amber rose": {
        "ref": "Amber Rose by Ajmal",
        "url": "https://www.fragrantica.com/perfume/Ajmal/Amber-Rose-38933.html",
        "top": ["Rose", "Citrus"],
        "middle": ["Spicy Notes", "Floral Notes"],
        "base": ["Amber", "Woodsy Notes"]
    },

    # Dior
    "dior joy": {
        "ref": "Joy by Dior by Dior",
        "url": "https://www.fragrantica.com/perfume/Dior/Joy-by-Dior-51036.html",
        "top": ["Bergamot", "Mandarin Orange"],
        "middle": ["Jasmine", "Grasse Rose", "Peach", "Cassis"],
        "base": ["White Musk", "Sandalwood", "Cedar", "Patchouli", "Benzoin"]
    },
    "dior - joy": {
        "ref": "Joy by Dior by Dior",
        "url": "https://www.fragrantica.com/perfume/Dior/Joy-by-Dior-51036.html",
        "top": ["Bergamot", "Mandarin Orange"],
        "middle": ["Jasmine", "Grasse Rose", "Peach", "Cassis"],
        "base": ["White Musk", "Sandalwood", "Cedar", "Patchouli", "Benzoin"]
    },

    # Dolce & Gabbana
    "d g g - king": {
        "ref": "K by Dolce & Gabbana",
        "url": "https://www.fragrantica.com/perfume/Dolce-Gabbana/K-by-Dolce-Gabbana-56430.html",
        "top": ["Juniper Berries", "Citrus", "Blood Orange", "Sicilian Lemon"],
        "middle": ["Pimento", "Clary Sage", "Lavender", "Geranium"],
        "base": ["Vetiver", "Cedar", "Patchouli"]
    },
    "d g g - queen": {
        "ref": "Q by Dolce & Gabbana",
        "url": "https://www.fragrantica.com/perfume/Dolce-Gabbana/Q-by-Dolce-Gabbana-78483.html",
        "top": ["Sicilian Lemon", "Blood Orange", "Jasmine Petals"],
        "middle": ["Cherry", "Heliotrope"],
        "base": ["Musk", "Cedar"]
    },
    "d g g - devotion": {
        "ref": "Devotion by Dolce & Gabbana",
        "url": "https://www.fragrantica.com/perfume/Dolce-Gabbana/Devotion-84951.html",
        "top": ["Candied Lemon"],
        "middle": ["Orange Blossom", "Pannacotta", "Rum"],
        "base": ["Vanilla"]
    },

    # Ferrari
    "ferrari red": {
        "ref": "Ferrari Red by Ferrari",
        "url": "https://www.fragrantica.com/perfume/Ferrari/Ferrari-Red-3419.html",
        "top": ["Bergamot", "Mint", "Orange", "Lemon Verbena", "Petitgrain", "Galbanum"],
        "middle": ["Jasmine", "Geranium", "Orris", "Nutmeg"],
        "base": ["Cedar", "Sandalwood", "Oakmoss", "Vanilla"]
    },
    "ferrari - red": {
        "ref": "Ferrari Red by Ferrari",
        "url": "https://www.fragrantica.com/perfume/Ferrari/Ferrari-Red-3419.html",
        "top": ["Bergamot", "Mint", "Orange", "Lemon Verbena", "Petitgrain", "Galbanum"],
        "middle": ["Jasmine", "Geranium", "Orris", "Nutmeg"],
        "base": ["Cedar", "Sandalwood", "Oakmoss", "Vanilla"]
    },
    "ferrari black": {
        "ref": "Ferrari Black by Ferrari",
        "url": "https://www.fragrantica.com/perfume/Ferrari/Ferrari-Black-3418.html",
        "top": ["Red Apple", "Plum", "Lime", "Bergamot"],
        "middle": ["Cinnamon", "Jasmine", "Cardamom", "Rose"],
        "base": ["Vanilla", "Amber", "Cedar", "Musk"]
    },
    "ferrari - black": {
        "ref": "Ferrari Black by Ferrari",
        "url": "https://www.fragrantica.com/perfume/Ferrari/Ferrari-Black-3418.html",
        "top": ["Red Apple", "Plum", "Lime", "Bergamot"],
        "middle": ["Cinnamon", "Jasmine", "Cardamom", "Rose"],
        "base": ["Vanilla", "Amber", "Cedar", "Musk"]
    },

    # Gissah
    "imperial valley": {
        "ref": "Imperial Valley by Gissah",
        "url": "https://www.fragrantica.com/perfume/Gissah/Imperial-Valley-72814.html",
        "top": ["Davana", "Italian Bergamot", "Pink Pepper"],
        "middle": ["White Amber", "Rosemary", "Oud"],
        "base": ["Leather", "Black Amber", "Vetiver", "Musk"]
    },
    "gissah - one g only": {
        "ref": "One & Only by Gissah",
        "url": "https://www.fragrantica.com/perfume/Gissah/One-Only-72817.html",
        "top": ["Orange Blossom", "Bergamot", "Pear"],
        "middle": ["Jasmine", "Tuberose", "White Flowers"],
        "base": ["Bourbon Vanilla", "Patchouli", "Cedar", "Musk"]
    },
    "gissah - la luna": {
        "ref": "La Luna by Gissah",
        "url": "https://www.fragrantica.com/perfume/Gissah/La-Luna-72818.html",
        "top": ["Incense", "Cardamom", "Apricot"],
        "middle": ["Rose", "Patchouli", "Smoky Notes"],
        "base": ["Leather", "Amber", "Oud"]
    },
    "gissah - hudson valley": {
        "ref": "Hudson Valley by Gissah",
        "url": "https://www.fragrantica.com/perfume/Gissah/Hudson-Valley-72816.html",
        "top": ["Grapefruit", "Black Currant", "Bergamot"],
        "middle": ["Rose", "Patchouli", "Pink Pepper"],
        "base": ["Amberwood", "Cedar", "Musk"]
    },

    # Gucci
    "gucci bloom": {
        "ref": "Gucci Bloom by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Gucci-Bloom-44894.html",
        "top": ["Jasmine"],
        "middle": ["Tuberose"],
        "base": ["Rangoon Creeper"]
    },
    "gucci - bloom": {
        "ref": "Gucci Bloom by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Gucci-Bloom-44894.html",
        "top": ["Jasmine"],
        "middle": ["Tuberose"],
        "base": ["Rangoon Creeper"]
    },
    "gucci - bloom premium": {
        "ref": "Gucci Bloom by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Gucci-Bloom-44894.html",
        "top": ["Jasmine"],
        "middle": ["Tuberose"],
        "base": ["Rangoon Creeper"]
    },
    "gucci intense oud": {
        "ref": "Intense Oud by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Intense-Oud-35222.html",
        "top": ["Incense", "Frankincense"],
        "middle": ["Oud", "Leather", "Amber"],
        "base": ["Woodsy Notes", "Olibanum"]
    },
    "gucci - oud intense": {
        "ref": "Intense Oud by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Intense-Oud-35222.html",
        "top": ["Incense", "Frankincense"],
        "middle": ["Oud", "Leather", "Amber"],
        "base": ["Woodsy Notes", "Olibanum"]
    },
    "gucci - oud": {
        "ref": "Gucci Oud by Gucci",
        "url": "https://www.fragrantica.com/perfume/Gucci/Gucci-Oud-25450.html",
        "top": ["Raspberry", "Pear", "Saffron"],
        "middle": ["Bulgarian Rose", "Orange Blossom"],
        "base": ["Agarwood (Oud)", "Patchouli", "Amber", "Musk"]
    },

    # Issey Miyake
    "issey miyake men": {
        "ref": "L'Eau d'Issey Pour Homme by Issey Miyake",
        "url": "https://www.fragrantica.com/perfume/Issey-Miyake/L-Eau-d-Issey-Pour-Homme-721.html",
        "top": ["Yuzu", "Lemon", "Bergamot", "Mandarin Orange", "Cypress", "Calone", "Coriander", "Tarragon", "Sage"],
        "middle": ["Blue Lotus", "Nutmeg", "Lily-of-the-Valley", "Saffron", "Bourbon Geranium", "Cinnamon", "Mignonette"],
        "base": ["Tahitian Vetiver", "Musk", "Cedar", "Sandalwood", "Tobacco", "Amber"]
    },
    "isseymiyake - men": {
        "ref": "L'Eau d'Issey Pour Homme by Issey Miyake",
        "url": "https://www.fragrantica.com/perfume/Issey-Miyake/L-Eau-d-Issey-Pour-Homme-721.html",
        "top": ["Yuzu", "Lemon", "Bergamot", "Mandarin Orange", "Cypress", "Calone", "Coriander", "Tarragon", "Sage"],
        "middle": ["Blue Lotus", "Nutmeg", "Lily-of-the-Valley", "Saffron", "Bourbon Geranium", "Cinnamon", "Mignonette"],
        "base": ["Tahitian Vetiver", "Musk", "Cedar", "Sandalwood", "Tobacco", "Amber"]
    },
    "issey miyake women": {
        "ref": "L'Eau d'Issey by Issey Miyake",
        "url": "https://www.fragrantica.com/perfume/Issey-Miyake/L-Eau-d-Issey-720.html",
        "top": ["Lotus", "Melon", "Freesia", "Rose Water", "Rose", "Calone", "Cyclamen"],
        "middle": ["Lily-of-the-Valley", "Lily", "Water Peony", "Carnation"],
        "base": ["Musk", "Tuberose", "Exotic Woods", "Osmanthus", "Cedarwood", "Sandalwood", "Amber"]
    },
    "isseymiyake - women": {
        "ref": "L'Eau d'Issey by Issey Miyake",
        "url": "https://www.fragrantica.com/perfume/Issey-Miyake/L-Eau-d-Issey-720.html",
        "top": ["Lotus", "Melon", "Freesia", "Rose Water", "Rose", "Calone", "Cyclamen"],
        "middle": ["Lily-of-the-Valley", "Lily", "Water Peony", "Carnation"],
        "base": ["Musk", "Tuberose", "Exotic Woods", "Osmanthus", "Cedarwood", "Sandalwood", "Amber"]
    },

    # JPG
    "jpg - divine": {
        "ref": "Gaultier Divine by Jean Paul Gaultier",
        "url": "https://www.fragrantica.com/perfume/Jean-Paul-Gaultier/Gaultier-Divine-84351.html",
        "top": ["Calypsone", "Red Berries", "Bergamot"],
        "middle": ["Lily", "Ylang-Ylang", "Jasmine"],
        "base": ["Meringue", "Sea Salt", "Patchouli", "Musk"]
    },

    # Marc-Antoine Barrois
    "ganymede": {
        "ref": "Ganymede by Marc-Antoine Barrois",
        "url": "https://www.fragrantica.com/perfume/Marc-Antoine-Barrois/Ganymede-54720.html",
        "top": ["Italian Mandarin", "Saffron"],
        "middle": ["Violet", "Chinese Osmanthus"],
        "base": ["Akigalawood", "Immortelle", "Mineral Notes", "Suede"]
    },
    "marc antonie barrois - ganymede": {
        "ref": "Ganymede by Marc-Antoine Barrois",
        "url": "https://www.fragrantica.com/perfume/Marc-Antoine-Barrois/Ganymede-54720.html",
        "top": ["Italian Mandarin", "Saffron"],
        "middle": ["Violet", "Chinese Osmanthus"],
        "base": ["Akigalawood", "Immortelle", "Mineral Notes", "Suede"]
    },

    # Montale
    "montale - black aoud": {
        "ref": "Black Aoud by Montale",
        "url": "https://www.fragrantica.com/perfume/Montale/Black-Aoud-1142.html",
        "top": ["Rose", "Mandarin Orange"],
        "middle": ["French Labdanum", "Patchouli"],
        "base": ["Agarwood (Oud)", "Musk"]
    },

    # MFK
    "mfk - a la rosee": {
        "ref": "À la rose by Maison Francis Kurkdjian",
        "url": "https://www.fragrantica.com/perfume/Maison-Francis-Kurkdjian/A-la-rose-28610.html",
        "top": ["Calabrian Bergamot", "California Orange"],
        "middle": ["Bulgarian Rose", "Grasse Rose", "Violet", "Magnolia"],
        "base": ["Cedar", "Musk"]
    },

    # Montblanc
    "monte blanc - individual": {
        "ref": "Individuel by Montblanc",
        "url": "https://www.fragrantica.com/perfume/Montblanc/Individuel-4193.html",
        "top": ["Lavender", "Cinnamon", "Pineapple", "Juniper Berries", "Mint", "Bergamot", "Rosemary", "Cardamom", "Coriander"],
        "middle": ["Orange Blossom", "Violet", "Jasmine", "Geranium"],
        "base": ["Raspberry", "Vanilla", "Sandalwood", "Dark Chocolate", "Musk", "Amber", "Patchouli", "Vetiver", "Oakmoss"]
    },

    # Prada
    "prada l'homme": {
        "ref": "Prada L'Homme by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Prada-L-Homme-39029.html",
        "top": ["Neroli", "Black Pepper", "Cardamom", "Carrot Seeds"],
        "middle": ["Iris", "Violet", "Geranium", "Mate"],
        "base": ["Amber", "Cedar", "Patchouli", "Sandalwood"]
    },
    "prada - l’homme": {
        "ref": "Prada L'Homme by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Prada-L-Homme-39029.html",
        "top": ["Neroli", "Black Pepper", "Cardamom", "Carrot Seeds"],
        "middle": ["Iris", "Violet", "Geranium", "Mate"],
        "base": ["Amber", "Cedar", "Patchouli", "Sandalwood"]
    },
    "prada paradoxe": {
        "ref": "Paradoxe by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Paradoxe-75893.html",
        "top": ["Pear", "Tangerine", "Calabrian Bergamot"],
        "middle": ["Orange Blossom", "Neroli Essence", "Neroli", "Jasmine Sambac"],
        "base": ["Bourbon Vanilla", "White Musk", "Amber", "Benzoin"]
    },
    "prada - paradox": {
        "ref": "Paradoxe by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Paradoxe-75893.html",
        "top": ["Pear", "Tangerine", "Calabrian Bergamot"],
        "middle": ["Orange Blossom", "Neroli Essence", "Neroli", "Jasmine Sambac"],
        "base": ["Bourbon Vanilla", "White Musk", "Amber", "Benzoin"]
    },
    "prada candy": {
        "ref": "Prada Candy by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Prada-Candy-12426.html",
        "top": ["Caramel"],
        "middle": ["Powdery Notes", "Musk"],
        "base": ["Benzoin", "Vanilla"]
    },
    "prada - candy": {
        "ref": "Prada Candy by Prada",
        "url": "https://www.fragrantica.com/perfume/Prada/Prada-Candy-12426.html",
        "top": ["Caramel"],
        "middle": ["Powdery Notes", "Musk"],
        "base": ["Benzoin", "Vanilla"]
    },

    # Roja Dove
    "roja - elysium": {
        "ref": "Elysium Pour Homme by Roja Dove",
        "url": "https://www.fragrantica.com/perfume/Roja-Dove/Elysium-Pour-Homme-Parfum-Colon-46296.html",
        "top": ["Grapefruit", "Lemon", "Bergamot", "Lime", "Thyme", "Artemisia", "Galbanum"],
        "middle": ["Vetiver", "Juniper Berries", "Black Currant", "Apple", "Pink Pepper", "Cedar", "Cypriol Oil", "Lily-of-the-Valley", "Rose", "Jasmine"],
        "base": ["Ambergris", "Leather", "Vanilla", "Benzoin", "Labdanum"]
    },

    # Titan Skinn
    "skinn – raw titan": {
        "ref": "Raw by Skinn Titan",
        "url": "https://www.fragrantica.com/perfume/Titan/Raw-28956.html",
        "top": ["Watery Notes", "Bergamot", "Mandarin Orange"],
        "middle": ["Violet Leaves", "Pomarose", "Carnation", "Geranium"],
        "base": ["Indonesian Patchouli", "Cashmeran", "Guaiac Wood", "White Cedar Extract"]
    },
    "skinn – amalfi bleu": {
        "ref": "Amalfi Bleu by Skinn Titan",
        "url": "https://www.fragrantica.com/perfume/Titan/Amalfi-Bleu-64157.html",
        "top": ["Citruses", "Apple"],
        "middle": ["Water Notes", "Green Leaves"],
        "base": ["Amber", "Musk"]
    },
    "skinn - nude": {
        "ref": "Nude by Skinn Titan",
        "url": "https://www.fragrantica.com/perfume/Titan/Nude-28959.html",
        "top": ["Lychee", "Raspberry"],
        "middle": ["Rose", "Peach"],
        "base": ["Sandalwood", "Musk"]
    },
    "skinn - verge": {
        "ref": "Verge by Skinn Titan",
        "url": "https://www.fragrantica.com/perfume/Titan/Verge-28958.html",
        "top": ["Lavender", "Lemon"],
        "middle": ["Oakmoss", "Patchouli"],
        "base": ["Mahogany", "Spearmint"]
    },

    # Tom Ford
    "tom ford tobacco vanille": {
        "ref": "Tobacco Vanille by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Tobacco-Vanille-1825.html",
        "top": ["Tobacco Leaf", "Spicy Notes"],
        "middle": ["Vanilla", "Cacao", "Tonka Bean", "Tobacco Blossom"],
        "base": ["Dried Fruits", "Woody Notes"]
    },
    "tomford - tobacco vanilla": {
        "ref": "Tobacco Vanille by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Tobacco-Vanille-1825.html",
        "top": ["Tobacco Leaf", "Spicy Notes"],
        "middle": ["Vanilla", "Cacao", "Tonka Bean", "Tobacco Blossom"],
        "base": ["Dried Fruits", "Woody Notes"]
    },
    "tomford - fabulous": {
        "ref": "Fucking Fabulous by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Fucking-Fabulous-46327.html",
        "top": ["Clary Sage", "Lavender"],
        "middle": ["Bitter Almond", "Leather", "Vanilla", "Orris"],
        "base": ["Leather", "Tonka Bean", "Cashmeran", "White Woods", "Amber"]
    },
    "tomford - noir d noir": {
        "ref": "Noir de Noir by Tom Ford",
        "url": "https://www.fragrantica.com/perfume/Tom-Ford/Noir-de-Noir-1822.html",
        "top": ["Saffron"],
        "middle": ["Black Rose", "Truffle", "Floral Notes"],
        "base": ["Patchouli", "Vanilla", "Agarwood (Oud)", "Oakmoss"]
    },

    # Versace
    "versace pour homme": {
        "ref": "Versace Pour Homme by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Pour-Homme-2318.html",
        "top": ["Lemon", "Bergamot", "Neroli", "Rose de Mai"],
        "middle": ["Hyacinth", "Cedar", "Clary Sage", "Geranium"],
        "base": ["Tonka Bean", "Musk", "Amber"]
    },
    "versace - pour homme": {
        "ref": "Versace Pour Homme by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Pour-Homme-2318.html",
        "top": ["Lemon", "Bergamot", "Neroli", "Rose de Mai"],
        "middle": ["Hyacinth", "Cedar", "Clary Sage", "Geranium"],
        "base": ["Tonka Bean", "Musk", "Amber"]
    },
    "versace man eau fraiche": {
        "ref": "Versace Man Eau Fraiche by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Man-Eau-Fraiche-644.html",
        "top": ["Lemon", "Bergamot", "Carambola (Star Fruit)", "Cardamom", "Brazilian Rosewood"],
        "middle": ["Cedar", "Tarragon", "Sage", "Pepper"],
        "base": ["Musk", "Woodsy Notes", "Saffron", "Amber", "Sycamore"]
    },
    "versace - eou fraiche": {
        "ref": "Versace Man Eau Fraiche by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Man-Eau-Fraiche-644.html",
        "top": ["Lemon", "Bergamot", "Carambola (Star Fruit)", "Cardamom", "Brazilian Rosewood"],
        "middle": ["Cedar", "Tarragon", "Sage", "Pepper"],
        "base": ["Musk", "Woodsy Notes", "Saffron", "Amber", "Sycamore"]
    },
    "versace oud noir": {
        "ref": "Versace Pour Homme Oud Noir by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Pour-Homme-Oud-Noir-17865.html",
        "top": ["Black Pepper", "Bitter Orange", "Neroli"],
        "middle": ["Saffron", "Cardamom", "Olibanum"],
        "base": ["Agarwood (Oud)", "Patchouli", "Leatherwood"]
    },
    "versace - oud noir": {
        "ref": "Versace Pour Homme Oud Noir by Versace",
        "url": "https://www.fragrantica.com/perfume/Versace/Versace-Pour-Homme-Oud-Noir-17865.html",
        "top": ["Black Pepper", "Bitter Orange", "Neroli"],
        "middle": ["Saffron", "Cardamom", "Olibanum"],
        "base": ["Agarwood (Oud)", "Patchouli", "Leatherwood"]
    },

    # YSL
    "ysl myself": {
        "ref": "MYSLF by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/MYSLF-83446.html",
        "top": ["Calabrian Bergamot", "Bergamot"],
        "middle": ["Tunisian Orange Blossom"],
        "base": ["Ambrofix", "Patchouli"]
    },
    "ysl - myself": {
        "ref": "MYSLF by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/MYSLF-83446.html",
        "top": ["Calabrian Bergamot", "Bergamot"],
        "middle": ["Tunisian Orange Blossom"],
        "base": ["Ambrofix", "Patchouli"]
    },
    "ysl la nuit de l'homme": {
        "ref": "La Nuit de L'Homme by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/La-Nuit-de-l-Homme-5521.html",
        "top": ["Cardamom"],
        "middle": ["Lavender", "Virginia Cedar", "Bergamot"],
        "base": ["Vetiver", "Caraway"]
    },
    "ysl - l’nuit l’homme": {
        "ref": "La Nuit de L'Homme by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/La-Nuit-de-l-Homme-5521.html",
        "top": ["Cardamom"],
        "middle": ["Lavender", "Virginia Cedar", "Bergamot"],
        "base": ["Vetiver", "Caraway"]
    },
    "ysl black opium over red": {
        "ref": "Black Opium Over Red by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/Black-Opium-Over-Red-88775.html",
        "top": ["Cherry", "Green Mandarin"],
        "middle": ["Orange Blossom", "Jasmine", "Black Tea"],
        "base": ["Madagascar Vanilla", "Coffee", "Patchouli Leaf"]
    },
    "ysl - opium black over red": {
        "ref": "Black Opium Over Red by Yves Saint Laurent",
        "url": "https://www.fragrantica.com/perfume/Yves-Saint-Laurent/Black-Opium-Over-Red-88775.html",
        "top": ["Cherry", "Green Mandarin"],
        "middle": ["Orange Blossom", "Jasmine", "Black Tea"],
        "base": ["Madagascar Vanilla", "Coffee", "Patchouli Leaf"]
    },

    # Rasasi
    "hawas": {
        "ref": "Hawas for Him by Rasasi",
        "url": "https://www.fragrantica.com/perfume/Rasasi/Hawas-for-Him-33519.html",
        "top": ["Apple", "Bergamot", "Lemon", "Cinnamon"],
        "middle": ["Watery Notes", "Plum", "Orange Blossom", "Cardamon"],
        "base": ["Ambergris", "Musk", "Patchouli", "Driftwood"]
    },
    "hawas for him": {
        "ref": "Hawas for Him by Rasasi",
        "url": "https://www.fragrantica.com/perfume/Rasasi/Hawas-for-Him-33519.html",
        "top": ["Apple", "Bergamot", "Lemon", "Cinnamon"],
        "middle": ["Watery Notes", "Plum", "Orange Blossom", "Cardamon"],
        "base": ["Ambergris", "Musk", "Patchouli", "Driftwood"]
    },
    "hawas ice": {
        "ref": "Hawas Ice for Him by Rasasi",
        "url": "https://www.fragrantica.com/perfume/Rasasi/Hawas-Ice-for-Him-89006.html",
        "top": ["Apple", "Italian Lemon", "Sicilian Bergamot", "Star Anise"],
        "middle": ["Plum", "Orange Blossom", "Cardamom"],
        "base": ["Amber", "Musk", "Moss", "Driftwood"]
    },
    "daarej": {
        "ref": "Daarej pour Homme by Rasasi",
        "url": "https://www.fragrantica.com/perfume/Rasasi/Daarej-pour-Homme-19688.html",
        "top": ["Cumin", "Cardamom", "Artemisia"],
        "middle": ["Rose", "Orris Root"],
        "base": ["Vanilla", "Tonka Bean", "Amber", "Sandalwood", "Patchouli", "Musk"]
    },

    # Lattafa
    "khamrah": {
        "ref": "Khamrah by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Khamrah-75805.html",
        "top": ["Cinnamon", "Nutmeg", "Bergamot"],
        "middle": ["Dates", "Praline", "Tuberose", "Mahonial"],
        "base": ["Vanilla", "Tonka Bean", "Benzoin", "Amberwood", "Myrrh", "Akigalawood"]
    },
    "lattafa - khamrah waha": {
        "ref": "Khamrah by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Khamrah-75805.html",
        "top": ["Cinnamon", "Nutmeg", "Bergamot"],
        "middle": ["Dates", "Praline", "Tuberose", "Mahonial"],
        "base": ["Vanilla", "Tonka Bean", "Benzoin", "Amberwood", "Myrrh", "Akigalawood"]
    },
    "lattafa asad": {
        "ref": "Asad by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Asad-72810.html",
        "top": ["Black Pepper", "Tobacco", "Pineapple"],
        "middle": ["Patchouli", "Coffee", "Iris"],
        "base": ["Vanilla", "Amber", "Dry Wood", "Benzoin", "Labdanum"]
    },
    "asad": {
        "ref": "Asad by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Asad-72810.html",
        "top": ["Black Pepper", "Tobacco", "Pineapple"],
        "middle": ["Patchouli", "Coffee", "Iris"],
        "base": ["Vanilla", "Amber", "Dry Wood", "Benzoin", "Labdanum"]
    },
    "lattafa yara": {
        "ref": "Yara by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Yara-65239.html",
        "top": ["Heliotrope", "Orchid", "Tangerine"],
        "middle": ["Gourmand Accord", "Tropical Fruits"],
        "base": ["Vanilla", "Musk", "Sandalwood"]
    },
    "yara": {
        "ref": "Yara by Lattafa Perfumes",
        "url": "https://www.fragrantica.com/perfume/Lattafa-Perfumes/Yara-65239.html",
        "top": ["Heliotrope", "Orchid", "Tangerine"],
        "middle": ["Gourmand Accord", "Tropical Fruits"],
        "base": ["Vanilla", "Musk", "Sandalwood"]
    },

    # Panna Heera Originals containing benchmark retail titles
    "dior -hypnotic poison": {
        "ref": "Hypnotic Poison by Dior",
        "url": "https://www.fragrantica.com/perfume/Dior/Hypnotic-Poison-219.html",
        "top": ["Coconut", "Plum", "Apricot"],
        "middle": ["Brazilian Rosewood", "Jasmine", "Caraway", "Tuberose", "Rose", "Lily-of-the-Valley"],
        "base": ["Vanilla", "Almond", "Sandalwood", "Musk"]
    },
    "dkny be delicious": {
        "ref": "DKNY Be Delicious by Donna Karan",
        "url": "https://www.fragrantica.com/perfume/Donna-Karan/DKNY-Be-Delicious-498.html",
        "top": ["Cucumber", "Grapefruit", "Magnolia"],
        "middle": ["Green Apple", "Lily-of-the-Valley", "Tuberose", "Violet", "Rose"],
        "base": ["Woodsy Notes", "Sandalwood", "Amber"]
    },
    "drakker": {
        "ref": "Drakkar Noir by Guy Laroche",
        "url": "https://www.fragrantica.com/perfume/Guy-Laroche/Drakkar-Noir-2069.html",
        "top": ["Lavender", "Lemon", "Bergamot", "Mint", "Rosemary", "Lemon Verbena", "Basil", "Artemisia"],
        "middle": ["Juniper", "Coriander", "Cinnamon", "Carnation", "Wormwood", "Angelica", "Jasmine"],
        "base": ["Oakmoss", "Leather", "Cedar", "Pine Tree Needles", "Sandalwood", "Vetiver", "Patchouli", "Amber", "Resins"]
    },
    "brute": {
        "ref": "Brut by Faberge",
        "url": "https://www.fragrantica.com/perfume/Brut-Parfums-Prestige/Brut-14820.html",
        "top": ["Lavender", "Anise", "Bergamot", "Basil", "Orange Blossom", "Lemon"],
        "middle": ["Ylang-Ylang", "Geranium", "Jasmine"],
        "base": ["Oakmoss", "Tonka Bean", "Vanilla", "Vetiver", "Patchouli", "Sandalwood"]
    },
    "mercedes benz club black edp": {
        "ref": "Club Black by Mercedes-Benz",
        "url": "https://www.fragrantica.com/perfume/Mercedes-Benz/Mercedes-Benz-Club-Black-46797.html",
        "top": ["Bergamot"],
        "middle": ["Incense", "Jasmine"],
        "base": ["Vanilla", "Benzoin", "Woodsy Notes", "Ambroxan"]
    },
    "kenzo flower": {
        "ref": "Flower by Kenzo by Kenzo",
        "url": "https://www.fragrantica.com/perfume/Kenzo/Flower-by-Kenzo-72.html",
        "top": ["Bulgarian Rose", "Hawthorn", "Black Currant", "Mandarin Orange"],
        "middle": ["Parma Violet", "Rose", "Opoponax", "Jasmine"],
        "base": ["Vanilla", "White Musk", "Incense"]
    },
    "lacoste white l.12.12.": {
        "ref": "Eau de Lacoste L.12.12. White by Lacoste",
        "url": "https://www.fragrantica.com/perfume/Lacoste-Fragrances/Eau-de-Lacoste-L-12-12-White-11043.html",
        "top": ["Grapefruit", "Rosemary", "Cardamom"],
        "middle": ["Ylang-Ylang", "Tuberose"],
        "base": ["Suede", "Virginia Cedar", "Leather", "Vetiver"]
    },
    "lacoste white l.12.12. premium": {
        "ref": "Eau de Lacoste L.12.12. White by Lacoste",
        "url": "https://www.fragrantica.com/perfume/Lacoste-Fragrances/Eau-de-Lacoste-L-12-12-White-11043.html",
        "top": ["Grapefruit", "Rosemary", "Cardamom"],
        "middle": ["Ylang-Ylang", "Tuberose"],
        "base": ["Suede", "Virginia Cedar", "Leather", "Vetiver"]
    },
    "tommy girl": {
        "ref": "Tommy Girl by Tommy Hilfiger",
        "url": "https://www.fragrantica.com/perfume/Tommy-Hilfiger/Tommy-Girl-631.html",
        "top": ["Apple Tree Blossom", "Camelia", "Mandarin Orange", "Black Currant"],
        "middle": ["Lemon", "Honeysuckle", "Rose", "Grapefruit", "Lily", "Mint", "Violet"],
        "base": ["Magnolia", "Jasmine", "Cedar", "Sandalwood", "Leather"]
    },
    "tommy boy": {
        "ref": "Tommy by Tommy Hilfiger",
        "url": "https://www.fragrantica.com/perfume/Tommy-Hilfiger/Tommy-632.html",
        "top": ["Mint", "Bergamot", "Grapefruit", "Lavender"],
        "middle": ["Green Apple", "Cranberry", "Rose"],
        "base": ["Cotton Flower", "Cactus", "Amber"]
    }
}

# Merge into BENCHMARK_PYRAMIDS
BENCHMARK_PYRAMIDS.update(NEW_PYRAMIDS)
print(f"Total updated benchmark pyramids: {len(BENCHMARK_PYRAMIDS)}")

# Re-write benchmark_fragrantica_pyramids.py
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

print(f"Successfully saved {len(BENCHMARK_PYRAMIDS)} pyramids to {pyramids_path}")
