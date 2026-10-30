# Panna Heera Perfumes - Haute Fragrance Compounds & Wholesale Price List Website

A responsive, high-converting luxury website built in **PHP** for **Panna Heera Perfumes**, exclusively featuring the complete **1,040 Fragrance Oils Catalog** extracted from the official **Panna Heera Price List (June 2026)**, along with a dedicated **Admin Control Panel**.

---

## 🌟 Key Features

1. **Official Client Logo & Branding**:
   - Integrated the gold monogram and floral emblem (`logo.jpeg`) into:
     - The sticky navigation header
     - The luxury dark footer
     - Browser favicon
     - The Admin login screen and sidebar
2. **Hero Showcase & Ticker**:
   - Full-width hero banner highlighting pure, 100% alcohol-free perfume oils.
   - Smooth continuous infinite marquee ticker (*✦ 100% Alcohol-Free Pure Compounds ✦ 1,040 Fragrance Varieties ✦ Extrait Strength...*).
3. **Olfactory Categories**:
   - 5 structured fragrance categories:
     - *French & Designer Inspirations* (662 Varieties)
     - *Oriental & Arabic Attars* (257 Varieties)
     - *Niche Luxury Extrait* (91 Varieties)
     - *Fruits & Gourmand Fragrances* (20 Varieties)
     - *Floral & Botanical Fragrances* (10 Varieties)
     - **Total: 1,040 Pure Fragrance Varieties**
4. **1,040+ Fragrance Oils Wholesale Directory (`fragrances.php`)**:
   - Complete digital B2B rate list extracted from the official **Panna Heera Price List (June 2026)**.
   - Filter by **140+ Luxury Houses** (Armani, Tom Ford, Creed, Dior, Ajmal, Lattafa, Rasasi, Xerjoff, Zara, etc.).
   - Olfactory Family filter pills: *Designer Fragrances*, *Oriental & Arabic*, *Niche Luxury*, *Fruits*, and *Floral*.
   - Live tiered wholesale pricing across **1 KG**, **100 GM**, and **25 GM** packs.
   - Instant 1-click **"Order on WhatsApp"** pre-formatted with exact perfume name and size.
   - Direct 1-click **"Download PDF Price List"** button linking to `assets/docs/panna-heera-price-list.pdf`.
   - Dual view modes: Tabular Rate List View & Luxury Product Cards View with instant client-side search.
5. **Featured Fragrance Spotlight Grid**:
   - 24 iconic bestselling perfume oils featured directly on the homepage and catalog with pack size modal selector.
6. **Interactive E-Commerce & WhatsApp Ordering**:
   - Pack Size Modal (25 GM Trial, 100 GM Production Pack, 1 KG Wholesale Flacon)
   - Slide-out Cart Drawer with instant "Send Order on WhatsApp" button
   - Live Spotlight Search modal indexing all 1,040 fragrance oils
   - Floating WhatsApp button with pulse animation

---

## 🛠️ Admin Control Panel

Manage your entire website dynamically without touching code or database configuration:

- **Admin Login URL**: 👉 **`http://localhost:8000/admin/login.php`**
- **Default Credentials**:
  - **Username**: `admin`
  - **Password**: `admin123`

### What You Can Do in the Admin Panel:
- **Hero Banner & Special Offers (`admin/banner.php`)**:
  - **Promotional Offer Mode**: Launch active promotional campaigns with discount badges, headline, subheadline, and terms.
  - **Promo / Coupon Code with 1-Click Copy**: Generate instant coupons (e.g. `PANNA25`) with front-end copy-to-clipboard functionality.
  - **Live Countdown Timer**: Configure expiration date/time with a ticking live days/hours/minutes/seconds countdown widget.
  - **Key Offer Perks**: Add custom bullet points with luxury checkmarks (e.g. Free Silk Printing, Zero Mould Fees, Sample Kits).
  - **Deal Spotlight Card**: Feature a specific perfume bottle with discount badge, offer price, crossed-out original price, and MOQ.
  - **Hero Mode Selector**: Switch between Offer Banner Only, Hero Carousel Slider (dual rotation), or Standard Brand Showcase.
  - **Top Announcement Bar**: Display a persistent promotional notification bar across the top of all pages.
  - Upload custom background photos and featured product imagery.
  - Add, edit, or remove scrolling marquee ticker points.
- **Manage Categories (`admin/categories.php`)**:
  - Add new categories with image uploads, titles, and highlight badges.
  - Edit or delete existing categories.
- **Manage Products (`admin/products.php` & `admin/product-form.php`)**:
  - Add new perfume bottles, caps, and pumps with photos, wholesale prices, MOQ, and technical dimensions.
  - Edit or delete existing products.
  - Changes automatically synchronize with the frontend, client-side modals, and search in real-time.
- **Site & Contact Settings (`admin/settings.php`)**:
  - Update WhatsApp business phone number for order routing.
  - Update showroom address and email.
  - Change admin password.

---

## 🚀 How to Run Locally

```powershell
# Open terminal in the project directory
cd "c:\Users\Shamshad\Desktop\panna heera perfume"

# Start PHP development server
php -S 127.0.0.1:8088
```

Then visit:
- **Website**: `http://127.0.0.1:8088/`
- **Admin Panel**: `http://127.0.0.1:8088/admin/`

---

## 📁 File Structure

```
panna heera perfume/
├── index.php                 # Homepage (Hero, Marquee, Categories, Products)
├── products.php              # Full product catalog with category sidebar
├── product-detail.php        # Product view with technical schematics & specs
├── about.php                 # Brand story, manufacturing standards, custom moulds
├── contact.php               # B2B quotation form, showroom details, FAQ
├── config.php                # Site configuration
├── logo.jpeg                 # Official client logo
├── data/
│   ├── site_data.json        # Persistent JSON database (Banner, Categories, Products, Settings)
│   └── admin_user.json       # Admin credentials
├── admin/
│   ├── index.php             # Admin Dashboard overview
│   ├── login.php             # Admin login screen
│   ├── logout.php            # Admin logout handler
│   ├── banner.php            # Banner & Marquee manager
│   ├── categories.php        # Category manager
│   ├── products.php          # Products manager
│   ├── product-form.php      # Add / Edit Product form
│   ├── settings.php          # WhatsApp & Password settings
│   └── includes/             # Admin header & footer partials
├── includes/
│   ├── storage.php           # Data layer, upload handler, session authentication
│   ├── data.php              # Dynamic catalog loader
│   ├── header.php            # Header with logo & navigation
│   ├── footer.php            # Footer with logo & WhatsApp
│   └── modals.php            # Cart drawer, options modal, search modal
└── assets/
    ├── css/style.css         # Custom stylesheet matching reference screenshots
    ├── js/main.js            # Cart state, modals, WhatsApp order generator
    ├── js/products-data.js   # Fast client-side catalog dataset (auto-synced)
    └── images/
        ├── logo-dark-bg.jpg  # Processed client logo
        ├── categories/       # Category images
        ├── products/         # Product photos and schematics
        └── uploads/          # Directory for admin-uploaded images
```
