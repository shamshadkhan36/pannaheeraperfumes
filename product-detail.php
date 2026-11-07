<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$productId = isset($_GET['id']) ? trim($_GET['id']) : 'oil-1';
$product = getProductById($productId);

if (!$product) {
    // Fallback to first product
    $product = $products[0];
}

$pageTitle = $product['title'];
include_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumbs -->
<div class="bg-neutral-100 border-b border-neutral-200 py-3 text-xs text-neutral-500">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2">
    <a href="index.php" class="hover:text-neutral-900">Home</a>
    <span>/</span>
    <a href="products.php?category=<?php echo urlencode($product['category']); ?>" class="hover:text-neutral-900"><?php echo htmlspecialchars($product['category_title']); ?></a>
    <span>/</span>
    <span class="text-neutral-900 font-semibold truncate max-w-xs"><?php echo htmlspecialchars($product['short_title'] ?? $product['title']); ?></span>
  </div>
</div>

<!-- Product Detail Hero -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    
    <!-- Product Gallery & Blueprint (7 cols) -->
    <div class="lg:col-span-7 space-y-6">
      <div class="bg-white border border-neutral-200 rounded-2xl p-6 sm:p-10 flex items-center justify-center relative shadow-sm aspect-square max-h-[560px]">
        <?php if (!empty($product['badge'])): ?>
          <span class="product-badge top-4 left-4"><?php echo htmlspecialchars($product['badge']); ?></span>
        <?php endif; ?>
        <img 
          src="<?php echo htmlspecialchars($product['image']); ?>?v=4.0" 
          alt="<?php echo htmlspecialchars($product['title']); ?>" 
          class="max-w-full max-h-full object-contain"
        >
      </div>

      <!-- Technical Dimensions Grid (if present) -->
      <?php if (!empty($product['dimensions'])): ?>
        <div class="bg-neutral-50 rounded-2xl border border-neutral-200 p-6">
          <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
            <h3 class="font-bold text-xs uppercase tracking-widest text-neutral-800">Formulation & Wholesale Specifications</h3>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
            <?php foreach ($product['dimensions'] as $key => $val): ?>
              <div class="bg-white p-3 rounded-lg border border-neutral-200">
                <span class="text-neutral-400 uppercase text-[10px] block"><?php echo htmlspecialchars($key); ?></span>
                <span class="text-neutral-900 font-bold mt-0.5 block"><?php echo htmlspecialchars($val); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Product Options & Ordering Desk (5 cols) -->
    <div class="lg:col-span-5 space-y-6">
      <div>
        <span class="text-xs font-bold uppercase tracking-widest text-gold block mb-1"><?php echo htmlspecialchars($product['category_title']); ?></span>
        <h1 class="text-xl sm:text-2xl font-black uppercase text-neutral-900 tracking-tight leading-tight">
          <?php echo htmlspecialchars($product['title']); ?>
        </h1>
      </div>

      <!-- Pricing & MOQ Tag -->
      <div class="flex items-center gap-4 py-3 border-y border-neutral-200">
        <div>
          <span class="text-xs text-neutral-500 block">Wholesale Rate (From)</span>
          <span class="text-2xl sm:text-3xl font-extrabold text-neutral-900"><?php echo formatPrice($product['price']); ?></span>
          <span class="text-xs text-neutral-500 font-normal">/ 100 GM pack</span>
        </div>
        <div class="h-8 w-px bg-neutral-200"></div>
        <div>
          <span class="text-xs text-neutral-500 block">Minimum Order</span>
          <span class="text-sm font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded border border-amber-200 inline-block mt-0.5">
            <?php echo htmlspecialchars($product['moq_label'] ?? ($product['moq'] . ' GM')); ?> MOQ
          </span>
        </div>
      </div>

      <p class="text-xs text-neutral-600 leading-relaxed">
        <?php echo htmlspecialchars($product['description']); ?>
      </p>

      <!-- Benchmark Notice -->
      <div class="p-2.5 rounded-xl bg-neutral-50 border border-neutral-200/80 text-[10px] text-neutral-500 leading-relaxed">
        <strong class="text-neutral-700">* Benchmark Reference:</strong> Trademark names mentioned are descriptive olfactory benchmarks to indicate scent notes and olfactory family. Panna Heera Perfumery produces proprietary compound formulations with 0% alcohol dilution and is not affiliated with the trademark holders.
      </div>

      <!-- Fragrance Notes Fast Summary (if present) -->
      <?php 
      $notes = $product['notes'] ?? [];
      $hasNotes = !empty($notes) && (!empty($notes['top']) || !empty($notes['middle']) || !empty($notes['base']));
      if ($hasNotes): 
      ?>
        <div class="p-3.5 bg-neutral-50/90 rounded-xl border border-neutral-200/90 space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-800 flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
              <span>Fragrance Notes Profile</span>
            </span>
            <a href="#olfactory-notes" class="text-[11px] font-bold text-gold hover:underline">View Olfactory Pyramid &darr;</a>
          </div>
          <div class="text-xs text-neutral-600 space-y-1">
            <?php if (!empty($notes['top'])): ?>
              <p><strong class="text-neutral-800">Top Notes:</strong> <?php echo htmlspecialchars(implode(', ', array_column($notes['top'], 'name'))); ?></p>
            <?php endif; ?>
            <?php if (!empty($notes['middle'])): ?>
              <p><strong class="text-neutral-800">Middle Notes:</strong> <?php echo htmlspecialchars(implode(', ', array_column($notes['middle'], 'name'))); ?></p>
            <?php endif; ?>
            <?php if (!empty($notes['base'])): ?>
              <p><strong class="text-neutral-800">Base Notes:</strong> <?php echo htmlspecialchars(implode(', ', array_column($notes['base'], 'name'))); ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- Specifications Checklist -->
      <div class="space-y-2 pt-2">
        <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-800">Quality Specifications:</h4>
        <ul class="space-y-1.5 text-xs text-neutral-600">
          <?php foreach ($product['specs'] as $spec): ?>
            <li class="flex items-start gap-2">
              <span class="text-gold font-bold">✦</span>
              <span><?php echo htmlspecialchars($spec); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Option Selectors -->
      <div class="pt-4 border-t border-neutral-200 space-y-4">
        <?php if (!empty($product['options'])): ?>
          <?php foreach ($product['options'] as $optName => $optVals): ?>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-2"><?php echo htmlspecialchars($optName); ?></label>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($optVals as $i => $val): ?>
                  <span class="px-3 py-1.5 rounded text-xs font-medium border border-neutral-300 bg-white text-neutral-800">
                    <?php echo htmlspecialchars($val); ?>
                  </span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="pt-4 space-y-3">
          <button 
            type="button" 
            class="w-full btn-select-options open-product-modal py-3.5 text-sm"
            data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Configure & Add to Bag</span>
          </button>

          <?php 
          $waDetailMsg = "Hi Panna Heera Perfumery, I am interested in ordering fragrance oil:\nCompound: {$product['title']}\nBase Rate: " . formatPrice($product['price']) . "\nAvailable in 100 GM lots and 1 KG wholesale flacons.\nPlease share delivery timeline and payment details.";
          ?>
          <a 
            href="<?php echo getWhatsAppLink($waDetailMsg); ?>" 
            target="_blank" 
            class="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-3 px-4 rounded-full font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition"
          >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
            <span>Direct WhatsApp Quotation</span>
          </a>
        </div>

        <div class="p-3 bg-neutral-50 rounded-lg text-[11px] text-neutral-500 space-y-1">
          <p>✦ 100% pure alcohol-free fragrance concentrate compound.</p>
          <p>✦ Available in 100 GM lots and 1 KG bulk aluminum flacons.</p>
          <p>✦ Pan-India air & surface dispatch within 24-48 business hours.</p>
        </div>
      </div>
    </div>

  </div>

  <!-- Olfactory Notes Pyramid Section (matching perfume formulation specifications) -->
  <?php if ($hasNotes): ?>
  <div id="olfactory-notes" class="mt-16 pt-12 border-t border-neutral-200 scroll-mt-20">
    <div class="text-center max-w-xl mx-auto mb-10">
      <span class="text-xs font-bold tracking-widest text-gold uppercase">Scent Architecture</span>
      <h2 class="text-2xl sm:text-3xl font-black uppercase text-neutral-900 tracking-tight mt-1">Olfactory Notes Pyramid</h2>
      <p class="text-xs text-neutral-500 mt-1.5">Harmonious progression of delicate aromatic essences from vibrant opening to enduring base.</p>
    </div>

    <div class="max-w-xl mx-auto bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-10 shadow-sm space-y-10">
      
      <!-- TOP NOTES -->
      <?php if (!empty($notes['top'])): ?>
        <div class="text-center">
          <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-neutral-200"></div>
            <span class="flex-shrink mx-4 text-xs font-bold tracking-widest text-[#2c405a] uppercase">TOP NOTES</span>
            <div class="flex-grow border-t border-neutral-200"></div>
          </div>
          <div class="flex flex-wrap items-start justify-center gap-6 sm:gap-8 mt-5">
            <?php foreach ($notes['top'] as $note): ?>
              <div class="flex flex-col items-center text-center w-20 sm:w-24 group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl border border-neutral-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-1.5 flex items-center justify-center transition-transform group-hover:scale-105 duration-200">
                  <img 
                    src="<?php echo htmlspecialchars($note['image']); ?>?v=3.0" 
                    alt="<?php echo htmlspecialchars($note['name']); ?>" 
                    class="max-w-full max-h-full object-contain"
                    onerror="this.onerror=null;this.src='assets/images/notes/amber.png';"
                    loading="lazy"
                  >
                </div>
                <span class="mt-2.5 text-xs font-semibold text-slate-800 leading-tight">
                  <?php echo htmlspecialchars($note['name']); ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- MIDDLE NOTES -->
      <?php if (!empty($notes['middle'])): ?>
        <div class="text-center">
          <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-neutral-200"></div>
            <span class="flex-shrink mx-4 text-xs font-bold tracking-widest text-[#2c405a] uppercase">MIDDLE NOTES</span>
            <div class="flex-grow border-t border-neutral-200"></div>
          </div>
          <div class="flex flex-wrap items-start justify-center gap-6 sm:gap-8 mt-5">
            <?php foreach ($notes['middle'] as $note): ?>
              <div class="flex flex-col items-center text-center w-20 sm:w-24 group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl border border-neutral-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-1.5 flex items-center justify-center transition-transform group-hover:scale-105 duration-200">
                  <img 
                    src="<?php echo htmlspecialchars($note['image']); ?>?v=3.0" 
                    alt="<?php echo htmlspecialchars($note['name']); ?>" 
                    class="max-w-full max-h-full object-contain"
                    onerror="this.onerror=null;this.src='assets/images/notes/amber.png';"
                    loading="lazy"
                  >
                </div>
                <span class="mt-2.5 text-xs font-semibold text-slate-800 leading-tight">
                  <?php echo htmlspecialchars($note['name']); ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- BASE NOTES -->
      <?php if (!empty($notes['base'])): ?>
        <div class="text-center">
          <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-neutral-200"></div>
            <span class="flex-shrink mx-4 text-xs font-bold tracking-widest text-[#2c405a] uppercase">BASE NOTES</span>
            <div class="flex-grow border-t border-neutral-200"></div>
          </div>
          <div class="flex flex-wrap items-start justify-center gap-6 sm:gap-8 mt-5">
            <?php foreach ($notes['base'] as $note): ?>
              <div class="flex flex-col items-center text-center w-20 sm:w-24 group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl border border-neutral-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-1.5 flex items-center justify-center transition-transform group-hover:scale-105 duration-200">
                  <img 
                    src="<?php echo htmlspecialchars($note['image']); ?>?v=3.0" 
                    alt="<?php echo htmlspecialchars($note['name']); ?>" 
                    class="max-w-full max-h-full object-contain"
                    onerror="this.onerror=null;this.src='assets/images/notes/amber.png';"
                    loading="lazy"
                  >
                </div>
                <span class="mt-2.5 text-xs font-semibold text-slate-800 leading-tight">
                  <?php echo htmlspecialchars($note['name']); ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
  <?php endif; ?>

  <!-- Related Products in Category -->
  <div class="mt-20 pt-12 border-t border-neutral-200">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-xl font-bold text-neutral-900">Recommended Pairing & Complementary Products</h2>
      <a href="products.php" class="text-xs font-bold text-neutral-900 hover:text-gold uppercase tracking-wider">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php 
      $related = array_slice($products, 0, 4);
      foreach ($related as $rProd): 
      ?>
        <div class="product-card">
          <div class="product-image-wrap">
            <img src="<?php echo htmlspecialchars($rProd['image']); ?>?v=4.0" alt="<?php echo htmlspecialchars($rProd['title']); ?>" loading="lazy">
          </div>
          <h3 class="product-title"><?php echo htmlspecialchars($rProd['title']); ?></h3>
          <div class="product-meta">
            <span class="product-price"><?php echo formatPrice($rProd['price']); ?></span>
            <span class="product-moq">MOQ: <?php echo htmlspecialchars($rProd['moq_label'] ?? '100 GM'); ?></span>
          </div>
          <a href="product-detail.php?id=<?php echo urlencode($rProd['id']); ?>" class="btn-select-options">
            <span>View Compound & Pricing</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
