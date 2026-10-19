<?php
$pageTitle = 'Manage Products';
include_once __DIR__ . '/includes/header.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$deleteId = isset($_GET['id']) ? trim($_GET['id']) : '';

// Handle Delete Action
if ($action === 'delete' && !empty($deleteId)) {
    $products = $siteData['products'] ?? [];
    $filtered = array_filter($products, function($p) use ($deleteId) {
        return $p['id'] !== $deleteId;
    });
    $siteData['products'] = array_values($filtered);
    saveSiteData($siteData);
    $_SESSION['flash_success'] = 'Product deleted successfully from catalog!';
    header('Location: products.php');
    exit;
}

$products = $siteData['products'] ?? [];
$categories = $siteData['categories'] ?? [];
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-xl font-bold text-neutral-900">Product Catalog Management</h1>
    <p class="text-xs text-neutral-500 mt-0.5">Manage all perfume bottles, caps, sprayers, pricing, technical blueprints, and variant options.</p>
  </div>
  <a href="product-form.php" class="bg-black hover:bg-neutral-800 text-white text-xs font-bold px-4 py-2.5 rounded-full inline-flex items-center gap-2 transition shadow-sm">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
    <span>Add New Product</span>
  </a>
</div>

<!-- Products Table Container -->
<div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
  
  <div class="p-5 border-b border-neutral-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-2">
      <span class="font-bold text-sm text-neutral-900">All Products</span>
      <span class="bg-neutral-100 text-neutral-600 text-xs px-2 py-0.5 rounded-full font-semibold"><?php echo count($products); ?> items</span>
    </div>

    <!-- Live Filter Input -->
    <div class="relative max-w-xs w-full">
      <input 
        type="text" 
        id="adminProductFilter" 
        placeholder="Filter products..." 
        class="w-full text-xs px-3 py-2 pl-8 rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
      >
      <svg class="w-3.5 h-3.5 text-neutral-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-left text-xs" id="adminProductsTable">
      <thead class="bg-neutral-50 border-b border-neutral-200 text-neutral-500 uppercase tracking-wider">
        <tr>
          <th class="py-3 px-4">Item</th>
          <th class="py-3 px-4">Category</th>
          <th class="py-3 px-4">Base Price</th>
          <th class="py-3 px-4">MOQ</th>
          <th class="py-3 px-4">Badge</th>
          <th class="py-3 px-4">Stock</th>
          <th class="py-3 px-4 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-100">
        <?php foreach ($products as $p): ?>
          <tr class="hover:bg-neutral-50 transition product-row">
            <td class="py-3 px-4">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded border border-neutral-200 p-1 overflow-hidden flex-shrink-0 flex items-center justify-center">
                  <img src="../<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="max-w-full max-h-full object-contain">
                </div>
                <div>
                  <strong class="text-neutral-900 text-xs block truncate max-w-sm" title="<?php echo htmlspecialchars($p['title']); ?>">
                    <?php echo htmlspecialchars($p['title']); ?>
                  </strong>
                  <div class="flex items-center gap-2 text-[11px] text-neutral-400 mt-0.5">
                    <span>ID: <code class="font-mono"><?php echo htmlspecialchars($p['id']); ?></code></span>
                    <?php if (!empty($p['neck_size'])): ?>
                      <span>•</span>
                      <span>Neck: <?php echo htmlspecialchars($p['neck_size']); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </td>

            <td class="py-3 px-4">
              <span class="bg-neutral-100 text-neutral-700 px-2.5 py-1 rounded text-[11px] font-semibold">
                <?php echo htmlspecialchars($p['category_title'] ?? $p['category']); ?>
              </span>
            </td>

            <td class="py-3 px-4 font-bold text-neutral-900 text-sm">
              ₹ <?php echo number_format($p['price'], 2); ?>
            </td>

            <td class="py-3 px-4 text-neutral-600 font-semibold">
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

            <td class="py-3 px-4">
              <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px] font-bold">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                In Stock
              </span>
            </td>

            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
              <a href="product-form.php?id=<?php echo urlencode($p['id']); ?>" class="text-blue-600 hover:text-blue-800 font-bold">Edit</a>
              <a href="../product-detail.php?id=<?php echo urlencode($p['id']); ?>" target="_blank" class="text-neutral-500 hover:text-neutral-800">Preview</a>
              <a href="products.php?action=delete&id=<?php echo urlencode($p['id']); ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="text-red-600 hover:text-red-800 font-bold">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Table Live Filter Script -->
<script>
document.getElementById('adminProductFilter')?.addEventListener('input', function(e) {
  const q = e.target.value.toLowerCase().trim();
  const rows = document.querySelectorAll('.product-row');
  rows.forEach(r => {
    const text = r.textContent.toLowerCase();
    if (!q || text.includes(q)) {
      r.style.display = '';
    } else {
      r.style.display = 'none';
    }
  });
});
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
