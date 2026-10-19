<?php
$pageTitle = 'Product Editor';
include_once __DIR__ . '/includes/header.php';

$productId = isset($_GET['id']) ? trim($_GET['id']) : '';
$isEdit = !empty($productId);

$product = null;
if ($isEdit) {
    foreach ($siteData['products'] ?? [] as $p) {
        if ($p['id'] === $productId) {
            $product = $p;
            break;
        }
    }
    if (!$product) {
        $_SESSION['flash_error'] = 'Product not found.';
        header('Location: products.php');
        exit;
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $shortTitle = isset($_POST['short_title']) ? trim($_POST['short_title']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $moq = isset($_POST['moq']) ? intval($_POST['moq']) : 50;
    $capacity = isset($_POST['capacity']) ? trim($_POST['capacity']) : '';
    $neckSize = isset($_POST['neck_size']) ? trim($_POST['neck_size']) : '';
    $badge = isset($_POST['badge']) ? trim($_POST['badge']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (empty($id)) {
        $id = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
    }

    // Specifications (one per line)
    $specsRaw = isset($_POST['specs']) ? trim($_POST['specs']) : '';
    $specs = array_filter(array_map('trim', explode("\n", $specsRaw)));

    // Dimensions
    $dimensions = [];
    if (!empty($_POST['dim_height'])) $dimensions['height'] = trim($_POST['dim_height']);
    if (!empty($_POST['dim_width'])) $dimensions['width'] = trim($_POST['dim_width']);
    if (!empty($_POST['dim_neck'])) $dimensions['neck'] = trim($_POST['dim_neck']);
    if (!empty($_POST['dim_capacity'])) $dimensions['capacity'] = trim($_POST['dim_capacity']);

    // Find category title
    $categoryTitle = $category;
    foreach ($siteData['categories'] ?? [] as $c) {
        if ($c['id'] === $category) {
            $categoryTitle = $c['title'];
            break;
        }
    }

    // Image Upload
    $uploadedImage = handleImageUpload('product_image_file');
    $existingImage = isset($_POST['existing_image']) ? $_POST['existing_image'] : 'assets/images/products/100ml-victor.jpg';
    $finalImage = $uploadedImage ? $uploadedImage : $existingImage;

    // Build Product Object
    $productData = [
        'id' => $id,
        'title' => $title,
        'short_title' => !empty($shortTitle) ? $shortTitle : $title,
        'category' => $category,
        'category_title' => $categoryTitle,
        'image' => $finalImage,
        'price' => $price,
        'moq' => $moq,
        'capacity' => $capacity,
        'neck_size' => $neckSize,
        'badge' => $badge,
        'in_stock' => true,
        'description' => $description,
        'specs' => array_values($specs),
        'dimensions' => $dimensions,
        'options' => $product['options'] ?? [
            'Finish' => ['Standard Polish', 'Matte Frosted', 'Gold Accent'],
            'Pack Size' => [$moq . ' pcs (Standard)', ($moq * 5) . ' pcs (Wholesale Carton)']
        ]
    ];

    $products = $siteData['products'] ?? [];
    $found = false;
    foreach ($products as $idx => $item) {
        if ($item['id'] === $id) {
            $products[$idx] = $productData;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $products[] = $productData;
    }

    $siteData['products'] = array_values($products);
    saveSiteData($siteData);

    $_SESSION['flash_success'] = 'Product "' . $title . '" saved successfully!';
    header('Location: products.php');
    exit;
}

$specsString = implode("\n", $product['specs'] ?? []);
?>

<div class="mb-6 flex items-center justify-between">
  <div>
    <h1 class="text-xl font-bold text-neutral-900">
      <?php echo $isEdit ? 'Edit Product: ' . htmlspecialchars($product['title']) : 'Add New Packaging Product'; ?>
    </h1>
    <p class="text-xs text-neutral-500 mt-0.5">Fill out specifications, pricing, blueprints, and image details for this catalog item.</p>
  </div>
  <a href="products.php" class="text-xs font-semibold text-neutral-600 hover:text-neutral-900 border border-neutral-300 px-3 py-1.5 rounded-lg transition">
    &larr; Back to Products
  </a>
</div>

<form method="POST" action="product-form.php<?php echo $isEdit ? '?id=' . urlencode($productId) : ''; ?>" enctype="multipart/form-data" class="space-y-6">
  <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product['image'] ?? ''); ?>">

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Left Column: Core Info & Details (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
      
      <!-- Card 1: Basic Information -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 border-b border-neutral-100 pb-3">Product Identification</h3>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Full Product Title *</label>
          <input 
            type="text" 
            name="title" 
            required 
            placeholder="e.g. 100 ML VICTOR PERFUME GLASS BOTTLE" 
            value="<?php echo htmlspecialchars($product['title'] ?? ''); ?>" 
            class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
          >
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Short Title (for badges / cart)</label>
            <input 
              type="text" 
              name="short_title" 
              placeholder="e.g. 100 ML Victor Glass Bottle" 
              value="<?php echo htmlspecialchars($product['short_title'] ?? ''); ?>" 
              class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">URL Identifier (Slug ID)</label>
            <input 
              type="text" 
              name="id" 
              placeholder="e.g. 100ml-victor" 
              value="<?php echo htmlspecialchars($product['id'] ?? ''); ?>" 
              <?php echo $isEdit ? 'readonly class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-200 bg-neutral-100 text-neutral-500 font-mono"' : 'class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-mono"'; ?>
            >
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Category *</label>
            <select name="category" required class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white">
              <?php foreach ($siteData['categories'] ?? [] as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo (isset($product['category']) && $product['category'] === $cat['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($cat['title']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Base Price (₹) *</label>
            <input 
              type="number" 
              step="0.01" 
              name="price" 
              required 
              placeholder="85.00" 
              value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" 
              class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
            >
          </div>

          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Min. Order Qty (MOQ) *</label>
            <input 
              type="number" 
              name="moq" 
              required 
              placeholder="50" 
              value="<?php echo htmlspecialchars($product['moq'] ?? '50'); ?>" 
              class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Product Description</label>
          <textarea 
            name="description" 
            rows="3" 
            placeholder="Detailed description of the bottle material, clarity, and usage..." 
            class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          ><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        </div>
      </div>

      <!-- Card 2: Technical Specifications & Dimensions -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 border-b border-neutral-100 pb-3">Technical Blueprints & Tolerances</h3>
        <p class="text-xs text-neutral-400">Specify millimetric dimensions displayed in the technical blueprint box.</p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div>
            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-600 mb-1">Height</label>
            <input 
              type="text" 
              name="dim_height" 
              placeholder="92.3 ± 1 mm" 
              value="<?php echo htmlspecialchars($product['dimensions']['height'] ?? ''); ?>" 
              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
          <div>
            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-600 mb-1">Width / Diam.</label>
            <input 
              type="text" 
              name="dim_width" 
              placeholder="67 ± 1.2 mm" 
              value="<?php echo htmlspecialchars($product['dimensions']['width'] ?? $product['dimensions']['diameter'] ?? ''); ?>" 
              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
          <div>
            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-600 mb-1">Neck Size</label>
            <input 
              type="text" 
              name="dim_neck" 
              placeholder="15 mm Crimp" 
              value="<?php echo htmlspecialchars($product['dimensions']['neck'] ?? $product['neck_size'] ?? ''); ?>" 
              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
          <div>
            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-600 mb-1">Volume</label>
            <input 
              type="text" 
              name="dim_capacity" 
              placeholder="100 ML" 
              value="<?php echo htmlspecialchars($product['dimensions']['capacity'] ?? $product['capacity'] ?? ''); ?>" 
              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Quality Specifications (One per line)</label>
          <textarea 
            name="specs" 
            rows="4" 
            placeholder="High-clarity super flint glass with zero optical distortion&#10;Substantial weighted base for premium in-hand feel" 
            class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          ><?php echo htmlspecialchars($specsString); ?></textarea>
        </div>
      </div>

    </div>

    <!-- Right Column: Media, Badge & Publish (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
      
      <!-- Card 3: Image Upload & Preview -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 border-b border-neutral-100 pb-3">Product Photo</h3>

        <div class="w-full aspect-square bg-neutral-50 rounded-xl border border-neutral-200 p-3 flex items-center justify-center overflow-hidden">
          <img 
            id="productImgPreview" 
            src="../<?php echo htmlspecialchars($product['image'] ?? 'assets/images/products/100ml-victor.jpg'); ?>" 
            alt="Preview" 
            class="max-w-full max-h-full object-contain"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Upload New Photo</label>
          <input 
            type="file" 
            name="product_image_file" 
            accept="image/*" 
            onchange="previewImg(event)" 
            class="block w-full text-xs text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
          >
        </div>
      </div>

      <!-- Card 4: Badge & Capacity -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 border-b border-neutral-100 pb-3">Highlights & Tags</h3>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Card Badge</label>
          <input 
            type="text" 
            name="badge" 
            placeholder="e.g. Best Seller, Refillable, Technical Blueprint" 
            value="<?php echo htmlspecialchars($product['badge'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Capacity Display Tag</label>
          <input 
            type="text" 
            name="capacity" 
            placeholder="e.g. 100 ML, 50 ML, 20 ML" 
            value="<?php echo htmlspecialchars($product['capacity'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Neck Specification Tag</label>
          <input 
            type="text" 
            name="neck_size" 
            placeholder="e.g. FEA 15 mm Crimp, 18/415 Screw" 
            value="<?php echo htmlspecialchars($product['neck_size'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>
      </div>

      <!-- Card 5: Action Submit Button -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-3">
        <button 
          type="submit" 
          class="w-full bg-black hover:bg-neutral-800 text-white py-3.5 rounded-full text-xs font-bold tracking-wider uppercase transition shadow-md flex items-center justify-center gap-2"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
          <span><?php echo $isEdit ? 'Save Changes' : 'Publish Product'; ?></span>
        </button>

        <a href="products.php" class="block text-center text-xs text-neutral-500 hover:text-neutral-800 py-1">
          Cancel & Return
        </a>
      </div>

    </div>

  </div>
</form>

<script>
function previewImg(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(evt) {
      document.getElementById('productImgPreview').src = evt.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
