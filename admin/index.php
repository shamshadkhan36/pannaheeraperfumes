<?php
$pageTitle = 'Dashboard';
include_once __DIR__ . '/includes/header.php';

$productsCount = count($siteData['products'] ?? []);
$categoriesCount = count($siteData['categories'] ?? []);
$bannerHeadline = $siteData['banner']['headline'] ?? 'Default Banner';
$marqueeCount = count($siteData['banner']['marquee_items'] ?? []);
?>

<!-- Welcome Banner -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm">
  <div>
    <h1 class="text-xl sm:text-2xl font-black text-neutral-900">Welcome to Panna Heera Control Panel</h1>
    <p class="text-xs text-neutral-500 mt-1">Manage your luxury perfume bottles, caps, categories, hero banner, and inquiries in real-time.</p>
  </div>
  <div class="flex items-center gap-3">
    <a href="product-form.php" class="bg-black hover:bg-neutral-800 text-white text-xs font-bold px-4 py-2.5 rounded-full inline-flex items-center gap-2 transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
      Add Product
    </a>
    <a href="categories.php" class="bg-gold hover:bg-[#b08b42] text-white text-xs font-bold px-4 py-2.5 rounded-full inline-flex items-center gap-2 transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
      Add Category
    </a>
  </div>
</div>

<!-- Hero Banner Status Card -->
<?php 
$currentImage = !empty($siteData['banner']['image']) ? $siteData['banner']['image'] : (!empty($siteData['banner']['background_image']) ? $siteData['banner']['background_image'] : 'assets/images/hero-perfume-bg.jpg');
$bannerDisplayStyle = $siteData['banner']['display_style'] ?? 'image_only';
?>
<div class="mb-8 p-4 rounded-2xl border bg-white border-neutral-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div class="flex items-center gap-3">
    <img src="../<?php echo htmlspecialchars($currentImage); ?>" class="w-14 h-10 object-cover rounded-lg border border-neutral-200 flex-shrink-0 shadow-sm">
    <div>
      <div class="flex items-center gap-2">
        <span class="text-xs font-bold text-neutral-900">Hero Banner</span>
        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
          <?php echo $bannerDisplayStyle === 'image_only' ? 'Simple Banner Image' : 'Banner With Text'; ?>
        </span>
      </div>
      <p class="text-xs text-neutral-500 mt-0.5">
        Currently displaying: <span class="font-mono text-neutral-800 font-semibold"><?php echo htmlspecialchars(basename($currentImage)); ?></span>. You can change this image and its click link anytime.
      </p>
    </div>
  </div>
  <div class="flex items-center gap-2 flex-shrink-0">
    <a href="banner.php" class="bg-neutral-900 hover:bg-black text-white text-xs font-bold px-4 py-2.5 rounded-full transition shadow-sm inline-flex items-center gap-1.5">
      <span>Edit Hero Banner</span>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
    </a>
  </div>
</div>

<!-- KPI Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
  
  <!-- Stat 1: Total Products -->
  <div class="bg-white p-5 rounded-2xl border border-neutral-200 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider block mb-1">Catalog Products</span>
      <span class="text-3xl font-extrabold text-neutral-900"><?php echo $productsCount; ?></span>
      <a href="products.php" class="text-xs text-gold font-bold hover:underline block mt-1">Manage catalog &rarr;</a>
    </div>
    <div class="w-12 h-12 rounded-xl bg-amber-50 text-gold flex items-center justify-center text-xl font-bold">
      🧴
    </div>
  </div>

  <!-- Stat 2: Categories -->
  <div class="bg-white p-5 rounded-2xl border border-neutral-200 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider block mb-1">Active Categories</span>
      <span class="text-3xl font-extrabold text-neutral-900"><?php echo $categoriesCount; ?></span>
      <a href="categories.php" class="text-xs text-gold font-bold hover:underline block mt-1">Manage categories &rarr;</a>
    </div>
    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
      🗂️
    </div>
  </div>

  <!-- Stat 3: Hero Banner -->
  <div class="bg-white p-5 rounded-2xl border border-neutral-200 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider block mb-1">Hero Banner</span>
      <span class="text-sm font-bold text-neutral-900 block truncate max-w-[150px]"><?php echo htmlspecialchars(basename($currentImage)); ?></span>
      <a href="banner.php" class="text-xs text-gold font-bold hover:underline block mt-1">Change image &rarr;</a>
    </div>
    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
      🖼️
    </div>
  </div>

  <!-- Stat 4: Marquee Points -->
  <div class="bg-white p-5 rounded-2xl border border-neutral-200 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider block mb-1">Marquee Ticker</span>
      <span class="text-3xl font-extrabold text-neutral-900"><?php echo $marqueeCount; ?> <span class="text-xs font-normal text-neutral-400">points</span></span>
      <a href="banner.php" class="text-xs text-gold font-bold hover:underline block mt-1">Edit ticker &rarr;</a>
    </div>
    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
      ✦
    </div>
  </div>

</div>

<!-- Recent Products Section -->
<div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden mb-8">
  <div class="p-5 border-b border-neutral-200 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-sm text-neutral-900">Recent Products in Catalog</h3>
      <p class="text-xs text-neutral-400 mt-0.5">Showing latest packaging products available on the website.</p>
    </div>
    <a href="products.php" class="text-xs font-bold text-neutral-900 hover:text-gold uppercase tracking-wider">
      View All Products (<?php echo $productsCount; ?>) &rarr;
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-left text-xs">
      <thead class="bg-neutral-50 border-b border-neutral-200 text-neutral-500 uppercase tracking-wider">
        <tr>
          <th class="py-3 px-4">Item</th>
          <th class="py-3 px-4">Category</th>
          <th class="py-3 px-4">Price</th>
          <th class="py-3 px-4">MOQ</th>
          <th class="py-3 px-4">Badge</th>
          <th class="py-3 px-4 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-100">
        <?php 
        $previewProducts = array_slice($siteData['products'] ?? [], 0, 5);
        foreach ($previewProducts as $p): 
        ?>
          <tr class="hover:bg-neutral-50 transition">
            <td class="py-3 px-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded border border-neutral-200 p-0.5 overflow-hidden flex-shrink-0 flex items-center justify-center">
                  <img src="../<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="max-w-full max-h-full object-contain">
                </div>
                <div>
                  <span class="font-bold text-neutral-900 block truncate max-w-xs"><?php echo htmlspecialchars($p['title']); ?></span>
                  <span class="text-[11px] text-neutral-400"><?php echo htmlspecialchars($p['capacity'] ?? ''); ?></span>
                </div>
              </div>
            </td>
            <td class="py-3 px-4">
              <span class="bg-neutral-100 text-neutral-700 px-2 py-0.5 rounded text-[11px] font-medium">
                <?php echo htmlspecialchars($p['category_title'] ?? $p['category']); ?>
              </span>
            </td>
            <td class="py-3 px-4 font-bold text-neutral-900">
              ₹ <?php echo number_format($p['price'], 2); ?>
            </td>
            <td class="py-3 px-4 text-neutral-600">
              <?php echo $p['moq']; ?> pcs
            </td>
            <td class="py-3 px-4">
              <?php if (!empty($p['badge'])): ?>
                <span class="bg-neutral-900 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                  <?php echo htmlspecialchars($p['badge']); ?>
                </span>
              <?php else: ?>
                <span class="text-neutral-400">—</span>
              <?php endif; ?>
            </td>
            <td class="py-3 px-4 text-right space-x-2">
              <a href="product-form.php?id=<?php echo urlencode($p['id']); ?>" class="text-blue-600 hover:underline font-semibold">Edit</a>
              <a href="../product-detail.php?id=<?php echo urlencode($p['id']); ?>" target="_blank" class="text-neutral-500 hover:text-neutral-800">Preview</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Categories Overview -->
<div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h3 class="font-bold text-sm text-neutral-900">Categories Breakdown</h3>
      <p class="text-xs text-neutral-400 mt-0.5">All active catalog sections displayed on the homepage.</p>
    </div>
    <a href="categories.php" class="text-xs font-bold text-gold hover:underline">
      Manage Categories &rarr;
    </a>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    <?php foreach ($siteData['categories'] ?? [] as $cat): ?>
      <div class="p-3 bg-neutral-50 rounded-xl border border-neutral-200 text-center">
        <div class="w-14 h-14 bg-white rounded-lg border border-neutral-200 mx-auto mb-2 overflow-hidden flex items-center justify-center p-1">
          <img src="../<?php echo htmlspecialchars($cat['image']); ?>" alt="<?php echo htmlspecialchars($cat['title']); ?>" class="max-w-full max-h-full object-cover">
        </div>
        <h4 class="font-bold text-xs text-neutral-900 line-clamp-1"><?php echo htmlspecialchars($cat['title']); ?></h4>
        <span class="text-[11px] text-neutral-400"><?php echo $cat['count'] ?? 0; ?> items</span>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
