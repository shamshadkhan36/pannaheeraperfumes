<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$pageTitle = 'Home';
include_once __DIR__ . '/includes/header.php';

$heroImage = !empty($banner['image']) ? $banner['image'] : (!empty($banner['background_image']) ? $banner['background_image'] : 'assets/images/hero-perfume-bg.jpg');
$bannerLink = !empty($banner['link']) ? $banner['link'] : getWhatsAppLink('Hello Panna Heera Perfumery! I am interested in your perfume bottles and special offers.');
$bannerAlt = !empty($banner['alt']) ? $banner['alt'] : 'Panna Heera Perfumery Offers';
$displayStyle = $banner['display_style'] ?? 'image_only';

$marqueeItems = !empty($banner['marquee_items']) ? $banner['marquee_items'] : [
    'Scalable Supply',
    'Competitive Pricing',
    'Industry Trusted',
    'Long Lasting Fragrances',
    'High Quality Glass Bottles',
    'Designer Caps',
    'High Quality Pumps',
    'Custom Branding & Silk Printing',
    'Fast Turnaround'
];
?>

<!-- ============================================ -->
<!-- 1. HERO BANNER IMAGE (SIMPLE & CLEAN)        -->
<!-- ============================================ -->
<?php if ($displayStyle === 'with_text'): ?>

  <section class="hero-banner relative flex items-center" style="background-image: url('<?php echo htmlspecialchars($heroImage); ?>');">
    <div class="hero-overlay"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 w-full">
      <div class="max-w-xl text-white">
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight font-serif">
          <?php echo htmlspecialchars($banner['headline'] ?? 'Exquisite Glass Bottles & Designer Closures'); ?>
        </h1>
        <p class="mt-3 sm:mt-4 text-sm sm:text-base text-neutral-200 leading-relaxed font-normal">
          <?php echo htmlspecialchars($banner['subheadline'] ?? 'Empowering prestige perfume brands with luxury super-flint glass bottles, heavy Zamac magnetic caps, and high-atomization fine mist pumps.'); ?>
        </p>
        <div class="mt-6 flex flex-wrap gap-4">
          <a href="<?php echo htmlspecialchars($bannerLink); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-7 py-3 rounded-full text-sm font-bold tracking-wide transition shadow-lg inline-flex items-center gap-2">
            <span><?php echo htmlspecialchars($banner['button_text'] ?? 'Quick WhatsApp Quote'); ?></span>
          </a>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>

  <!-- Clean Full-Width Hero Banner Image -->
  <section class="hero-banner-simple relative w-full overflow-hidden bg-neutral-900 border-b border-neutral-100">
    <?php if (!empty($bannerLink)): ?>
      <a href="<?php echo htmlspecialchars($bannerLink); ?>" target="_blank" class="block w-full group relative transition" title="<?php echo htmlspecialchars($bannerAlt); ?>">
        <img 
          src="<?php echo htmlspecialchars($heroImage); ?>" 
          alt="<?php echo htmlspecialchars($bannerAlt); ?>" 
          class="w-full h-auto max-h-[580px] object-cover sm:object-contain md:object-cover mx-auto transition-transform duration-500 group-hover:scale-[1.01]"
        >
        <!-- Click hint badge on desktop hover -->
        <div class="absolute bottom-4 right-4 bg-black/75 backdrop-blur-md text-white text-xs font-semibold px-4 py-2 rounded-full border border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-xl flex items-center gap-2 hidden sm:flex">
          <span class="w-2 h-2 rounded-full bg-[#25D366]"></span>
          <span>Click to Inquire on WhatsApp</span>
          <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </div>
      </a>
    <?php else: ?>
      <div class="w-full">
        <img 
          src="<?php echo htmlspecialchars($heroImage); ?>" 
          alt="<?php echo htmlspecialchars($bannerAlt); ?>" 
          class="w-full h-auto max-h-[580px] object-cover sm:object-contain md:object-cover mx-auto"
        >
      </div>
    <?php endif; ?>
  </section>

<?php endif; ?>

<!-- ============================================ -->
<!-- 2. INFINITE MARQUEE TICKER (SCREENSHOT 1)    -->
<!-- ============================================ -->
<div class="marquee-wrapper">
  <div class="marquee-content">
    <?php foreach ($marqueeItems as $item): ?>
      <div class="marquee-item"><span class="marquee-star">✦</span> <?php echo htmlspecialchars($item); ?></div>
    <?php endforeach; ?>
  </div>
  <!-- Clone for smooth infinite seamless scroll -->
  <div class="marquee-content" aria-hidden="true">
    <?php foreach ($marqueeItems as $item): ?>
      <div class="marquee-item"><span class="marquee-star">✦</span> <?php echo htmlspecialchars($item); ?></div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ============================================ -->
<!-- 3. SHOP BY CATEGORIES (SCREENSHOT 2)         -->
<!-- ============================================ -->
<section class="py-16 sm:py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Title -->
    <div class="text-center mb-12">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 tracking-tight">
        Shop By Categories
      </h2>
      <p class="mt-2 text-sm text-neutral-500 max-w-xl mx-auto">
        Explore our curated collection of complete bottles, caps, pumps, fragrance compounds, and luxury box packaging.
      </p>
    </div>

    <!-- Categories Grid (Matches Screenshot 2) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
      <?php foreach ($categories as $cat): ?>
        <a href="products.php?category=<?php echo urlencode($cat['id']); ?>" class="category-card group">
          <div class="category-image-wrap shadow-sm group-hover:shadow-md transition">
            <img 
              src="<?php echo htmlspecialchars($cat['image']); ?>" 
              alt="<?php echo htmlspecialchars($cat['title']); ?>" 
              loading="lazy"
            >
          </div>
          <h3 class="category-title">
            <?php echo htmlspecialchars($cat['title']); ?>
          </h3>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ============================================ -->
<!-- 4. SHOP ALL PRODUCTS (SCREENSHOT 3)          -->
<!-- ============================================ -->
<section id="products-section" class="py-16 sm:py-20 bg-[#fafafa] border-t border-neutral-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center mb-10">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 tracking-tight">
        Shop All Products
      </h2>
      <p class="mt-2 text-sm text-neutral-500">
        Engineered glass flacons, precision fine mist dispensers, and luxury caps ready for instant B2B quotation.
      </p>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
      <button class="filter-tab-btn active px-4 py-1.5 rounded-full text-xs font-semibold bg-neutral-900 text-white transition" data-filter="all">
        All Products (<?php echo count($products); ?>)
      </button>
      <?php 
      // Show up to 4 top category filter tabs
      $topFilters = array_slice($categories, 0, 4);
      foreach ($topFilters as $tf): 
      ?>
        <button class="filter-tab-btn px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-neutral-700 hover:bg-neutral-100 border border-neutral-200 transition" data-filter="<?php echo htmlspecialchars($tf['id']); ?>">
          <?php echo htmlspecialchars($tf['title']); ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- 4-Column Product Grid (Matches Screenshot 3) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($products as $prod): ?>
        <div class="product-card group" data-category="<?php echo htmlspecialchars($prod['category']); ?>">
          
          <!-- Badge -->
          <?php if (!empty($prod['badge'])): ?>
            <span class="product-badge">
              <?php echo htmlspecialchars($prod['badge']); ?>
            </span>
          <?php endif; ?>

          <!-- Product Image Wrap -->
          <div class="product-image-wrap">
            <img 
              src="<?php echo htmlspecialchars($prod['image']); ?>" 
              alt="<?php echo htmlspecialchars($prod['title']); ?>" 
              loading="lazy"
            >
          </div>

          <!-- Product Title -->
          <h3 class="product-title" title="<?php echo htmlspecialchars($prod['title']); ?>">
            <?php echo htmlspecialchars($prod['title']); ?>
          </h3>

          <!-- Meta (Price & MOQ) -->
          <div class="product-meta">
            <span class="product-price">
              <?php echo formatPrice($prod['price']); ?>
            </span>
            <span class="product-moq">
              MOQ: <?php echo $prod['moq']; ?> pcs
            </span>
          </div>

          <!-- Select Options Action Button -->
          <button 
            type="button"
            class="btn-select-options open-product-modal"
            data-product-id="<?php echo htmlspecialchars($prod['id']); ?>"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Select options</span>
          </button>

        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ============================================ -->
<!-- 5. B2B WHOLESALE & CUSTOM BRANDING BANNER    -->
<!-- ============================================ -->
<section class="py-16 bg-[#111111] text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="text-xs font-bold uppercase tracking-widest text-gold block mb-2">Turnkey Private Label Services</span>
        <h2 class="text-2xl sm:text-4xl font-extrabold font-serif leading-tight">
          Launching a New Fragrance Brand? We Supply Everything.
        </h2>
        <p class="mt-4 text-sm text-neutral-300 leading-relaxed">
          From custom mold fabrication with your signature embossed logo to electroplated magnetic caps, French fine mist crimp sprayers, and luxury rigid box packaging — Panna Heera Perfumery is your single-source manufacturing partner.
        </p>
        
        <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
          <div class="p-3 bg-neutral-900 rounded-lg border border-neutral-800">
            <span class="text-gold font-bold text-base block mb-1">01. Moulding</span>
            <span class="text-neutral-400">Custom 3D CAD & private glass moulds</span>
          </div>
          <div class="p-3 bg-neutral-900 rounded-lg border border-neutral-800">
            <span class="text-gold font-bold text-base block mb-1">02. Printing</span>
            <span class="text-neutral-400">Hot stamping, UV screen & frosted coats</span>
          </div>
          <div class="p-3 bg-neutral-900 rounded-lg border border-neutral-800">
            <span class="text-gold font-bold text-base block mb-1">03. Assembly</span>
            <span class="text-neutral-400">Pumps, collars, caps tested leak-proof</span>
          </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-4">
          <a href="<?php echo getWhatsAppLink('Hi Panna Heera Perfumery, I want to discuss custom bottle branding and private label manufacturing.'); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-6 py-3 rounded-full text-xs sm:text-sm font-bold tracking-wide transition inline-flex items-center gap-2">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
            Speak With Packaging Specialist
          </a>
          <a href="contact.php" class="bg-neutral-800 hover:bg-neutral-700 text-white px-6 py-3 rounded-full text-xs sm:text-sm font-bold tracking-wide transition">
            Request Sample Kit
          </a>
        </div>
      </div>

      <div class="relative">
        <div class="p-6 bg-neutral-900 border border-neutral-800 rounded-2xl">
          <div class="flex items-center justify-between border-b border-neutral-800 pb-4 mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">B2B Wholesale Advantages</span>
            <span class="text-xs text-gold">✦ Verified Manufacturer</span>
          </div>
          <ul class="space-y-3.5 text-xs text-neutral-300">
            <li class="flex items-start gap-2.5">
              <span class="text-[#25D366] font-bold">✓</span>
              <span><strong>Low MOQ Starter Tiers:</strong> Test market response with pilot batches starting at only 50-100 pcs.</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="text-[#25D366] font-bold">✓</span>
              <span><strong>Optical Grade Super Flint Glass:</strong> Heavy weight bottom, crystal clear transparency with zero green tint.</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="text-[#25D366] font-bold">✓</span>
              <span><strong>Exact Neck Standards:</strong> Universal FEA 15mm crimp and 18/415 screw finishes compatible with global accessories.</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="text-[#25D366] font-bold">✓</span>
              <span><strong>Leak & Alcohol Resistance Tested:</strong> Every pump and valve tested against aggressive fragrance alcohol compounds.</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="text-[#25D366] font-bold">✓</span>
              <span><strong>Pan-India & Global Freight:</strong> Secure palletized master cartons for transit with zero breakage guarantee.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Filter Tabs Inline Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const filterBtns = document.querySelectorAll('.filter-tab-btn');
  const cards = document.querySelectorAll('.product-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => {
        b.classList.remove('active', 'bg-neutral-900', 'text-white');
        b.classList.add('bg-white', 'text-neutral-700');
      });
      btn.classList.add('active', 'bg-neutral-900', 'text-white');
      btn.classList.remove('bg-white', 'text-neutral-700');

      const filter = btn.getAttribute('data-filter');
      cards.forEach(card => {
        if (filter === 'all' || card.getAttribute('data-category') === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
