<?php
if (!defined('APP_INIT')) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/data.php';
}

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' . SITE_NAME : SITE_NAME . ' | Luxury Glass Perfume Bottles, Designer Caps & Packaging'; ?></title>
  <meta name="description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : SITE_TAGLINE; ?>">
  
  <!-- Favicon with client's official logo -->
  <link rel="icon" type="image/jpeg" href="assets/images/logo-dark-bg.jpg">

  <!-- Tailwind CSS CDN for utility grid & layout -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: {
              DEFAULT: '#C5A059',
              50: '#F9F6EE',
              100: '#F3EDDC',
              500: '#C5A059',
              600: '#B08B42',
              700: '#8C6C30',
            },
            luxury: {
              black: '#111111',
              dark: '#1C1C1C',
              charcoal: '#2E2E2E',
            }
          },
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
            serif: ['Playfair Display', 'serif'],
          }
        }
      }
    }
  </script>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Main Custom Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-white text-neutral-900 antialiased selection:bg-neutral-900 selection:text-white">

  <?php if (!empty($banner['top_announcement_enabled']) && !empty($banner['top_announcement_text'])): ?>
    <!-- Top Offer Announcement Bar -->
    <div class="top-announcement-bar bg-gradient-to-r from-neutral-950 via-[#1e1912] to-neutral-950 text-white text-[11px] sm:text-xs py-2 px-4 border-b border-gold/30 z-50 relative">
      <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 sm:gap-3 text-center flex-wrap">
        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-gold/20 text-gold font-bold text-[10px] uppercase tracking-wider border border-gold/40">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
          Special Deal
        </span>
        <span class="font-medium text-neutral-200">
          <?php echo htmlspecialchars($banner['top_announcement_text']); ?>
        </span>
        <?php if (!empty($banner['top_announcement_link'])): ?>
          <a href="<?php echo htmlspecialchars($banner['top_announcement_link']); ?>" class="text-gold font-bold hover:text-white underline underline-offset-2 transition inline-flex items-center gap-1">
            <span>Claim Offer</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
          </a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Header Sticky Navigation -->
  <header class="header-sticky">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20 sm:h-24">
        
        <!-- Left: Official Brand Logo & Typography -->
        <div class="flex-shrink-0 flex items-center">
          <a href="index.php" class="flex items-center gap-3 group">
            <div class="h-14 sm:h-16 w-11 sm:w-12 bg-neutral-900 rounded-md overflow-hidden p-0.5 border border-neutral-200 shadow-sm flex items-center justify-center flex-shrink-0">
              <img src="assets/images/logo-dark-bg.jpg" alt="Panna Heera Perfumes" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
              <span class="text-base sm:text-xl font-black tracking-widest text-neutral-900 leading-tight group-hover:text-gold transition">
                <?php echo BRAND_FIRST_NAME; ?>
              </span>
              <span class="text-[0.6rem] sm:text-[0.7rem] font-bold tracking-[0.3em] text-gold uppercase mt-0.5">
                PERFUMES
              </span>
            </div>
          </a>
        </div>

        <!-- Center: Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
          <!-- Home with Icon & underline active -->
          <a href="index.php" class="nav-link <?php echo ($currentPage == 'index' || $currentPage == '') ? 'active' : ''; ?>" title="Home">
            <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
          </a>

          <!-- Our Top Categories Dropdown -->
          <div class="relative group">
            <button class="nav-link flex items-center gap-1 focus:outline-none">
              <span>Our Top Categories</span>
              <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <!-- Dropdown Menu -->
            <div class="absolute left-0 top-full mt-2 w-64 bg-white rounded-xl shadow-xl border border-neutral-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
              <div class="px-4 py-2 border-b border-neutral-100">
                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">Featured Categories</span>
              </div>
              <?php foreach ($categories as $cat): ?>
                <a href="products.php?category=<?php echo urlencode($cat['id']); ?>" class="flex items-center px-4 py-2.5 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-gold transition">
                  <span class="w-2 h-2 rounded-full bg-neutral-300 mr-3 group-hover:bg-gold"></span>
                  <?php echo htmlspecialchars($cat['title']); ?>
                </a>
              <?php endforeach; ?>
              <div class="border-t border-neutral-100 mt-1 pt-1">
                <a href="products.php" class="block px-4 py-2 text-xs font-bold text-neutral-900 hover:text-gold uppercase tracking-wider">
                  View All Products &rarr;
                </a>
              </div>
            </div>
          </div>

          <!-- About Dropdown -->
          <div class="relative group">
            <button class="nav-link flex items-center gap-1 focus:outline-none">
              <span>About</span>
              <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div class="absolute left-0 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border border-neutral-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
              <a href="about.php" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-gold transition">Our Company Story</a>
              <a href="about.php#manufacturing" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-gold transition">Quality & Manufacturing</a>
              <a href="about.php#custom-moulds" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-gold transition">Custom Bottle Moulds</a>
            </div>
          </div>

          <!-- Contact Us -->
          <a href="contact.php" class="nav-link <?php echo ($currentPage == 'contact') ? 'active' : ''; ?>">
            Contact Us
          </a>

          <!-- Admin Link -->
          <a href="admin/index.php" class="text-xs font-bold text-neutral-400 hover:text-gold border border-neutral-200 hover:border-gold px-2.5 py-1 rounded-full transition" title="Admin Control Panel">
            Admin
          </a>
        </nav>

        <!-- Right: Action Icons (Search, User, Cart) -->
        <div class="flex items-center space-x-5 sm:space-x-6">
          
          <!-- Search Icon Button -->
          <button class="search-modal-trigger text-neutral-800 hover:text-gold transition p-1.5 focus:outline-none" title="Search Bottles, Caps & Fragrances">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>

          <!-- User Profile Icon Button -->
          <a href="contact.php" class="text-neutral-800 hover:text-gold transition p-1.5 focus:outline-none hidden sm:block" title="Client Account & Inquiry">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </a>

          <!-- Cart / Inquiry Bag Button with Live Badge Counter -->
          <a href="#cart" class="cart-drawer-trigger relative text-neutral-800 hover:text-gold transition p-1.5 focus:outline-none" title="View Inquiries & Cart">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="cart-badge">1</span>
          </a>

          <!-- Mobile Hamburger Toggle -->
          <button id="mobileMenuToggle" class="md:hidden text-neutral-800 hover:text-neutral-600 focus:outline-none p-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- Mobile Navigation Drawer -->
  <div id="mobileNavDrawer" class="fixed inset-y-0 right-0 max-w-xs w-full bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col">
    <div class="p-5 border-b border-neutral-100 flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <img src="assets/images/logo-dark-bg.jpg" alt="Panna Heera Perfumes" class="w-8 h-10 object-contain rounded">
        <div class="flex flex-col">
          <span class="font-bold tracking-wider text-xs"><?php echo BRAND_FIRST_NAME; ?></span>
          <span class="text-[9px] tracking-widest text-gold uppercase">PERFUMES</span>
        </div>
      </div>
      <button id="mobileNavClose" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-neutral-100 text-neutral-600">✕</button>
    </div>
    
    <div class="p-5 flex-1 overflow-y-auto space-y-4">
      <a href="index.php" class="block py-2 font-semibold text-neutral-900 border-b border-neutral-50">Home</a>
      <div class="py-2">
        <span class="text-xs font-bold uppercase tracking-wider text-neutral-400 block mb-2">Our Top Categories</span>
        <div class="space-y-2 pl-3">
          <?php foreach ($categories as $cat): ?>
            <a href="products.php?category=<?php echo urlencode($cat['id']); ?>" class="block text-sm text-neutral-700 hover:text-gold py-1">
              <?php echo htmlspecialchars($cat['title']); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <a href="products.php" class="block py-2 font-semibold text-neutral-900 border-b border-neutral-50">All Products Catalog</a>
      <a href="about.php" class="block py-2 font-semibold text-neutral-900 border-b border-neutral-50">About Us</a>
      <a href="contact.php" class="block py-2 font-semibold text-neutral-900 border-b border-neutral-50">Contact Us</a>
      <a href="admin/index.php" class="block py-2 font-semibold text-gold border-b border-neutral-50">Admin Panel</a>

      <div class="pt-6 mt-6 border-t border-neutral-100 space-y-3">
        <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" class="w-full flex items-center justify-center gap-2 bg-[#25D366] text-white py-3 rounded-full font-semibold text-sm">
          Chat on WhatsApp
        </a>
        <a href="tel:<?php echo PHONE_RAW; ?>" class="w-full flex items-center justify-center gap-2 bg-neutral-900 text-white py-3 rounded-full font-semibold text-sm">
          Call: <?php echo PHONE_NUMBER; ?>
        </a>
      </div>
    </div>
  </div>
