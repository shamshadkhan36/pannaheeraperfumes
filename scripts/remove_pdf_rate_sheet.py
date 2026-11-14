import os
import json
import re

# 1. Update data/site_data.json
site_data_path = 'data/site_data.json'
if os.path.exists(site_data_path):
    with open(site_data_path, 'r', encoding='utf-8') as f:
        data = json.load(f)
    if 'banner' in data:
        if 'panna-heera-price-list.pdf' in data['banner'].get('link', ''):
            data['banner']['link'] = 'fragrances.php'
        if 'pdf' in data['banner'].get('button_text', '').lower():
            data['banner']['button_text'] = 'Explore 1,040 Fragrances'
    with open(site_data_path, 'w', encoding='utf-8') as f:
        json.dump(data, f, indent=2, ensure_ascii=False)
    print("Updated data/site_data.json: banner link & button_text")

# 2. Update index.php
with open('index.php', 'r', encoding='utf-8') as f:
    idx_content = f.read()

# Replace the PDF download button in index.php
old_btn = '''<a href="assets/docs/panna-heera-price-list.pdf" download class="bg-neutral-800 hover:bg-neutral-700 text-white px-6 py-3 rounded-full text-xs sm:text-sm font-bold tracking-wide transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Official PDF Rate List
          </a>'''

new_btn = '''<a href="fragrances.php" class="bg-neutral-800 hover:bg-neutral-700 text-white px-6 py-3 rounded-full text-xs sm:text-sm font-bold tracking-wide transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            Explore 1,040 Fragrance Rate List
          </a>'''

if old_btn in idx_content:
    idx_content = idx_content.replace(old_btn, new_btn)
elif old_btn.replace('\n', '\r\n') in idx_content:
    idx_content = idx_content.replace(old_btn.replace('\n', '\r\n'), new_btn.replace('\n', '\r\n'))
else:
    # Regex fallback
    idx_content = re.sub(
        r'<a\s+href="assets/docs/panna-heera-price-list\.pdf"[^>]*>.*?</a>',
        new_btn,
        idx_content,
        flags=re.DOTALL
    )

with open('index.php', 'w', encoding='utf-8') as f:
    f.write(idx_content)
print("Updated index.php: replaced PDF button with link to fragrances catalog")

# 3. Update about.php
with open('about.php', 'r', encoding='utf-8') as f:
    abt_content = f.read()

abt_content = re.sub(
    r'<a\s+href="assets/docs/panna-heera-price-list\.pdf"[^>]*>.*?</a>',
    r'<a href="contact.php" class="border border-neutral-300 hover:border-black text-neutral-900 px-6 py-3 rounded-full text-xs font-bold tracking-wide transition">Contact Wholesale Sales</a>',
    abt_content,
    flags=re.DOTALL
)

with open('about.php', 'w', encoding='utf-8') as f:
    f.write(abt_content)
print("Updated about.php: replaced PDF button with link to contact page")

# 4. Update includes/footer.php
with open('includes/footer.php', 'r', encoding='utf-8') as f:
    ftr_content = f.read()

ftr_content = re.sub(
    r'<li><a\s+href="assets/docs/panna-heera-price-list\.pdf"[^>]*>.*?</a></li>',
    r'<li><a href="contact.php" class="hover:text-gold transition">Request Wholesale Pricing</a></li>',
    ftr_content,
    flags=re.DOTALL
)

with open('includes/footer.php', 'w', encoding='utf-8') as f:
    f.write(ftr_content)
print("Updated includes/footer.php: replaced PDF link with wholesale request link")

# 5. Update README.md
if os.path.exists('README.md'):
    with open('README.md', 'r', encoding='utf-8') as f:
        readme = f.read()
    readme = readme.replace('assets/docs/panna-heera-price-list.pdf', 'fragrances.php')
    readme = readme.replace('Download PDF Price List', 'Explore 1,040 Fragrances')
    with open('README.md', 'w', encoding='utf-8') as f:
        f.write(readme)
    print("Updated README.md")

# 6. Remove physical pdf file
pdf_file = 'assets/docs/panna-heera-price-list.pdf'
if os.path.exists(pdf_file):
    os.remove(pdf_file)
    print(f"Deleted physical file: {pdf_file}")

print("\nPDF rate sheet removed from everywhere successfully!")
