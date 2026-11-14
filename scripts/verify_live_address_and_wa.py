import urllib.request
import re

# 1. Check live homepage
url_home = 'https://vw8q0.aiccloud.online/'
req = urllib.request.Request(url_home, headers={'User-Agent': 'Mozilla/5.0'})
html = urllib.request.urlopen(req).read().decode('utf-8')

print("=== CHECKING LIVE HOMEPAGE ===")
if '14, Masjid Street, Opp. Mandvi Post Office, Bhendi Bazar, Mumbai - 400003' in html:
    print("SUCCESS: Address verified on live homepage footer!")
else:
    print("ERROR: Address not found on homepage!")

if 'M17.472 14.382' in html:
    print("SUCCESS: Official WhatsApp SVG logo verified on live homepage!")
else:
    print("ERROR: Official WhatsApp SVG not found on homepage!")

if 'M12.031 6.172' in html:
    print("WARNING: Old broken WhatsApp SVG still found on homepage!")
else:
    print("SUCCESS: Old broken WhatsApp SVG completely eliminated from homepage!")

# 2. Check live contact page
url_contact = 'https://vw8q0.aiccloud.online/contact.php'
req_c = urllib.request.Request(url_contact, headers={'User-Agent': 'Mozilla/5.0'})
html_c = urllib.request.urlopen(req_c).read().decode('utf-8')

print("\n=== CHECKING LIVE CONTACT PAGE ===")
if '14, Masjid Street, Opp. Mandvi Post Office, Bhendi Bazar, Mumbai - 400003' in html_c:
    print("SUCCESS: Address verified on live contact page!")
else:
    print("ERROR: Address not found on contact page!")

if 'M17.472 14.382' in html_c:
    print("SUCCESS: Official WhatsApp SVG logo verified on live contact page!")
else:
    print("ERROR: Official WhatsApp SVG not found on contact page!")
