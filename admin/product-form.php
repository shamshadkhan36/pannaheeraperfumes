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
    $existingImage = isset($_POST['existing_image']) ? $_POST['existing_image'] : 'assets/images/categories/fragrance-oils.jpg';
    $finalImage = $uploadedImage ? $uploadedImage : $existingImage;

    // Fragrance Notes (Top, Middle, Base)
    $notes = [
        'top' => [],
        'middle' => [],
        'base' => []
    ];
    if (isset($_POST['notes_json'])) {
        $decoded = json_decode($_POST['notes_json'], true);
        if (is_array($decoded)) {
            foreach (['top', 'middle', 'base'] as $tier) {
                if (!empty($decoded[$tier]) && is_array($decoded[$tier])) {
                    foreach ($decoded[$tier] as $n) {
                        if (!empty($n['name'])) {
                            $notes[$tier][] = [
                                'name' => trim($n['name']),
                                'image' => !empty($n['image']) ? trim($n['image']) : 'assets/images/notes/patchouli.png'
                            ];
                        }
                    }
                }
            }
        }
    } elseif (isset($product['notes'])) {
        $notes = $product['notes'];
    }

    // Build Product Object (preserving extra existing fields)
    $baseProduct = $product ?? [];
    $productData = array_merge($baseProduct, [
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
        'notes' => $notes,
        'options' => $product['options'] ?? [
            'Finish' => ['Standard Polish', 'Matte Frosted', 'Gold Accent'],
            'Pack Size' => [$moq . ' pcs (Standard)', ($moq * 5) . ' pcs (Wholesale Carton)']
        ]
    ]);

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
$notesLibrary = loadNotesLibrary();
$currentNotes = $product['notes'] ?? ['top' => [], 'middle' => [], 'base' => []];
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
            placeholder="e.g. TOM FORD - TOBACCO VANILLE" 
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
              placeholder="e.g. Tobacco Vanille" 
              value="<?php echo htmlspecialchars($product['short_title'] ?? ''); ?>" 
              class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
            >
          </div>
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">URL Identifier (Slug ID)</label>
            <input 
              type="text" 
              name="id" 
              placeholder="e.g. oil-1050" 
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

      <!-- Card 2: Fragrance Olfactory Notes & Pyramid (Top, Middle, Base) -->
      <div id="notes-section" class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-6 scroll-mt-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-neutral-100 pb-3">
          <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 flex items-center gap-2">
              <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
              <span>Fragrance Notes Pyramid (Top, Middle, Base)</span>
            </h3>
            <p class="text-xs text-neutral-400 mt-0.5">Attach aromatic notes with icons matching the olfactory pyramid (Raspberry, Rose, Patchouli, etc.)</p>
          </div>
          <a href="notes.php" target="_blank" class="text-[11px] font-semibold text-gold hover:underline flex items-center gap-1 self-start sm:self-auto">
            <span>Manage Notes Library &rarr;</span>
          </a>
        </div>

        <!-- Hidden input storing notes as JSON -->
        <input type="hidden" name="notes_json" id="notesJsonInput">

        <!-- Tier 1: TOP NOTES -->
        <div class="p-4 rounded-xl border border-neutral-200/90 bg-neutral-50/50 space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
              <span class="text-xs font-bold uppercase tracking-wider text-neutral-800">Top Notes</span>
              <span class="text-[11px] text-neutral-400 font-normal hidden sm:inline">(Initial impression & burst)</span>
            </div>
            <button 
              type="button" 
              onclick="openAddNoteModal('top')" 
              class="text-xs font-bold text-neutral-900 hover:text-gold border border-neutral-300 hover:border-gold bg-white px-3 py-1 rounded-full transition flex items-center gap-1.5 shadow-sm"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
              <span>Add Top Note</span>
            </button>
          </div>
          <div id="topNotesContainer" class="flex flex-wrap items-center gap-2.5 min-h-[52px] p-2 bg-white rounded-lg border border-neutral-200/60">
            <!-- Rendered by JS -->
          </div>
        </div>

        <!-- Tier 2: MIDDLE NOTES -->
        <div class="p-4 rounded-xl border border-neutral-200/90 bg-neutral-50/50 space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
              <span class="text-xs font-bold uppercase tracking-wider text-neutral-800">Middle Notes (Heart)</span>
              <span class="text-[11px] text-neutral-400 font-normal hidden sm:inline">(Core personality & character)</span>
            </div>
            <button 
              type="button" 
              onclick="openAddNoteModal('middle')" 
              class="text-xs font-bold text-neutral-900 hover:text-gold border border-neutral-300 hover:border-gold bg-white px-3 py-1 rounded-full transition flex items-center gap-1.5 shadow-sm"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
              <span>Add Middle Note</span>
            </button>
          </div>
          <div id="middleNotesContainer" class="flex flex-wrap items-center gap-2.5 min-h-[52px] p-2 bg-white rounded-lg border border-neutral-200/60">
            <!-- Rendered by JS -->
          </div>
        </div>

        <!-- Tier 3: BASE NOTES -->
        <div class="p-4 rounded-xl border border-neutral-200/90 bg-neutral-50/50 space-y-3">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-amber-600"></span>
              <span class="text-xs font-bold uppercase tracking-wider text-neutral-800">Base Notes (Drydown)</span>
              <span class="text-[11px] text-neutral-400 font-normal hidden sm:inline">(Foundation & longest longevity)</span>
            </div>
            <button 
              type="button" 
              onclick="openAddNoteModal('base')" 
              class="text-xs font-bold text-neutral-900 hover:text-gold border border-neutral-300 hover:border-gold bg-white px-3 py-1 rounded-full transition flex items-center gap-1.5 shadow-sm"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
              <span>Add Base Note</span>
            </button>
          </div>
          <div id="baseNotesContainer" class="flex flex-wrap items-center gap-2.5 min-h-[52px] p-2 bg-white rounded-lg border border-neutral-200/60">
            <!-- Rendered by JS -->
          </div>
        </div>

        <!-- Live Visual Pyramid Preview -->
        <div class="border border-neutral-200 rounded-xl p-4 bg-neutral-50">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-neutral-700 flex items-center gap-1.5">
              <span>👁 Live Olfactory Pyramid Preview</span>
            </span>
            <span class="text-[10px] text-neutral-400">Updates live matching the customer storefront</span>
          </div>

          <div id="pyramidLivePreview" class="bg-white rounded-xl border border-neutral-200 p-5 space-y-6">
            <!-- Live Preview content matching user's image -->
          </div>
        </div>
      </div>

      <!-- Card 3: Technical Specifications & Dimensions -->
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
            src="../<?php echo htmlspecialchars($product['image'] ?? 'assets/images/categories/fragrance-oils.jpg'); ?>" 
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

<!-- Modal: Add Fragrance Note -->
<div id="addNoteModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative max-h-[90vh] flex flex-col">
    <button type="button" onclick="closeAddNoteModal()" class="absolute top-4 right-4 text-neutral-400 hover:text-neutral-800">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    <h3 class="text-base font-bold text-neutral-900 mb-0.5">Add Note to Olfactory Pyramid</h3>
    <p class="text-xs text-neutral-500 mb-4">Pick an essence from the Olfactory Library or upload custom picture.</p>

    <div class="space-y-4 flex-1 overflow-y-auto pr-1">
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Pyramid Tier</label>
        <select id="modalNoteTier" class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white font-medium">
          <option value="top">Top Note (Opening / Burst)</option>
          <option value="middle">Middle Note (Heart / Core)</option>
          <option value="base">Base Note (Dry Down / Anchor)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Note Name *</label>
        <input 
          type="text" 
          id="modalNoteNameInput" 
          placeholder="e.g. Raspberry, Rose, Patchouli" 
          class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
        >
      </div>

      <!-- Image Source Selection -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Note Icon / Picture</label>
        
        <div class="flex border-b border-neutral-200 text-xs mb-3">
          <button type="button" onclick="switchNoteTab('library')" id="tabBtnLibrary" class="py-1.5 px-3 font-bold border-b-2 border-neutral-900 text-neutral-900 transition">
            Olfactory Library
          </button>
          <button type="button" onclick="switchNoteTab('upload')" id="tabBtnUpload" class="py-1.5 px-3 font-medium text-neutral-500 hover:text-neutral-900 transition">
            Upload Custom Photo
          </button>
          <button type="button" onclick="switchNoteTab('url')" id="tabBtnUrl" class="py-1.5 px-3 font-medium text-neutral-500 hover:text-neutral-900 transition">
            Image URL
          </button>
        </div>

        <!-- Selected preview chip -->
        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-neutral-50 border border-neutral-200 mb-3">
          <div class="w-12 h-12 rounded-lg bg-white border border-neutral-200 p-1 flex items-center justify-center flex-shrink-0">
            <img id="selectedNoteImgPreview" src="../assets/images/notes/patchouli.png" class="max-w-full max-h-full object-contain">
          </div>
          <div class="text-xs flex-1 min-w-0">
            <span class="text-neutral-400 block text-[10px]">Active Icon Path:</span>
            <span id="selectedNoteImgPath" class="font-mono text-neutral-700 truncate block text-[11px]">assets/images/notes/patchouli.png</span>
          </div>
        </div>

        <!-- Tab 1: Library Grid -->
        <div id="tabContentLibrary" class="space-y-2">
          <input 
            type="text" 
            id="filterLibraryInput" 
            placeholder="Search note library (raspberry, rose, patchouli, amber...)..." 
            oninput="filterLibraryNotes()" 
            class="w-full px-3 py-1.5 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:border-neutral-900"
          >
          <div id="libraryGrid" class="grid grid-cols-4 sm:grid-cols-5 gap-2 max-h-48 overflow-y-auto p-1.5 border border-neutral-200 rounded-xl bg-neutral-50/50">
            <!-- Populated by JS -->
          </div>
        </div>

        <!-- Tab 2: Upload Custom -->
        <div id="tabContentUpload" class="hidden space-y-2">
          <input 
            type="file" 
            id="customNoteFileInput" 
            accept="image/*" 
            onchange="handleCustomNoteUpload(event)"
            class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
          >
          <p id="uploadStatusText" class="text-[11px] text-neutral-400">Square JPG, PNG, or WEBP. Uploads directly into assets/images/notes/.</p>
        </div>

        <!-- Tab 3: URL -->
        <div id="tabContentUrl" class="hidden space-y-2">
          <input 
            type="text" 
            id="customNoteUrlInput" 
            placeholder="e.g. assets/images/notes/rose.png or https://..." 
            oninput="handleCustomUrlChange(this.value)"
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>
      </div>
    </div>

    <div class="pt-4 border-t border-neutral-100 flex gap-2">
      <button 
        type="button" 
        onclick="confirmAddNote()" 
        class="flex-1 bg-black hover:bg-neutral-800 text-white py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition shadow-sm"
      >
        Add Note to Pyramid
      </button>
      <button 
        type="button" 
        onclick="closeAddNoteModal()" 
        class="px-4 py-2.5 rounded-full text-xs font-semibold text-neutral-600 hover:bg-neutral-100 transition"
      >
        Cancel
      </button>
    </div>
  </div>
</div>

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

// Fragrance Notes Management
const NOTES_LIBRARY = <?php echo json_encode($notesLibrary, JSON_UNESCAPED_SLASHES); ?>;
let productNotes = <?php echo json_encode($currentNotes, JSON_UNESCAPED_SLASHES); ?>;

if (!productNotes.top) productNotes.top = [];
if (!productNotes.middle) productNotes.middle = [];
if (!productNotes.base) productNotes.base = [];

let currentSelectedImage = 'assets/images/notes/patchouli.png';
let currentActiveTab = 'library';

function renderNotes() {
  const tiers = ['top', 'middle', 'base'];
  
  tiers.forEach(tier => {
    const container = document.getElementById(tier + 'NotesContainer');
    if (!container) return;
    
    container.innerHTML = '';
    const notes = productNotes[tier] || [];

    if (notes.length === 0) {
      container.innerHTML = `<span class="text-xs text-neutral-400 italic py-1 px-2">No ${tier} notes added yet. Click "+ Add ${tier.charAt(0).toUpperCase() + tier.slice(1)} Note" above.</span>`;
    } else {
      notes.forEach((n, idx) => {
        const chip = document.createElement('div');
        chip.className = 'group flex items-center gap-2 bg-neutral-100 hover:bg-neutral-200/80 border border-neutral-200/80 pl-1.5 pr-2.5 py-1 rounded-xl transition';
        chip.innerHTML = `
          <div class="w-8 h-8 rounded-lg bg-white border border-neutral-200/80 p-0.5 flex items-center justify-center overflow-hidden flex-shrink-0">
            <img src="../${n.image || 'assets/images/notes/patchouli.png'}" alt="${n.name}" class="max-w-full max-h-full object-contain">
          </div>
          <span class="text-xs font-bold text-neutral-800">${escapeHtml(n.name)}</span>
          <button type="button" onclick="removeNote('${tier}', ${idx})" class="text-neutral-400 hover:text-red-600 ml-1 p-0.5 rounded transition" title="Remove note">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        `;
        container.appendChild(chip);
      });
    }
  });

  // Sync to hidden input
  document.getElementById('notesJsonInput').value = JSON.stringify(productNotes);

  // Render Live Preview
  renderPyramidPreview();
}

function renderPyramidPreview() {
  const preview = document.getElementById('pyramidLivePreview');
  if (!preview) return;

  const hasAnyNotes = (productNotes.top && productNotes.top.length > 0) ||
                      (productNotes.middle && productNotes.middle.length > 0) ||
                      (productNotes.base && productNotes.base.length > 0);

  if (!hasAnyNotes) {
    preview.innerHTML = `
      <div class="py-8 text-center text-neutral-400 text-xs">
        <svg class="w-8 h-8 mx-auto mb-2 text-neutral-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
        <span>No olfactory notes assigned yet. Add notes above to see the live fragrance pyramid preview here.</span>
      </div>
    `;
    return;
  }

  let html = '<div class="olfactory-pyramid max-w-md mx-auto space-y-6">';

  // Top Notes
  if (productNotes.top && productNotes.top.length > 0) {
    html += `
      <div class="text-center">
        <div class="relative flex py-2 items-center">
          <div class="flex-grow border-t border-neutral-200"></div>
          <span class="flex-shrink mx-4 text-[11px] font-bold tracking-widest text-[#2c405a] uppercase">TOP NOTES</span>
          <div class="flex-grow border-t border-neutral-200"></div>
        </div>
        <div class="flex flex-wrap items-start justify-center gap-4 mt-3">
          ${productNotes.top.map(n => `
            <div class="flex flex-col items-center text-center w-16 group">
              <div class="w-14 h-14 bg-white rounded-xl border border-neutral-200 shadow-sm p-1 flex items-center justify-center">
                <img src="../${n.image || 'assets/images/notes/patchouli.png'}" alt="${escapeHtml(n.name)}" class="max-w-full max-h-full object-contain">
              </div>
              <span class="mt-1.5 text-[11px] font-semibold text-slate-800 leading-tight">${escapeHtml(n.name)}</span>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  // Middle Notes
  if (productNotes.middle && productNotes.middle.length > 0) {
    html += `
      <div class="text-center">
        <div class="relative flex py-2 items-center">
          <div class="flex-grow border-t border-neutral-200"></div>
          <span class="flex-shrink mx-4 text-[11px] font-bold tracking-widest text-[#2c405a] uppercase">MIDDLE NOTES</span>
          <div class="flex-grow border-t border-neutral-200"></div>
        </div>
        <div class="flex flex-wrap items-start justify-center gap-4 mt-3">
          ${productNotes.middle.map(n => `
            <div class="flex flex-col items-center text-center w-16 group">
              <div class="w-14 h-14 bg-white rounded-xl border border-neutral-200 shadow-sm p-1 flex items-center justify-center">
                <img src="../${n.image || 'assets/images/notes/patchouli.png'}" alt="${escapeHtml(n.name)}" class="max-w-full max-h-full object-contain">
              </div>
              <span class="mt-1.5 text-[11px] font-semibold text-slate-800 leading-tight">${escapeHtml(n.name)}</span>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  // Base Notes
  if (productNotes.base && productNotes.base.length > 0) {
    html += `
      <div class="text-center">
        <div class="relative flex py-2 items-center">
          <div class="flex-grow border-t border-neutral-200"></div>
          <span class="flex-shrink mx-4 text-[11px] font-bold tracking-widest text-[#2c405a] uppercase">BASE NOTES</span>
          <div class="flex-grow border-t border-neutral-200"></div>
        </div>
        <div class="flex flex-wrap items-start justify-center gap-4 mt-3">
          ${productNotes.base.map(n => `
            <div class="flex flex-col items-center text-center w-16 group">
              <div class="w-14 h-14 bg-white rounded-xl border border-neutral-200 shadow-sm p-1 flex items-center justify-center">
                <img src="../${n.image || 'assets/images/notes/patchouli.png'}" alt="${escapeHtml(n.name)}" class="max-w-full max-h-full object-contain">
              </div>
              <span class="mt-1.5 text-[11px] font-semibold text-slate-800 leading-tight">${escapeHtml(n.name)}</span>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  html += '</div>';
  preview.innerHTML = html;
}

function removeNote(tier, idx) {
  if (productNotes[tier]) {
    productNotes[tier].splice(idx, 1);
    renderNotes();
  }
}

function openAddNoteModal(tier) {
  document.getElementById('modalNoteTier').value = tier;
  document.getElementById('modalNoteNameInput').value = '';
  document.getElementById('filterLibraryInput').value = '';
  switchNoteTab('library');
  renderLibraryGrid(NOTES_LIBRARY);

  // default to first library note matching tier if any
  const matched = NOTES_LIBRARY.find(item => (item.tier_default || 'top') === tier) || NOTES_LIBRARY[0];
  if (matched) {
    selectLibraryNote(matched);
  }

  document.getElementById('addNoteModal').classList.remove('hidden');
  document.getElementById('modalNoteNameInput').focus();
}

function closeAddNoteModal() {
  document.getElementById('addNoteModal').classList.add('hidden');
}

function switchNoteTab(tab) {
  currentActiveTab = tab;
  ['library', 'upload', 'url'].forEach(t => {
    const btn = document.getElementById('tabBtn' + t.charAt(0).toUpperCase() + t.slice(1));
    const content = document.getElementById('tabContent' + t.charAt(0).toUpperCase() + t.slice(1));
    if (t === tab) {
      btn.className = 'py-1.5 px-3 font-bold border-b-2 border-neutral-900 text-neutral-900 transition';
      content.classList.remove('hidden');
    } else {
      btn.className = 'py-1.5 px-3 font-medium text-neutral-500 hover:text-neutral-900 transition';
      content.classList.add('hidden');
    }
  });
}

function renderLibraryGrid(items) {
  const grid = document.getElementById('libraryGrid');
  grid.innerHTML = '';
  
  if (items.length === 0) {
    grid.innerHTML = '<span class="col-span-4 text-xs text-neutral-400 p-2">No matching notes found.</span>';
    return;
  }

  items.forEach(item => {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'flex flex-col items-center text-center p-2 rounded-xl bg-white hover:bg-neutral-100 border border-neutral-200/80 transition hover:scale-105';
    btn.onclick = () => selectLibraryNote(item);
    btn.innerHTML = `
      <div class="w-10 h-10 rounded-lg p-0.5 flex items-center justify-center">
        <img src="../${item.image}" alt="${item.name}" class="max-w-full max-h-full object-contain">
      </div>
      <span class="text-[10px] font-bold text-neutral-800 truncate w-full mt-1">${escapeHtml(item.name)}</span>
    `;
    grid.appendChild(btn);
  });
}

function filterLibraryNotes() {
  const q = document.getElementById('filterLibraryInput').value.toLowerCase().trim();
  const filtered = NOTES_LIBRARY.filter(item => item.name.toLowerCase().includes(q));
  renderLibraryGrid(filtered);
}

function selectLibraryNote(item) {
  document.getElementById('modalNoteNameInput').value = item.name;
  currentSelectedImage = item.image;
  document.getElementById('selectedNoteImgPreview').src = '../' + item.image;
  document.getElementById('selectedNoteImgPath').textContent = item.image;
}

function handleCustomNoteUpload(e) {
  const file = e.target.files[0];
  if (!file) return;

  const status = document.getElementById('uploadStatusText');
  status.textContent = 'Uploading picture...';
  status.className = 'text-[11px] text-amber-600 font-semibold';

  const formData = new FormData();
  formData.append('note_image', file);

  fetch('api-notes.php?action=upload', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success && data.url) {
      currentSelectedImage = data.url;
      document.getElementById('selectedNoteImgPreview').src = '../' + data.url;
      document.getElementById('selectedNoteImgPath').textContent = data.url;
      status.textContent = '✓ Uploaded successfully!';
      status.className = 'text-[11px] text-emerald-600 font-semibold';
      
      // If name is empty, auto-fill from filename
      const nameInput = document.getElementById('modalNoteNameInput');
      if (!nameInput.value.trim()) {
        const rawName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]+/g, ' ');
        nameInput.value = rawName.charAt(0).toUpperCase() + rawName.slice(1);
      }
    } else {
      status.textContent = 'Upload failed: ' + (data.error || 'Server error');
      status.className = 'text-[11px] text-red-600';
    }
  })
  .catch(err => {
    status.textContent = 'Upload failed: ' + err.message;
    status.className = 'text-[11px] text-red-600';
  });
}

function handleCustomUrlChange(url) {
  const trimmed = url.trim();
  if (trimmed) {
    currentSelectedImage = trimmed;
    const previewSrc = trimmed.startsWith('http') ? trimmed : '../' + trimmed;
    document.getElementById('selectedNoteImgPreview').src = previewSrc;
    document.getElementById('selectedNoteImgPath').textContent = trimmed;
  }
}

function confirmAddNote() {
  const name = document.getElementById('modalNoteNameInput').value.trim();
  const tier = document.getElementById('modalNoteTier').value;

  if (!name) {
    alert('Please enter a note name (e.g. Raspberry, Rose, Patchouli).');
    document.getElementById('modalNoteNameInput').focus();
    return;
  }

  if (!productNotes[tier]) {
    productNotes[tier] = [];
  }

  productNotes[tier].push({
    name: name,
    image: currentSelectedImage || 'assets/images/notes/patchouli.png'
  });

  renderNotes();
  closeAddNoteModal();
}

function escapeHtml(str) {
  if (!str) return '';
  return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// Ensure form submission always syncs notes
document.querySelector('form').addEventListener('submit', function() {
  document.getElementById('notesJsonInput').value = JSON.stringify(productNotes);
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  renderNotes();
});
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
