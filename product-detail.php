<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$productId = isset($_GET['id']) ? trim($_GET['id']) : '100ml-victor';
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
          src="<?php echo htmlspecialchars($product['image']); ?>" 
          alt="<?php echo htmlspecialchars($product['title']); ?>" 
          class="max-w-full max-h-full object-contain"
        >
      </div>

      <!-- Technical Dimensions Grid (if present) -->
      <?php if (!empty($product['dimensions'])): ?>
        <div class="bg-neutral-50 rounded-2xl border border-neutral-200 p-6">
          <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
            <h3 class="font-bold text-xs uppercase tracking-widest text-neutral-800">Engineered Technical Tolerances</h3>
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
          <span class="text-xs text-neutral-500 block">Wholesale Base Price</span>
          <span class="text-2xl sm:text-3xl font-extrabold text-neutral-900"><?php echo formatPrice($product['price']); ?></span>
          <span class="text-xs text-neutral-500 font-normal">/ piece</span>
        </div>
        <div class="h-8 w-px bg-neutral-200"></div>
        <div>
          <span class="text-xs text-neutral-500 block">Minimum Order</span>
          <span class="text-sm font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded border border-amber-200 inline-block mt-0.5">
            <?php echo $product['moq']; ?> pieces MOQ
          </span>
        </div>
      </div>

      <p class="text-xs text-neutral-600 leading-relaxed">
        <?php echo htmlspecialchars($product['description']); ?>
      </p>

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
          $waDetailMsg = "Hi Panna Heera Perfumery, I am interested in inquiring for:\nProduct: {$product['title']}\nBase Price: " . formatPrice($product['price']) . "\nMOQ: {$product['moq']} pcs\nPlease share formal quotation and stock status.";
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
          <p>✦ Custom silk screen printing & hot stamping available from 500 pcs.</p>
          <p>✦ Standard lead time: 3-5 business days for in-stock dispatches.</p>
        </div>
      </div>
    </div>

  </div>

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
            <img src="<?php echo htmlspecialchars($rProd['image']); ?>" alt="<?php echo htmlspecialchars($rProd['title']); ?>" loading="lazy">
          </div>
          <h3 class="product-title"><?php echo htmlspecialchars($rProd['title']); ?></h3>
          <div class="product-meta">
            <span class="product-price"><?php echo formatPrice($rProd['price']); ?></span>
            <span class="product-moq">MOQ: <?php echo $rProd['moq']; ?> pcs</span>
          </div>
          <a href="product-detail.php?id=<?php echo urlencode($rProd['id']); ?>" class="btn-select-options">
            <span>View Specifications</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
