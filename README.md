# Panna Heera Perfumes - Luxury Perfumery & Packaging Website

A responsive, high-converting luxury website layout built in **PHP** for **Panna Heera Perfumes**, featuring the client's official brand logo and a dedicated **Admin Control Panel**.

---

## 🌟 Key Features

1. **Official Client Logo Integration**:
   - Integrated the gold monogram and floral emblem (`logo.jpeg`) into:
     - The sticky navigation header
     - The luxury dark footer
     - Browser favicon
     - The Admin login screen and sidebar
2. **Hero Showcase & Ticker**:
   - Full-width hero with perfume bottles and designer caps on an artisan wooden backdrop.
   - Smooth continuous infinite marquee ticker (*✦ Scalable Supply ✦ Competitive Pricing ✦ Industry Trusted...*).
3. **"Shop By Categories"**:
   - 6 luxury cards with hover zoom and clean typography:
     - *Perfume Spray For Your Brand*
     - *Bottles, Caps & Pumps*
     - *Caps and Pumps*
     - *Fragrance Oils*
     - *Aroma Chemicals*
     - *Box & Packaging*
4. **"Shop All Products" 4-Column Grid**:
   - Technical blueprint diagrams (Height, Width, Neck, Volume)
   - 10ml testers, 100ml Cyrill, 100ml Victor with schematics, 20ml Saab, and luxury caps
   - "Select options" black pill action buttons
5. **Interactive E-Commerce & WhatsApp Ordering**:
   - Product Options Modal (capacities, cap colors, neck types, wholesale tiers)
   - Slide-out Cart Drawer with instant "Send Order on WhatsApp" button
   - Live Spotlight Search modal
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
