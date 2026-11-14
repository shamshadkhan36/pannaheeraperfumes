import os
import json
import re

OFFICIAL_WA_PATH = "M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
BROKEN_WA_PATH = "M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"

REAL_ADDRESS = "14, Masjid Street, Opp. Mandvi Post Office, Bhendi Bazar, Mumbai - 400003"
OLD_ADDRESS = "Industrial Fragrance Zone, Mumbai, Maharashtra 400001, India"

# 1. Update data/site_data.json
site_data_path = 'data/site_data.json'
if os.path.exists(site_data_path):
    with open(site_data_path, 'r', encoding='utf-8') as f:
        data = json.load(f)
    if 'settings' in data:
        data['settings']['address'] = REAL_ADDRESS
        print(f"Updated {site_data_path} settings['address'] -> {REAL_ADDRESS}")
    with open(site_data_path, 'w', encoding='utf-8') as f:
        json.dump(data, f, indent=2, ensure_ascii=False)

# 2. Update config.php
config_path = 'config.php'
if os.path.exists(config_path):
    with open(config_path, 'r', encoding='utf-8') as f:
        content = f.read()
    if OLD_ADDRESS in content:
        content = content.replace(OLD_ADDRESS, REAL_ADDRESS)
        print(f"Updated {config_path} address to {REAL_ADDRESS}")
    with open(config_path, 'w', encoding='utf-8') as f:
        f.write(content)

# 3. Update includes/storage.php
storage_path = 'includes/storage.php'
if os.path.exists(storage_path):
    with open(storage_path, 'r', encoding='utf-8') as f:
        content = f.read()
    if OLD_ADDRESS in content:
        content = content.replace(OLD_ADDRESS, REAL_ADDRESS)
        print(f"Updated {storage_path} default address to {REAL_ADDRESS}")
    with open(storage_path, 'w', encoding='utf-8') as f:
        f.write(content)

# 4. Replace broken WhatsApp SVG path across all files
count = 0
for root, dirs, files in os.walk('.'):
    if '.git' in root or 'node_modules' in root:
        continue
    for f in files:
        if f.endswith(('.php', '.html', '.js')):
            p = os.path.join(root, f)
            with open(p, 'r', encoding='utf-8', errors='ignore') as fl:
                c = fl.read()
            if BROKEN_WA_PATH in c:
                new_c = c.replace(BROKEN_WA_PATH, OFFICIAL_WA_PATH)
                with open(p, 'w', encoding='utf-8') as fl:
                    fl.write(new_c)
                print(f"Fixed WhatsApp SVG in {p}")
                count += 1

print(f"\nReplaced WhatsApp SVG in {count} files successfully!")
