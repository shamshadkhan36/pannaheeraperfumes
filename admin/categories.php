<?php
$pageTitle = 'Manage Categories';
include_once __DIR__ . '/includes/header.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$editId = isset($_GET['id']) ? trim($_GET['id']) : '';

// Handle Delete
if ($action === 'delete' && !empty($editId)) {
    $categories = $siteData['categories'] ?? [];
    $filtered = array_filter($categories, function($c) use ($editId) {
        return $c['id'] !== $editId;
    });
    $siteData['categories'] = array_values($filtered);
    saveSiteData($siteData);
    $_SESSION['flash_success'] = 'Category deleted successfully!';
    header('Location: categories.php');
    exit;
}

// Handle Add or Edit POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catId = isset($_POST['cat_id']) ? trim($_POST['cat_id']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : '';
    $badge = isset($_POST['badge']) ? trim($_POST['badge']) : '';
    $isEdit = !empty($_POST['is_edit']);

    // Generate slug id if adding
    if (empty($catId)) {
        $catId = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
    }

    $uploadedImg = handleImageUpload('category_image');
    $currentImg = isset($_POST['existing_image']) ? $_POST['existing_image'] : 'assets/images/categories/perfume-spray.jpg';
    $finalImg = $uploadedImg ? $uploadedImg : $currentImg;

    $categories = $siteData['categories'] ?? [];

    if ($isEdit) {
        foreach ($categories as &$c) {
            if ($c['id'] === $catId) {
                $c['title'] = $title;
                $c['subtitle'] = $subtitle;
                $c['badge'] = $badge;
                $c['image'] = $finalImg;
                break;
            }
        }
        $_SESSION['flash_success'] = 'Category "' . $title . '" updated successfully!';
    } else {
        $newCategory = [
            'id' => $catId,
            'title' => $title,
            'subtitle' => $subtitle,
            'image' => $finalImg,
            'badge' => $badge,
            'count' => 0
        ];
        $categories[] = $newCategory;
        $_SESSION['flash_success'] = 'New category "' . $title . '" created successfully!';
    }

    $siteData['categories'] = array_values($categories);
    saveSiteData($siteData);
    header('Location: categories.php');
    exit;
}

// Find category if editing
$editingCat = null;
if ($action === 'edit' && !empty($editId)) {
    foreach ($siteData['categories'] ?? [] as $c) {
        if ($c['id'] === $editId) {
            $editingCat = $c;
            break;
        }
    }
}
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-xl font-bold text-neutral-900">Manage Product Categories</h1>
    <p class="text-xs text-neutral-500 mt-0.5">Add, edit or update categories shown on the homepage and in the navigation dropdown.</p>
  </div>
  <a href="#add-category-box" class="bg-black hover:bg-neutral-800 text-white text-xs font-bold px-4 py-2.5 rounded-full inline-flex items-center gap-2 transition shadow-sm">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
    <span>Add New Category</span>
  </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
  
  <!-- Categories Table (8 cols) -->
  <div class="lg:col-span-8 bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-neutral-200 flex items-center justify-between">
      <h3 class="font-bold text-sm text-neutral-900">Active Categories (<?php echo count($siteData['categories'] ?? []); ?>)</h3>
      <span class="text-xs text-neutral-400">Appears in "Shop By Categories"</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-neutral-50 border-b border-neutral-200 text-neutral-500 uppercase tracking-wider">
          <tr>
            <th class="py-3 px-4">Thumbnail</th>
            <th class="py-3 px-4">Category Details</th>
            <th class="py-3 px-4">Badge</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <?php foreach ($siteData['categories'] ?? [] as $cat): ?>
            <tr class="hover:bg-neutral-50 transition">
              <td class="py-3 px-4 w-16">
                <div class="w-12 h-12 bg-neutral-100 rounded-lg overflow-hidden border border-neutral-200 flex items-center justify-center">
                  <img src="../<?php echo htmlspecialchars($cat['image']); ?>" alt="<?php echo htmlspecialchars($cat['title']); ?>" class="w-full h-full object-cover">
                </div>
              </td>
              <td class="py-3 px-4">
                <strong class="text-neutral-900 text-xs block"><?php echo htmlspecialchars($cat['title']); ?></strong>
                <span class="text-[11px] text-neutral-500 block"><?php echo htmlspecialchars($cat['subtitle'] ?? ''); ?></span>
                <span class="text-[10px] text-neutral-400 font-mono">ID: <?php echo htmlspecialchars($cat['id']); ?></span>
              </td>
              <td class="py-3 px-4">
                <?php if (!empty($cat['badge'])): ?>
                  <span class="bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                    <?php echo htmlspecialchars($cat['badge']); ?>
                  </span>
                <?php else: ?>
                  <span class="text-neutral-400">—</span>
                <?php endif; ?>
              </td>
              <td class="py-3 px-4 text-right space-x-2">
                <a href="categories.php?action=edit&id=<?php echo urlencode($cat['id']); ?>#add-category-box" class="text-blue-600 hover:underline font-semibold">Edit</a>
                <a href="categories.php?action=delete&id=<?php echo urlencode($cat['id']); ?>" onclick="return confirm('Are you sure you want to delete this category?');" class="text-red-600 hover:underline font-semibold">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add / Edit Category Form (4 cols) -->
  <div id="add-category-box" class="lg:col-span-4">
    <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm sticky top-6">
      <h3 class="font-bold text-sm text-neutral-900 mb-1">
        <?php echo $editingCat ? 'Edit Category' : 'Add New Category'; ?>
      </h3>
      <p class="text-xs text-neutral-400 mb-4">
        <?php echo $editingCat ? 'Update category information below.' : 'Create a new category card for your catalog.'; ?>
      </p>

      <form method="POST" action="categories.php" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="is_edit" value="<?php echo $editingCat ? '1' : '0'; ?>">
        <input type="hidden" name="cat_id" value="<?php echo htmlspecialchars($editingCat['id'] ?? ''); ?>">
        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editingCat['image'] ?? ''); ?>">

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Category Title *</label>
          <input 
            type="text" 
            name="title" 
            required 
            placeholder="e.g. Glass Bottles & Pumps" 
            value="<?php echo htmlspecialchars($editingCat['title'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-semibold"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Subtitle / Short Note</label>
          <input 
            type="text" 
            name="subtitle" 
            placeholder="e.g. Full Assembled Luxury Sets" 
            value="<?php echo htmlspecialchars($editingCat['subtitle'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Highlight Badge</label>
          <input 
            type="text" 
            name="badge" 
            placeholder="e.g. Best Seller, Private Label" 
            value="<?php echo htmlspecialchars($editingCat['badge'] ?? ''); ?>" 
            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          >
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Category Card Image</label>
          <?php if (!empty($editingCat['image'])): ?>
            <div class="w-16 h-16 rounded border border-neutral-200 overflow-hidden mb-2">
              <img src="../<?php echo htmlspecialchars($editingCat['image']); ?>" alt="Category Preview" class="w-full h-full object-cover">
            </div>
          <?php endif; ?>
          <input 
            type="file" 
            name="category_image" 
            accept="image/*" 
            class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
          >
        </div>

        <div class="pt-2 flex items-center gap-2">
          <button 
            type="submit" 
            class="flex-1 bg-neutral-900 hover:bg-black text-white py-2.5 rounded-lg text-xs font-bold transition shadow-sm"
          >
            <?php echo $editingCat ? 'Update Category' : 'Save Category'; ?>
          </button>
          <?php if ($editingCat): ?>
            <a href="categories.php" class="px-3 py-2 text-xs text-neutral-500 hover:text-neutral-800">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
