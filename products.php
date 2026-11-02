<?php
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$activeCategory = isset($_GET['category']) ? trim($_GET['category']) : 'all';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$currentPageNum = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 24;

if ($activeCategory === 'fragrance-compounds') {
    $activeCategory = 'all';
}

$allCategoryProducts = getProductsByCategory($activeCategory);

// Search filter if provided
if (!empty($searchQuery)) {
    $qLower = strtolower($searchQuery);
    $filteredProducts = array_values(array_filter($allCategoryProducts, function($p) use ($qLower) {
        return strpos(strtolower($p['title']), $qLower) !== false
            || strpos(strtolower($p['brand']), $qLower) !== false
            || strpos((string)$p['sno'], $qLower) !== false;
    }));
} else {
    $filteredProducts = $allCategoryProducts;
}

$totalItems = count($filteredProducts);
$totalPages = max(1, (int)ceil($totalItems / $perPage));
if ($currentPageNum > $totalPages) {
    $currentPageNum = $totalPages;
}
$offset = ($currentPageNum - 1) * $perPage;
$pageProducts = array_slice($filteredProducts, $offset, $perPage);
$startItem = $totalItems > 0 ? $offset + 1 : 0;
$endItem = min($offset + $perPage, $totalItems);

$activeCategoryObj = null;
foreach ($categories as $c) {
    if ($c['id'] === $activeCategory) {
        $activeCategoryObj = $c;
        break;
    }
}

$pageTitle = $activeCategoryObj ? $activeCategoryObj['title'] . " ({$totalItems} Fragrance Oils)" : "All Fragrance Compounds ({$totalItems} Products)";
$currentPage = 'products';
include_once __DIR__ . '/includes/header.php';
?>

<!-- Catalog Header Banner -->
<div class="bg-neutral-950 text-white py-12 border-b border-neutral-800 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d4af37_1px,transparent_1px)] [background-size:16px_16px]"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <div>
        <nav class="text-xs text-neutral-400 mb-2 flex items-center gap-2">
          <a href="index.php" class="hover:text-white transition">Home</a>
          <span>/</span>
          <a href="products.php" class="hover:text-white transition">Products Catalog</a>
          <?php if ($activeCategoryObj): ?>
            <span>/</span>
            <span class="text-gold font-semibold"><?php echo htmlspecialchars($activeCategoryObj['title']); ?></span>
          <?php endif; ?>
        </nav>
        <div class="flex items-center gap-2.5 mb-2">
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-widest uppercase bg-gold/20 text-gold border border-gold/40">
            ✦ 100% Pure Compounds
          </span>
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white/10 text-neutral-300">
            <?php echo number_format($totalItems); ?> Products Available
          </span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black font-serif text-white tracking-tight leading-tight">
          <?php echo $activeCategoryObj ? htmlspecialchars($activeCategoryObj['title']) : 'Complete Fragrance Compounds Catalog'; ?>
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 mt-1.5 max-w-2xl leading-relaxed">
          <?php echo $activeCategoryObj ? htmlspecialchars($activeCategoryObj['subtitle']) : 'Explore pure undiluted French, Oriental, Arabic and botanical fragrance oils in 100 GM production packs and 1 KG bulk wholesale flacons.'; ?>
        </p>
      </div>

      <div class="flex items-center gap-3 flex-wrap flex-shrink-0">
        <a href="assets/docs/panna-heera-price-list.pdf" download class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-neutral-950 px-5 py-3 rounded-xl text-xs font-bold inline-flex items-center gap-2 shadow-lg transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download PDF Price List
        </a>
        <a href="fragrances.php" class="bg-neutral-800 hover:bg-neutral-700 text-white px-5 py-3 rounded-xl text-xs font-bold inline-flex items-center gap-2 shadow-sm transition border border-neutral-700">
          <span>Table & Live Directory</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>

  <!-- Wholesale & Legal Benchmark Disclaimer Notice -->
  <div class="mt-14 p-6 sm:p-8 rounded-2xl bg-neutral-50 border border-neutral-200 space-y-4">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 rounded-full bg-gold"></span>
      <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Wholesale Compounding Terms & Legal Notice</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-neutral-600">
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">1. Olfactory Benchmark Inspiration</strong>
        <p class="leading-relaxed">Names listed are olfactive inspiration benchmarks to identify scent profiles and notes. Products are proprietary Panna Heera compound formulations.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">2. 100% Pure & Alcohol-Free</strong>
        <p class="leading-relaxed">All fragrance oils supplied in this catalog are pure, undiluted, and completely alcohol-free concentrates suitable for perfume blending and attar manufacture.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">3. Tier Pricing & Pan-India Dispatch</strong>
        <p class="leading-relaxed">Minimum wholesale order is 100 GM. Bulk 1 KG aluminum flacons feature special wholesale volume discounts. Orders ship pan-India with secure couriers.</p>
      </div>
    </div>
  </div>
</div>

<!-- Main Catalog Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <div class="flex flex-col lg:flex-row gap-8">
    
    <!-- Sidebar Filters (Desktop) -->
    <aside class="w-full lg:w-72 flex-shrink-0">
      <div class="bg-white p-5 rounded-2xl border border-neutral-200 shadow-sm sticky top-24 space-y-6">
        
        <!-- Search Input in Sidebar -->
        <div>
          <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-2.5">Search Category</h3>
          <form method="GET" action="products.php" class="relative">
            <?php if ($activeCategory !== 'all'): ?>
              <input type="hidden" name="category" value="<?php echo htmlspecialchars($activeCategory); ?>">
            <?php endif; ?>
            <input 
              type="text" 
              name="search" 
              value="<?php echo htmlspecialchars($searchQuery); ?>" 
              placeholder="Search by name, house..." 
              class="w-full pl-9 pr-8 py-2 text-xs rounded-xl border border-neutral-300 focus:outline-none focus:border-neutral-900 font-medium"
            >
            <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <?php if (!empty($searchQuery)): ?>
              <a href="products.php?category=<?php echo urlencode($activeCategory); ?>" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-700 text-xs font-bold">✕</a>
            <?php endif; ?>
          </form>
        </div>

        <!-- Categories List with Exact Matching Counts -->
        <div>
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Fragrance Categories</h3>
            <span class="text-[11px] font-bold text-gold">1,040 Total</span>
          </div>
          <ul class="space-y-1.5 text-xs">
            <li>
              <a href="products.php" class="flex items-center justify-between py-2.5 px-3 rounded-xl transition <?php echo $activeCategory === 'all' ? 'bg-neutral-900 text-white font-bold shadow-sm' : 'text-neutral-700 hover:bg-neutral-100 font-medium'; ?>">
                <span>All Fragrance Compounds</span>
                <span class="text-xs px-2 py-0.5 rounded-full <?php echo $activeCategory === 'all' ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-700'; ?> font-bold font-mono"><?php echo count($products); ?></span>
              </a>
            </li>
            <?php foreach ($categories as $cat): ?>
              <li>
                <a href="products.php?category=<?php echo urlencode($cat['id']); ?>" class="flex items-center justify-between py-2.5 px-3 rounded-xl transition <?php echo $activeCategory === $cat['id'] ? 'bg-neutral-900 text-white font-bold shadow-sm' : 'text-neutral-700 hover:bg-neutral-100 font-medium'; ?>">
                  <span class="truncate mr-2"><?php echo htmlspecialchars($cat['title']); ?></span>
                  <span class="text-xs px-2 py-0.5 rounded-full <?php echo $activeCategory === $cat['id'] ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-700'; ?> font-bold font-mono"><?php echo $cat['count']; ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Wholesale Order Notice -->
        <div class="pt-4 border-t border-neutral-100 space-y-2.5">
          <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-gold"></span>
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Wholesale Lot Sizes</h3>
          </div>
          <p class="text-[11px] text-neutral-500 leading-relaxed">
            Supplied in <strong>100 GM</strong> production bottles and <strong>1 KG</strong> sealed aluminum flacons with volume discounts.
          </p>
          <a href="<?php echo getWhatsAppLink('Hi Panna Heera Perfumery, I want to inquire about bulk wholesale fragrance compounds.'); ?>" target="_blank" class="block text-center text-xs font-bold bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 rounded-xl transition shadow-sm">
            Inquire Bulk Rates on WhatsApp
          </a>
        </div>

      </div>
    </aside>

    <!-- Product Grid Section -->
    <main class="flex-1 min-w-0">
      
      <!-- Top Bar: Results Count & Directory Switcher -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-neutral-200">
        <div>
          <span class="text-xs font-medium text-neutral-500">
            Showing <strong class="text-neutral-900 font-mono"><?php echo number_format($startItem); ?></strong> to <strong class="text-neutral-900 font-mono"><?php echo number_format($endItem); ?></strong> of <strong class="text-neutral-900 font-mono"><?php echo number_format($totalItems); ?></strong> products
          </span>
          <?php if (!empty($searchQuery)): ?>
            <span class="ml-1 text-xs text-neutral-500">
              for query "<strong class="text-neutral-900"><?php echo htmlspecialchars($searchQuery); ?></strong>" 
              (<a href="products.php?category=<?php echo urlencode($activeCategory); ?>" class="text-amber-600 hover:underline">Clear</a>)
            </span>
          <?php endif; ?>
        </div>

        <div class="flex items-center gap-2">
          <button class="search-modal-trigger text-xs font-semibold text-neutral-700 hover:text-gold flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 bg-neutral-50 hover:bg-white transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span>Live Search</span>
          </button>
          <a href="fragrances.php" class="text-xs font-bold text-neutral-700 hover:text-amber-600 flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 bg-neutral-50 hover:bg-white transition" title="Open full 1,040 oil rate book">
            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>Table View</span>
          </a>
        </div>
      </div>

      <?php if (empty($pageProducts)): ?>
        <div class="py-16 text-center bg-white rounded-2xl border border-neutral-200 p-8 space-y-3">
          <div class="w-14 h-14 rounded-full bg-neutral-100 flex items-center justify-center mx-auto text-neutral-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <h3 class="text-base font-bold text-neutral-800">No fragrance compounds found</h3>
          <p class="text-xs text-neutral-500 max-w-sm mx-auto">
            No products matched your search in this category. Try clearing filters to view all 1,040 varieties.
          </p>
          <a href="products.php" class="inline-block bg-neutral-900 text-white text-xs font-bold px-5 py-2.5 rounded-full hover:bg-black transition">
            View All 1,040 Products
          </a>
        </div>
      <?php else: ?>
        
        <!-- Responsive Product Cards Grid (3 Columns on Large Screens) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
          <?php foreach ($pageProducts as $prod): 
            $order1kgUrl = getWhatsAppLink("Hello Panna Heera Perfumery! I would like to order fragrance oil:\n\n*Compound:* {$prod['title']} (#{$prod['sno']})\n*Category:* {$prod['category_title']}\n*Selected Weight:* 1 KG Wholesale\n*Listed Rate:* " . formatPrice($prod['price_1kg']) . "\n\nPlease share delivery timeline and payment details.");
            $order100gUrl = getWhatsAppLink("Hello Panna Heera Perfumery! I would like to order fragrance oil:\n\n*Compound:* {$prod['title']} (#{$prod['sno']})\n*Category:* {$prod['category_title']}\n*Selected Weight:* 100 GM Pack\n*Listed Rate:* " . formatPrice($prod['price_100gm']) . "\n\nPlease share payment details.");
          ?>
            <div class="product-card group bg-white rounded-2xl border border-neutral-200/80 shadow-sm hover:shadow-xl hover:border-neutral-300 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
              <div>
                <!-- Top Photo Wrapper -->
                <div class="relative aspect-square bg-gradient-to-br from-neutral-100 via-neutral-50 to-amber-50/40 overflow-hidden flex items-center justify-center border-b border-neutral-100">
                  <img 
                    src="<?php echo htmlspecialchars($prod['image']); ?>?v=3.0" 
                    alt="<?php echo htmlspecialchars($prod['title']); ?>" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                    loading="lazy"
                  >
                  
                  <!-- Top Badges -->
                  <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                    <span class="bg-neutral-950/85 backdrop-blur text-white text-[10px] font-mono font-black px-2.5 py-0.5 rounded-full shadow border border-white/10">
                      #<?php echo $prod['sno']; ?>
                    </span>
                    <span class="bg-gradient-to-r from-amber-500 to-amber-600 text-neutral-950 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow">
                      100% Pure Oil
                    </span>
                  </div>
                </div>

                <!-- Text Content -->
                <div class="p-4 space-y-2">
                  <div class="flex items-center gap-1.5 text-[10px] text-neutral-400 font-semibold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span class="truncate"><?php echo htmlspecialchars($prod['category_title']); ?></span>
                  </div>

                  <h3 class="font-extrabold text-neutral-900 text-sm leading-snug line-clamp-2 min-h-[2.5rem] group-hover:text-amber-700 transition" title="<?php echo htmlspecialchars($prod['title']); ?>">
                    <a href="product-detail.php?id=<?php echo urlencode($prod['id']); ?>">
                      <?php echo htmlspecialchars($prod['short_title'] ?? $prod['title']); ?>
                    </a>
                  </h3>

                  <div class="text-[11px] text-neutral-500 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                      <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                      In Stock
                    </span>
                    <span>•</span>
                    <span>MOQ: 100 GM</span>
                  </div>

                  <!-- Notes Section Inside Card (if available) - Non-scrolling 3-tier grid -->
                  <?php 
                  $pNotes = $prod['notes'] ?? [];
                  $pTop = $pNotes['top'] ?? [];
                  $pMid = $pNotes['middle'] ?? [];
                  $pBase = $pNotes['base'] ?? [];
                  $hasPNotes = !empty($pTop) || !empty($pMid) || !empty($pBase);
                  if ($hasPNotes):
                    $topLead = $pTop[0] ?? null;
                    $topCount = count($pTop);
                    $topExtra = $topCount > 1 ? '+' . ($topCount - 1) . ' more' : '';

                    $midLead = $pMid[0] ?? null;
                    $midCount = count($pMid);
                    $midExtra = $midCount > 1 ? '+' . ($midCount - 1) . ' more' : '';

                    $baseLead = $pBase[0] ?? null;
                    $baseCount = count($pBase);
                    $baseExtra = $baseCount > 1 ? '+' . ($baseCount - 1) . ' more' : '';
                  ?>
                    <div class="pt-2">
                      <a href="product-detail.php?id=<?php echo urlencode($prod['id']); ?>#olfactory-notes" class="block bg-neutral-50/90 hover:bg-neutral-100/90 rounded-2xl p-2.5 border border-neutral-200/90 transition shadow-xs group/pyramid">
                        <div class="flex items-center justify-between text-[10px] font-bold text-neutral-600 mb-2 px-0.5">
                          <span class="flex items-center gap-1 uppercase tracking-wider text-[#2c405a]">
                            <svg class="w-3 h-3 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>Olfactory Pyramid</span>
                          </span>
                          <span class="text-gold font-bold group-hover/pyramid:underline flex items-center gap-0.5 text-[10px]">
                            View Full &rarr;
                          </span>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5 text-center">
                          <!-- Top Note -->
                          <div class="flex flex-col items-center bg-white p-1.5 rounded-xl border border-neutral-200/80 shadow-[0_1px_2px_rgba(0,0,0,0.03)]">
                            <span class="text-[8px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded-full mb-1">Top</span>
                            <?php if ($topLead): ?>
                              <div class="w-10 h-10 rounded-lg p-0.5 flex items-center justify-center overflow-hidden">
                                <img src="<?php echo htmlspecialchars($topLead['image']); ?>" alt="<?php echo htmlspecialchars($topLead['name']); ?>" class="max-w-full max-h-full object-contain">
                              </div>
                              <span class="text-[10px] font-bold text-neutral-800 truncate w-full mt-1 leading-tight" title="<?php echo htmlspecialchars($topLead['name']); ?>">
                                <?php echo htmlspecialchars($topLead['name']); ?>
                              </span>
                              <?php if ($topExtra): ?><span class="text-[8px] font-semibold text-neutral-400 mt-0.5"><?php echo $topExtra; ?></span><?php endif; ?>
                            <?php else: ?>
                              <div class="w-10 h-10 rounded-lg flex items-center justify-center text-neutral-300 text-xs">—</div>
                              <span class="text-[10px] text-neutral-400">—</span>
                            <?php endif; ?>
                          </div>

                          <!-- Heart Note -->
                          <div class="flex flex-col items-center bg-white p-1.5 rounded-xl border border-neutral-200/80 shadow-[0_1px_2px_rgba(0,0,0,0.03)]">
                            <span class="text-[8px] font-black uppercase tracking-wider text-rose-800 bg-rose-50 border border-rose-200 px-1.5 py-0.5 rounded-full mb-1">Heart</span>
                            <?php if ($midLead): ?>
                              <div class="w-10 h-10 rounded-lg p-0.5 flex items-center justify-center overflow-hidden">
                                <img src="<?php echo htmlspecialchars($midLead['image']); ?>" alt="<?php echo htmlspecialchars($midLead['name']); ?>" class="max-w-full max-h-full object-contain">
                              </div>
                              <span class="text-[10px] font-bold text-neutral-800 truncate w-full mt-1 leading-tight" title="<?php echo htmlspecialchars($midLead['name']); ?>">
                                <?php echo htmlspecialchars($midLead['name']); ?>
                              </span>
                              <?php if ($midExtra): ?><span class="text-[8px] font-semibold text-neutral-400 mt-0.5"><?php echo $midExtra; ?></span><?php endif; ?>
                            <?php else: ?>
                              <div class="w-10 h-10 rounded-lg flex items-center justify-center text-neutral-300 text-xs">—</div>
                              <span class="text-[10px] text-neutral-400">—</span>
                            <?php endif; ?>
                          </div>

                          <!-- Base Note -->
                          <div class="flex flex-col items-center bg-white p-1.5 rounded-xl border border-neutral-200/80 shadow-[0_1px_2px_rgba(0,0,0,0.03)]">
                            <span class="text-[8px] font-black uppercase tracking-wider text-amber-900 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded-full mb-1">Base</span>
                            <?php if ($baseLead): ?>
                              <div class="w-10 h-10 rounded-lg p-0.5 flex items-center justify-center overflow-hidden">
                                <img src="<?php echo htmlspecialchars($baseLead['image']); ?>" alt="<?php echo htmlspecialchars($baseLead['name']); ?>" class="max-w-full max-h-full object-contain">
                              </div>
                              <span class="text-[10px] font-bold text-neutral-800 truncate w-full mt-1 leading-tight" title="<?php echo htmlspecialchars($baseLead['name']); ?>">
                                <?php echo htmlspecialchars($baseLead['name']); ?>
                              </span>
                              <?php if ($baseExtra): ?><span class="text-[8px] font-semibold text-neutral-400 mt-0.5"><?php echo $baseExtra; ?></span><?php endif; ?>
                            <?php else: ?>
                              <div class="w-10 h-10 rounded-lg flex items-center justify-center text-neutral-300 text-xs">—</div>
                              <span class="text-[10px] text-neutral-400">—</span>
                            <?php endif; ?>
                          </div>
                        </div>
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Pricing & Action Buttons -->
              <div class="p-4 pt-0 space-y-3">
                <!-- 2 Pricing Tiers -->
                <div class="grid grid-cols-2 gap-2 text-center bg-neutral-50 p-2 rounded-xl border border-neutral-200/80">
                  <a href="<?php echo $order100gUrl; ?>" target="_blank" title="Order 100 GM on WhatsApp" class="hover:bg-white p-1.5 rounded-lg transition group/p">
                    <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider group-hover/p:text-neutral-700">100 GM</span>
                    <strong class="text-neutral-800 font-mono block text-sm font-bold whitespace-nowrap"><?php echo formatPrice($prod['price_100gm']); ?></strong>
                  </a>
                  <a href="<?php echo $order1kgUrl; ?>" target="_blank" title="Order 1 KG Wholesale on WhatsApp" class="bg-amber-100/70 hover:bg-amber-200/70 p-1.5 rounded-lg border border-amber-300/60 transition group/p">
                    <span class="text-amber-800 block text-[10px] font-black uppercase tracking-wider">1 KG Bulk</span>
                    <strong class="text-amber-950 font-mono block text-sm font-black whitespace-nowrap"><?php echo formatPrice($prod['price_1kg']); ?></strong>
                  </a>
                </div>

                <!-- CTAs -->
                <div class="flex items-center gap-1.5">
                  <a 
                    href="<?php echo $order1kgUrl; ?>" 
                    target="_blank" 
                    class="flex-1 bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 px-3 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-1.5 transition shadow-sm hover:shadow-md"
                  >
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
                    <span>WhatsApp Order</span>
                  </a>
                  <button 
                    type="button" 
                    class="open-product-modal bg-neutral-900 hover:bg-black text-white text-[11px] font-bold py-2.5 px-3 rounded-xl transition shadow-sm"
                    data-product-id="<?php echo htmlspecialchars($prod['id']); ?>"
                    title="Select pack sizes & customize"
                  >
                    Packs
                  </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Server-Side Pagination Controls -->
        <?php if ($totalPages > 1): ?>
          <div class="mt-12 flex items-center justify-between flex-wrap gap-4 pt-6 border-t border-neutral-200">
            <div class="text-xs text-neutral-500">
              Showing <strong class="text-neutral-900"><?php echo number_format($startItem); ?></strong> to <strong class="text-neutral-900"><?php echo number_format($endItem); ?></strong> of <strong class="text-neutral-900"><?php echo number_format($totalItems); ?></strong> products (Page <?php echo $currentPageNum; ?> of <?php echo $totalPages; ?>)
            </div>
            
            <div class="flex items-center gap-1.5">
              <?php
              $catParam = ($activeCategory !== 'all') ? '&category=' . urlencode($activeCategory) : '';
              $searchParam = !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '';
              $buildPageUrl = function($p) use ($catParam, $searchParam) {
                  return "products.php?page={$p}{$catParam}{$searchParam}";
              };

              // Prev Button
              if ($currentPageNum > 1): ?>
                <a href="<?php echo $buildPageUrl($currentPageNum - 1); ?>" class="page-nav-btn">‹ Prev</a>
              <?php endif;

              // Visible Page Window
              $startP = max(1, $currentPageNum - 2);
              $endP = min($totalPages, $startP + 4);
              if ($endP - $startP < 4) {
                  $startP = max(1, $endP - 4);
              }

              if ($startP > 1): ?>
                <a href="<?php echo $buildPageUrl(1); ?>" class="page-num-btn">1</a>
                <?php if ($startP > 2): ?><span class="px-2 text-neutral-400">...</span><?php endif; ?>
              <?php endif;

              for ($p = $startP; $p <= $endP; $p++):
                $activeCls = ($p === $currentPageNum) ? 'active' : '';
              ?>
                <a href="<?php echo $buildPageUrl($p); ?>" class="page-num-btn <?php echo $activeCls; ?>"><?php echo $p; ?></a>
              <?php endfor;

              if ($endP < $totalPages): ?>
                <?php if ($endP < $totalPages - 1): ?><span class="px-2 text-neutral-400">...</span><?php endif; ?>
                <a href="<?php echo $buildPageUrl($totalPages); ?>" class="page-num-btn"><?php echo $totalPages; ?></a>
              <?php endif;

              // Next Button
              if ($currentPageNum < $totalPages): ?>
                <a href="<?php echo $buildPageUrl($currentPageNum + 1); ?>" class="page-nav-btn">Next ›</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

      <?php endif; ?>
    </main>

  </div>

  <!-- Wholesale & Legal Benchmark Disclaimer Notice -->
  <div class="mt-14 p-6 sm:p-8 rounded-2xl bg-neutral-50 border border-neutral-200 space-y-4">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 rounded-full bg-gold"></span>
      <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Wholesale Compounding Terms & Legal Notice</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-neutral-600">
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">1. Olfactory Benchmark Inspiration</strong>
        <p class="leading-relaxed">Names listed are olfactive inspiration benchmarks to identify scent profiles and notes. Products are proprietary Panna Heera compound formulations.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">2. 100% Pure & Alcohol-Free</strong>
        <p class="leading-relaxed">All fragrance oils supplied in this catalog are pure, undiluted, and completely alcohol-free concentrates suitable for perfume blending and attar manufacture.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">3. Tier Pricing & Pan-India Dispatch</strong>
        <p class="leading-relaxed">Minimum wholesale order is 100 GM. Bulk 1 KG aluminum flacons feature special wholesale volume discounts. Orders ship pan-India with secure couriers.</p>
      </div>
    </div>
  </div>
</div>

<?php
include_once __DIR__ . '/includes/modals.php';
include_once __DIR__ . '/includes/footer.php';
?>
