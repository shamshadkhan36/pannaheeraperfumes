<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$activeCategory = isset($_GET['category']) ? trim($_GET['category']) : 'all';
$filteredProducts = getProductsByCategory($activeCategory);

$activeCategoryObj = null;
foreach ($categories as $c) {
    if ($c['id'] === $activeCategory) {
        $activeCategoryObj = $c;
        break;
    }
}

$pageTitle = $activeCategoryObj ? $activeCategoryObj['title'] : 'All Products Catalog';
include_once __DIR__ . '/includes/header.php';
?>

<!-- Catalog Header Banner -->
<div class="bg-neutral-900 text-white py-12 border-b border-neutral-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <nav class="text-xs text-neutral-400 mb-2">
          <a href="index.php" class="hover:text-white">Home</a>
          <span class="mx-2">/</span>
          <span class="text-gold"><?php echo $activeCategoryObj ? htmlspecialchars($activeCategoryObj['title']) : 'All Products'; ?></span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
          <?php echo $activeCategoryObj ? htmlspecialchars($activeCategoryObj['title']) : 'Complete Perfumery Catalog'; ?>
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 mt-1 max-w-xl">
          <?php echo $activeCategoryObj ? htmlspecialchars($activeCategoryObj['subtitle']) : 'Explore premium glass bottles, caps, pumps, and custom perfume packaging for prestige brands.'; ?>
        </p>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?php echo getWhatsAppLink('Hi Panna Heera Perfumery, I want to download your complete wholesale product catalog & price list.'); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-2 shadow-sm transition">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
          Request Price List PDF
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main Catalog Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="flex flex-col lg:flex-row gap-8">
    
    <!-- Sidebar Filters (Desktop) -->
    <aside class="w-full lg:w-64 flex-shrink-0">
      <div class="bg-white p-5 rounded-xl border border-neutral-200 shadow-sm sticky top-24 space-y-6">
        <div>
          <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-3">Categories</h3>
          <ul class="space-y-1 text-sm">
            <li>
              <a href="products.php" class="flex items-center justify-between py-1.5 px-2.5 rounded-md <?php echo $activeCategory === 'all' ? 'bg-neutral-900 text-white font-semibold' : 'text-neutral-700 hover:bg-neutral-50'; ?>">
                <span>All Categories</span>
                <span class="text-xs <?php echo $activeCategory === 'all' ? 'text-neutral-300' : 'text-neutral-400'; ?>"><?php echo count($products); ?></span>
              </a>
            </li>
            <?php foreach ($categories as $cat): ?>
              <li>
                <a href="products.php?category=<?php echo urlencode($cat['id']); ?>" class="flex items-center justify-between py-1.5 px-2.5 rounded-md <?php echo $activeCategory === $cat['id'] ? 'bg-neutral-900 text-white font-semibold' : 'text-neutral-700 hover:bg-neutral-50'; ?>">
                  <span><?php echo htmlspecialchars($cat['title']); ?></span>
                  <span class="text-xs <?php echo $activeCategory === $cat['id'] ? 'text-neutral-300' : 'text-neutral-400'; ?>"><?php echo $cat['count']; ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="pt-4 border-t border-neutral-100">
          <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-2">Need Custom Tooling?</h3>
          <p class="text-xs text-neutral-500 mb-3 leading-relaxed">We engineer custom private molds with your logo embossing starting from 5,000 pcs MOQ.</p>
          <a href="<?php echo getWhatsAppLink('Hi, I would like to inquire about private mold development for our brand.'); ?>" target="_blank" class="block text-center text-xs font-bold bg-neutral-100 hover:bg-neutral-200 text-neutral-800 py-2 rounded-lg transition">
            Speak with Mold Engineer
          </a>
        </div>
      </div>
    </aside>

    <!-- Product Grid Section -->
    <main class="flex-1">
      <div class="flex items-center justify-between mb-6 pb-3 border-b border-neutral-200">
        <span class="text-xs font-medium text-neutral-500">Showing <strong class="text-neutral-900"><?php echo count($filteredProducts); ?></strong> products</span>
        <button class="search-modal-trigger text-xs font-semibold text-neutral-700 hover:text-gold flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          Search Catalog
        </button>
      </div>

      <?php if (empty($filteredProducts)): ?>
        <div class="py-16 text-center bg-white rounded-xl border border-neutral-200 p-8">
          <p class="text-neutral-500 text-sm mb-4">No products found in this category.</p>
          <a href="products.php" class="inline-block bg-black text-white text-xs font-semibold px-5 py-2.5 rounded-full hover:bg-neutral-800 transition">
            View All Products
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
          <?php foreach ($filteredProducts as $prod): ?>
            <div class="product-card group">
              <?php if (!empty($prod['badge'])): ?>
                <span class="product-badge"><?php echo htmlspecialchars($prod['badge']); ?></span>
              <?php endif; ?>

              <div class="product-image-wrap">
                <img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['title']); ?>" loading="lazy">
              </div>

              <h3 class="product-title" title="<?php echo htmlspecialchars($prod['title']); ?>">
                <?php echo htmlspecialchars($prod['title']); ?>
              </h3>

              <div class="product-meta">
                <span class="product-price"><?php echo formatPrice($prod['price']); ?></span>
                <span class="product-moq">MOQ: <?php echo $prod['moq']; ?> pcs</span>
              </div>

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
      <?php endif; ?>
    </main>

  </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
