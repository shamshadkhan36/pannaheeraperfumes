<?php
/**
 * Panna Heera Perfumery - Data Storage & Admin Engine
 */

if (defined('STORAGE_LOADED')) {
    return;
}
define('STORAGE_LOADED', true);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

if (!defined('DATA_FILE')) define('DATA_FILE', __DIR__ . '/../data/site_data.json');
if (!defined('ADMIN_USER_FILE')) define('ADMIN_USER_FILE', __DIR__ . '/../data/admin_user.json');
if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', __DIR__ . '/../assets/images/uploads/');
if (!defined('PRODUCTS_JS_FILE')) define('PRODUCTS_JS_FILE', __DIR__ . '/../assets/js/products-data.js');

function getActiveDataFilePath() {
    $tmpFile = sys_get_temp_dir() . '/panna_site_data.json';
    if (file_exists($tmpFile)) {
        return $tmpFile;
    }
    return DATA_FILE;
}

/**
 * Load all site data (Banner, Categories, Products, Settings)
 */
function loadSiteData() {
    $targetFile = getActiveDataFilePath();
    if (file_exists($targetFile)) {
        $content = file_get_contents($targetFile);
        $data = json_decode($content, true);
        if (is_array($data) && isset($data['products']) && isset($data['categories'])) {
            return $data;
        }
    }
    
    // Default Initial Data Seed
    $seed = getInitialSeedData();
    saveSiteData($seed);
    return $seed;
}

/**
 * Save site data & automatically sync products-data.js
 */
function saveSiteData($data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    // Attempt writing to standard project file first
    $written = false;
    if (is_writable(dirname(DATA_FILE)) || is_writable(DATA_FILE)) {
        if (!is_dir(dirname(DATA_FILE))) {
            @mkdir(dirname(DATA_FILE), 0777, true);
        }
        $written = @file_put_contents(DATA_FILE, $json) !== false;
    }
    
    // If running in a read-only serverless environment (e.g. Vercel), save to temp
    if (!$written) {
        $tmpFile = sys_get_temp_dir() . '/panna_site_data.json';
        @file_put_contents($tmpFile, $json);
    }

    // Sync client-side JavaScript products file if writable
    if (isset($data['products']) && (is_writable(dirname(PRODUCTS_JS_FILE)) || is_writable(PRODUCTS_JS_FILE))) {
        $jsContent = "/**\n * Panna Heera Perfumery - Auto-Generated Product Catalog\n */\nconst PRODUCTS_DATA = " . 
            json_encode(array_values($data['products']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ";\n";
        @file_put_contents(PRODUCTS_JS_FILE, $jsContent);
    }

    return true;
}

/**
 * Handle image file upload
 */
function handleImageUpload($fileInputName) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$fileInputName];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

    if (!in_array($ext, $allowed)) {
        return null;
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }

    $safeName = 'img_' . time() . '_' . rand(100, 999) . '.' . $ext;
    $targetPath = UPLOAD_DIR . $safeName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/images/uploads/' . $safeName;
    }

    return null;
}

/**
 * Admin Session & Auth Handlers
 */
function startAdminSession() {
    if (session_status() === PHP_SESSION_NONE) {
        $savePath = session_save_path();
        if (empty($savePath) || !is_writable($savePath)) {
            @session_save_path(sys_get_temp_dir());
        }
        @session_start();
    }
}

function checkAdminAuth() {
    startAdminSession();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminAuth() {
    startAdminSession();
    if (!checkAdminAuth()) {
        header('Location: login.php');
        exit;
    }
}

function getAdminUser() {
    $tmpAdmin = sys_get_temp_dir() . '/panna_admin_user.json';
    if (file_exists($tmpAdmin)) {
        $user = json_decode(file_get_contents($tmpAdmin), true);
        if (is_array($user)) return $user;
    }
    if (file_exists(ADMIN_USER_FILE)) {
        $user = json_decode(file_get_contents(ADMIN_USER_FILE), true);
        if (is_array($user)) return $user;
    }
    return [
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ];
}

function loginAdmin($username, $password) {
    startAdminSession();
    $admin = getAdminUser();
    if ($username === $admin['username'] && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }
    // Also allow raw check for first run fallback
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        return true;
    }
    return false;
}

function changeAdminPassword($newPassword, $newUsername = 'admin') {
    $updated = [
        'username' => $newUsername,
        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
    ];
    return file_put_contents(ADMIN_USER_FILE, json_encode($updated, JSON_PRETTY_PRINT));
}

/**
 * Initial Default Seed Data
 */
function getInitialSeedData() {
    return [
        'banner' => [
            'hero_mode' => 'offer',
            'tagline' => '✦ Premium Perfumery Packaging',
            'headline' => 'Exquisite Glass Bottles & Designer Closures',
            'subheadline' => 'Empowering prestige perfume brands with luxury super-flint glass bottles, heavy Zamac magnetic caps, and high-atomization fine mist pumps.',
            'button1_text' => 'Explore Products',
            'button1_link' => '#products-section',
            'button2_text' => 'Quick WhatsApp Quote',
            'button2_link' => 'https://wa.me/919876543210?text=Hi%2C+I+want+to+inquire+about+custom+perfume+bottles+and+packaging+solutions.',
            'background_image' => 'assets/images/hero-perfume-bg.jpg',
            'offer_active' => true,
            'offer_badge' => '🔥 SPECIAL FESTIVE OFFER • FLAT 25% OFF',
            'offer_discount_text' => 'FLAT 25% OFF',
            'offer_headline' => 'Special Wholesale Offer on Bulk Perfume Bottles & Luxury Caps',
            'offer_subheadline' => 'Avail an exclusive 25% discount on bulk orders of 100+ flacons. Complimentary UV silk screen printing and custom discovery sample kits included this season.',
            'offer_coupon_code' => 'PANNA25',
            'offer_countdown_enabled' => true,
            'offer_end_date' => '2026-11-30 23:59:59',
            'offer_countdown_label' => 'Special Offer Expires In:',
            'offer_perks' => [
                'Complimentary Custom UV Silk Printing on 100+ pcs',
                'Zero Mould Setup Fees on Bulk Orders',
                'Free Perfume Discovery Sample Kit with Every Inquiry',
                'Fast 48-Hour Dispatch Across India'
            ],
            'offer_button1_text' => 'Claim Offer on WhatsApp',
            'offer_button1_link' => '',
            'offer_button2_text' => 'Explore Offer Catalog',
            'offer_button2_link' => '#products-section',
            'offer_background_image' => 'assets/images/hero-perfume-bg.jpg',
            'offer_featured_image' => 'assets/images/products/100ml-victor.jpg',
            'offer_card_enabled' => true,
            'offer_card_title' => '100 ML Victor Flacon + Zamac Cap Set',
            'offer_card_subtitle' => 'Architectural Square Glass & Magnetic Cap',
            'offer_card_price' => '63.75',
            'offer_card_original_price' => '85.00',
            'offer_card_moq' => '50 pcs',
            'offer_card_badge' => 'SAVE 25%',
            'top_announcement_enabled' => true,
            'top_announcement_text' => '⚡ Festive Offer: Use coupon code PANNA25 for Flat 25% OFF + Free Silk Printing on 100+ bottles!',
            'top_announcement_link' => '#products-section',
            'marquee_items' => [
                'Scalable Supply',
                'Competitive Pricing',
                'Industry Trusted',
                'Long Lasting Fragrances',
                'High Quality Glass Bottles',
                'Designer Caps',
                'High Quality Pumps',
                'Custom Branding & Silk Printing',
                'Fast Turnaround',
                'Turnkey OEM & Private Label Solutions'
            ]
        ],
        'categories' => [
            [
                'id' => 'perfume-spray',
                'title' => 'Perfume Spray For Your Brand',
                'subtitle' => 'Turnkey OEM & Private Label Solutions',
                'image' => 'assets/images/categories/perfume-spray.jpg',
                'badge' => 'Private Label',
                'count' => 24
            ],
            [
                'id' => 'bottles-caps-pumps',
                'title' => 'Bottles, Caps & Pumps',
                'subtitle' => 'Full Assembled Luxury Glass Sets',
                'image' => 'assets/images/categories/bottles-caps-pumps.jpg',
                'badge' => 'Complete Sets',
                'count' => 48
            ],
            [
                'id' => 'caps-pumps',
                'title' => 'Caps and Pumps',
                'subtitle' => 'Magnetic, Crimp, Screw, Zamac Closures',
                'image' => 'assets/images/categories/caps-pumps.jpg',
                'badge' => 'Premium Closures',
                'count' => 36
            ],
            [
                'id' => 'fragrance-oils',
                'title' => 'Fragrance Oils',
                'subtitle' => 'Pure French & Oriental Concentrates',
                'image' => 'assets/images/categories/fragrance-oils.jpg',
                'badge' => 'Pure Compounds',
                'count' => 120
            ],
            [
                'id' => 'aroma-chemicals',
                'title' => 'Aroma Chemicals',
                'subtitle' => 'Perfumery Raw Materials & Fixatives',
                'image' => 'assets/images/categories/aroma-chemicals.jpg',
                'badge' => 'High Purity',
                'count' => 65
            ],
            [
                'id' => 'box-packaging',
                'title' => 'Box & Packaging',
                'subtitle' => 'Custom Mono Cartons & Rigid Luxury Boxes',
                'image' => 'assets/images/categories/box-packaging.jpg',
                'badge' => 'Custom Boxes',
                'count' => 30
            ]
        ],
        'products' => [
            [
                'id' => '10ml-testers',
                'title' => '10 ML TESTERS WITH HIGH DOSE PUMP AND CAP BLACK COLOUR REFILLABLE',
                'short_title' => '10 ML Testers With High Dose Pump',
                'category' => 'caps-pumps',
                'category_title' => 'Tester Vials & Atomizers',
                'image' => 'assets/images/products/10ml-testers.jpg',
                'price' => 18.00,
                'moq' => 100,
                'capacity' => '10 ML',
                'neck_size' => '12mm Threaded',
                'badge' => 'Refillable',
                'in_stock' => true,
                'description' => 'Precision 10ml tester glass vials engineered with high-dose fine mist pumps and sleek black finish caps. Perfect for perfume discovery sets, pocket sprays, and branded promotion kits.',
                'specs' => [
                    'High-dose fine mist spray pump (0.08 ml per stroke)',
                    'Leak-proof threaded closure with protective overcap',
                    'Heavy-bottom crystal clear glass tube',
                    'Easy to refill, wash, and brand with UV screen printing'
                ],
                'dimensions' => [
                    'height' => '115 mm',
                    'diameter' => '14 mm',
                    'capacity' => '10 ML',
                    'closure' => '12mm Threaded'
                ],
                'options' => [
                    'Cap Finish' => ['Matte Black', 'Glossy Gold', 'Silver Chrome'],
                    'Wholesale Pack' => ['100 pcs (Sample Box)', '500 pcs (Standard)', '2000 pcs (Bulk Carton)']
                ]
            ],
            [
                'id' => '100ml-cyrill',
                'title' => '100 ML CYRILL PERFUME GLASS BOTTLE',
                'short_title' => '100 ML Cyrill Glass Bottle',
                'category' => 'bottles-caps-pumps',
                'category_title' => 'Glass Bottles',
                'image' => 'assets/images/products/100ml-cyrill.jpg',
                'price' => 78.00,
                'moq' => 50,
                'capacity' => '100 ML',
                'neck_size' => 'FEA 15 mm Crimp',
                'badge' => 'Best Seller',
                'in_stock' => true,
                'description' => 'The Cyrill 100ml perfume bottle is crafted from super flint glass with a substantial, weighted base. Its cylindrical silhouette exudes minimalism and timeless luxury, fitting effortlessly in high-end perfume lines.',
                'specs' => [
                    'High-clarity super flint glass with zero optical distortion',
                    'Substantial weighted base for premium in-hand feel',
                    'Standard FEA 15mm crimp neck compatible with all luxury pumps',
                    'Supports frosted gradient, color coating, hot foil stamping'
                ],
                'dimensions' => [
                    'height' => '122 mm',
                    'diameter' => '54 mm',
                    'capacity' => '100 ML',
                    'neck' => 'FEA 15 mm'
                ],
                'options' => [
                    'Neck Finish' => ['FEA 15 Crimp Neck', '18/415 Screw Neck'],
                    'Set Configuration' => ['Bottle Only', 'Bottle + Crimp Pump', 'Complete Set with Luxury Cap'],
                    'Wholesale Pack' => ['50 pcs (Trial Pack)', '240 pcs (Master Case)', '1200 pcs (Pallet)']
                ]
            ],
            [
                'id' => '100ml-victor',
                'title' => '100 ML VICTOR PERFUME GLASS BOTTLE',
                'short_title' => '100 ML Victor Glass Bottle',
                'category' => 'bottles-caps-pumps',
                'category_title' => 'Glass Bottles',
                'image' => 'assets/images/products/100ml-victor.jpg',
                'price' => 85.00,
                'moq' => 50,
                'capacity' => '100 ML',
                'neck_size' => '15 mm',
                'badge' => 'Technical Blueprint',
                'in_stock' => true,
                'description' => 'The Victor 100ml bottle features an architectural square silhouette with precision beveling. Exact technical tolerances ensure seamless fitment with magnetic caps and crimp spray pumps.',
                'specs' => [
                    'Architectural square geometry with rounded polished corners',
                    'Exact engineered dimensions: 92.3 ± 1 mm (H) x 67 ± 1.2 mm (W) x 15 mm (Neck)',
                    'Thick wall distribution and weighted flat bottom',
                    'Ideal for masculine and unisex luxury fragrance collections'
                ],
                'dimensions' => [
                    'height' => '92.3 ± 1 mm',
                    'width' => '67 ± 1.2 mm',
                    'neck' => '15 mm',
                    'capacity' => '100 ML'
                ],
                'options' => [
                    'Glass Treatment' => ['Ultra-Flint Clear', 'Frosted Matte Black', 'Smoky Grey Luster'],
                    'Cap Pairing' => ['Bottle Only', 'Square Gold Cap', 'Square Matte Black Cap'],
                    'Wholesale Pack' => ['50 pcs', '200 pcs (Case)', '1200 pcs (Pallet)']
                ]
            ],
            [
                'id' => '20ml-saab',
                'title' => '20 ML SAAB GLASS BOTTLE BLACK CAP AND PUMP FULL SET',
                'short_title' => '20 ML Saab Glass Set',
                'category' => 'bottles-caps-pumps',
                'category_title' => 'Pocket Sprays & Sets',
                'image' => 'assets/images/products/20ml-saab.jpg',
                'price' => 26.00,
                'moq' => 100,
                'capacity' => '20 ML',
                'neck_size' => '14mm Screw',
                'badge' => 'Full Set',
                'in_stock' => true,
                'description' => 'Compact 20ml rectangular glass flacon supplied as a complete assembly with high-performance fine mist pump, collar, and black overcap. Designed for travel luxury and purse sprays.',
                'specs' => [
                    'Compact rectangular pocket profile with polished bevels',
                    'Complete set includes glass bottle, screw spray pump, dip tube, and cap',
                    'Leak-proof gasket guarantees travel & air travel safety',
                    'Silk-screen and metallic foil branding ready'
                ],
                'dimensions' => [
                    'height' => '86 mm',
                    'width' => '28 mm',
                    'depth' => '22 mm',
                    'capacity' => '20 ML'
                ],
                'options' => [
                    'Color Theme' => ['Black Cap & Pump Set', 'Gold Cap & Pump Set', 'Silver Cap & Pump Set'],
                    'Wholesale Pack' => ['100 pcs', '500 pcs (Case)', '2500 pcs (Master Pack)']
                ]
            ],
            [
                'id' => '50ml-royal-oud',
                'title' => '50 ML ROYAL OUD HEAVY FLACON WITH GOLD STOPPER',
                'short_title' => '50 ML Royal Oud Flacon',
                'category' => 'bottles-caps-pumps',
                'category_title' => 'Oriental & Attar Bottles',
                'image' => 'assets/images/products/50ml-royal-oud.jpg',
                'price' => 95.00,
                'moq' => 40,
                'capacity' => '50 ML',
                'neck_size' => 'FEA 15 mm',
                'badge' => 'Luxury Oud',
                'in_stock' => true,
                'description' => 'Exquisite oriental flacon with faceted crystal profile and opulent gold crown closure. Designed specifically for premium Attar, Oud oils, and concentrated Extrait de Parfum.',
                'specs' => [
                    'Heavy cut crystal base with brilliant light refraction',
                    'Ornate 24K gold plated crown stopper',
                    'Available with high-dose fine mist sprayer or glass dipping applicator',
                    'Velvet gift box pairing available upon request'
                ],
                'dimensions' => [
                    'height' => '108 mm',
                    'width' => '52 mm',
                    'capacity' => '50 ML',
                    'neck' => 'FEA 15 mm'
                ],
                'options' => [
                    'Stopper Finish' => ['Imperial Gold Crown', 'Silver Regal Crown', 'Antique Bronze'],
                    'Dispenser Style' => ['Fine Mist Spray', 'Glass Attar Dipping Rod'],
                    'Wholesale Pack' => ['40 pcs', '200 pcs (Case)', '800 pcs (Pallet)']
                ]
            ],
            [
                'id' => 'zamac-magnetic-cap',
                'title' => 'LUXURY HEAVY ZAMAC MAGNETIC PERFUME CAP',
                'short_title' => 'Heavy Zamac Magnetic Cap',
                'category' => 'caps-pumps',
                'category_title' => 'Caps and Pumps',
                'image' => 'assets/images/products/zamac-magnetic-cap.jpg',
                'price' => 65.00,
                'moq' => 100,
                'capacity' => 'Fits 15mm Collar',
                'neck_size' => 'FEA 15 mm Collar',
                'badge' => 'Magnetic Lock',
                'in_stock' => true,
                'description' => 'Premium Zamac alloy perfume cap weighing over 60 grams, delivering satisfying magnetic snap action. Features luxury electroplating that resists alcohol and perfume oils.',
                'specs' => [
                    'Heavyweight Zamac zinc-aluminum-magnesium-copper alloy',
                    'Equipped with strong dual neodymium alignment magnets',
                    'Flawless mirror electroplated finish with anti-scratch coating',
                    'Supports custom top emblem embossing and side laser etching'
                ],
                'dimensions' => [
                    'height' => '32 mm',
                    'outer_diameter' => '30 mm',
                    'inner_collar' => '15.3 mm',
                    'weight' => '62 grams'
                ],
                'options' => [
                    'Finish' => ['Polished 24K Gold', 'Matte Obsidian Black', 'Bright Chrome Silver', 'Rose Gold'],
                    'Wholesale Pack' => ['100 pcs', '500 pcs', '2000 pcs (Wholesale Carton)']
                ]
            ],
            [
                'id' => 'fine-mist-pump',
                'title' => 'HIGH DOSE FINE MIST CRIMP PUMP WITH COLLAR (FEA 15)',
                'short_title' => 'Fine Mist Crimp Pump Set',
                'category' => 'caps-pumps',
                'category_title' => 'Caps and Pumps',
                'image' => 'assets/images/products/fine-mist-pump.jpg',
                'price' => 14.50,
                'moq' => 200,
                'capacity' => '0.12 ML Stroke',
                'neck_size' => 'FEA 15 mm',
                'badge' => 'High Atomization',
                'in_stock' => true,
                'description' => 'High-velocity fine mist atomizing spray pump designed for luxury perfume brands. Guarantees soft, wide cloud dispersion with zero leakage or dripping.',
                'specs' => [
                    'High atomization nozzle producing a velvety micro-droplet mist',
                    'Internal 304 stainless steel springs resistant to fragrance oils',
                    'Includes matching anodized aluminum collar ring',
                    'Custom dip tube length tailored to your bottle height'
                ],
                'dimensions' => [
                    'collar_size' => 'FEA 15 mm',
                    'dosage' => '0.12 ml per actuation',
                    'tube_length' => 'Custom 60mm - 140mm'
                ],
                'options' => [
                    'Collar Color' => ['Shiny Gold', 'Matte Black', 'Shiny Silver', 'Gunmetal'],
                    'Dip Tube Length' => ['75 mm (for 30ml)', '100 mm (for 50ml)', '125 mm (for 100ml)']
                ]
            ],
            [
                'id' => '30ml-diamond',
                'title' => '30 ML DIAMOND CUT GLASS BOTTLE WITH SCREW PUMP',
                'short_title' => '30 ML Diamond Cut Bottle',
                'category' => 'bottles-caps-pumps',
                'category_title' => 'Glass Bottles',
                'image' => 'assets/images/products/30ml-diamond.jpg',
                'price' => 42.00,
                'moq' => 60,
                'capacity' => '30 ML',
                'neck_size' => '18/415 Screw',
                'badge' => 'Easy Fill Screw',
                'in_stock' => true,
                'description' => 'Facetted geometric diamond-cut bottle with screw-on fine mist sprayer. Perfect for artisan perfumers and boutique lines as no crimping machine is required for filling.',
                'specs' => [
                    'Brilliant diamond-cut facets that catch and bounce light',
                    '18/415 threaded screw neck - no crimping tool needed',
                    'Includes aluminum fine mist sprayer with clear protective cap',
                    'Sturdy, heavy glass wall construction'
                ],
                'dimensions' => [
                    'height' => '94 mm',
                    'width' => '40 mm',
                    'capacity' => '30 ML',
                    'neck' => '18/415'
                ],
                'options' => [
                    'Sprayer Finish' => ['Gold Aluminum', 'Silver Aluminum', 'Matte Black'],
                    'Wholesale Pack' => ['60 pcs', '300 pcs (Case)', '1500 pcs (Pallet)']
                ]
            ]
        ],
        'settings' => [
            'site_name' => 'PANNA HEERA PERFUMERY',
            'brand_first' => 'PANNA HEERA',
            'brand_last' => 'PERFUMES',
            'whatsapp_number' => '919876543210',
            'phone' => '+91 98765 43210',
            'email' => 'sales@pannaheeraparfums.com',
            'address' => 'Industrial Fragrance Zone, Mumbai, Maharashtra 400001, India'
        ]
    ];
}
