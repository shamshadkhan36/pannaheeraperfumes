<?php
$pageTitle = 'Olfactory Notes Library';
include_once __DIR__ . '/includes/header.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$deleteId = isset($_GET['id']) ? trim($_GET['id']) : '';

$library = loadNotesLibrary();

// Handle Delete Action
if ($action === 'delete' && !empty($deleteId)) {
    $filtered = array_filter($library, function($item) use ($deleteId) {
        return $item['id'] !== $deleteId;
    });
    saveNotesLibrary(array_values($filtered));
    $_SESSION['flash_success'] = 'Fragrance note deleted from library.';
    header('Location: notes.php');
    exit;
}

// Handle Add/Edit Note
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noteName = trim($_POST['note_name'] ?? '');
    $tier = trim($_POST['tier_default'] ?? 'top');
    $existingImg = trim($_POST['existing_image'] ?? '');
    $noteId = trim($_POST['note_id'] ?? '');

    if (empty($noteName)) {
        $_SESSION['flash_error'] = 'Note name cannot be empty.';
        header('Location: notes.php');
        exit;
    }

    if (empty($noteId)) {
        $noteId = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $noteName));
    }

    $uploaded = handleNoteImageUpload('note_image_file');
    $finalImage = $uploaded ? $uploaded : ($existingImg ? $existingImg : 'assets/images/notes/patchouli.png');

    $found = false;
    foreach ($library as &$item) {
        if ($item['id'] === $noteId) {
            $item['name'] = $noteName;
            $item['tier_default'] = $tier;
            $item['image'] = $finalImage;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $library[] = [
            'id' => $noteId,
            'name' => $noteName,
            'tier_default' => $tier,
            'image' => $finalImage
        ];
    }

    saveNotesLibrary($library);
    $_SESSION['flash_success'] = 'Fragrance note "' . htmlspecialchars($noteName) . '" saved to library!';
    header('Location: notes.php');
    exit;
}
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-xl font-bold text-neutral-900">Fragrance Notes Library</h1>
    <p class="text-xs text-neutral-500 mt-0.5">Manage olfactory pyramid ingredients (Top Notes, Middle Notes, Base Notes) with photos & icons used across your perfumes.</p>
  </div>
  <button 
    onclick="openNoteModal()" 
    class="bg-black hover:bg-neutral-800 text-white text-xs font-bold px-4 py-2.5 rounded-full inline-flex items-center gap-2 transition shadow-sm self-start"
  >
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
    <span>Add New Note</span>
  </button>
</div>

<!-- Notice banner on how notes attach to products -->
<div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6 flex items-start gap-3">
  <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 text-amber-700">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
  </div>
  <div class="text-xs text-amber-900 leading-relaxed">
    <strong class="font-bold">How Fragrance Notes work:</strong> Notes created here appear in your master Olfactory Library. When editing any product in <a href="products.php" class="font-bold underline text-amber-950">Manage Products</a> &rarr; <em>Product Editor</em>, you can add Top, Middle, and Base notes with one click from this library, or upload bespoke notes for that individual perfume.
  </div>
</div>

<!-- Notes by Tier Tabs & Grid -->
<div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6 space-y-8">

  <!-- TOP NOTES -->
  <div>
    <div class="flex items-center justify-between pb-3 border-b border-neutral-200 mb-4">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-800">Top Notes (Head Notes)</h2>
        <span class="text-xs text-neutral-400">Initial freshness & burst (Raspberry, Citrus, Berries, Fresh herbs)</span>
      </div>
      <span class="text-xs font-semibold px-2 py-0.5 bg-neutral-100 rounded text-neutral-600">
        <?php echo count(array_filter($library, fn($n) => ($n['tier_default'] ?? '') === 'top')); ?> items
      </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
      <?php foreach ($library as $item): ?>
        <?php if (($item['tier_default'] ?? 'top') === 'top'): ?>
          <div class="group relative bg-neutral-50 hover:bg-white rounded-xl border border-neutral-200/80 p-3 flex flex-col items-center text-center transition-all hover:shadow-md">
            <div class="w-16 h-16 bg-white rounded-lg p-1.5 flex items-center justify-center border border-neutral-100 shadow-sm mb-2">
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="max-w-full max-h-full object-contain">
            </div>
            <span class="text-xs font-bold text-neutral-800 truncate w-full" title="<?php echo htmlspecialchars($item['name']); ?>">
              <?php echo htmlspecialchars($item['name']); ?>
            </span>
            <div class="mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
              <button 
                onclick='editNote(<?php echo json_encode($item); ?>)' 
                class="p-1 text-neutral-500 hover:text-black rounded hover:bg-neutral-100" 
                title="Edit"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
              </button>
              <a 
                href="notes.php?action=delete&id=<?php echo urlencode($item['id']); ?>" 
                onclick="return confirm('Delete this note from the library?');" 
                class="p-1 text-red-500 hover:text-red-700 rounded hover:bg-red-50" 
                title="Delete"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </a>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- MIDDLE NOTES -->
  <div>
    <div class="flex items-center justify-between pb-3 border-b border-neutral-200 mb-4">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-800">Middle Notes (Heart Notes)</h2>
        <span class="text-xs text-neutral-400">Core character & personality (Rose, Jasmine, Spices, Florals)</span>
      </div>
      <span class="text-xs font-semibold px-2 py-0.5 bg-neutral-100 rounded text-neutral-600">
        <?php echo count(array_filter($library, fn($n) => ($n['tier_default'] ?? '') === 'middle')); ?> items
      </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
      <?php foreach ($library as $item): ?>
        <?php if (($item['tier_default'] ?? '') === 'middle'): ?>
          <div class="group relative bg-neutral-50 hover:bg-white rounded-xl border border-neutral-200/80 p-3 flex flex-col items-center text-center transition-all hover:shadow-md">
            <div class="w-16 h-16 bg-white rounded-lg p-1.5 flex items-center justify-center border border-neutral-100 shadow-sm mb-2">
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="max-w-full max-h-full object-contain">
            </div>
            <span class="text-xs font-bold text-neutral-800 truncate w-full" title="<?php echo htmlspecialchars($item['name']); ?>">
              <?php echo htmlspecialchars($item['name']); ?>
            </span>
            <div class="mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
              <button 
                onclick='editNote(<?php echo json_encode($item); ?>)' 
                class="p-1 text-neutral-500 hover:text-black rounded hover:bg-neutral-100" 
                title="Edit"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
              </button>
              <a 
                href="notes.php?action=delete&id=<?php echo urlencode($item['id']); ?>" 
                onclick="return confirm('Delete this note from the library?');" 
                class="p-1 text-red-500 hover:text-red-700 rounded hover:bg-red-50" 
                title="Delete"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </a>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- BASE NOTES -->
  <div>
    <div class="flex items-center justify-between pb-3 border-b border-neutral-200 mb-4">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-amber-600"></span>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-800">Base Notes (Dry Down)</h2>
        <span class="text-xs text-neutral-400">Longest lasting foundation (Patchouli, Vanilla, Amber, Sandalwood, Oud)</span>
      </div>
      <span class="text-xs font-semibold px-2 py-0.5 bg-neutral-100 rounded text-neutral-600">
        <?php echo count(array_filter($library, fn($n) => ($n['tier_default'] ?? '') === 'base')); ?> items
      </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
      <?php foreach ($library as $item): ?>
        <?php if (($item['tier_default'] ?? '') === 'base'): ?>
          <div class="group relative bg-neutral-50 hover:bg-white rounded-xl border border-neutral-200/80 p-3 flex flex-col items-center text-center transition-all hover:shadow-md">
            <div class="w-16 h-16 bg-white rounded-lg p-1.5 flex items-center justify-center border border-neutral-100 shadow-sm mb-2">
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="max-w-full max-h-full object-contain">
            </div>
            <span class="text-xs font-bold text-neutral-800 truncate w-full" title="<?php echo htmlspecialchars($item['name']); ?>">
              <?php echo htmlspecialchars($item['name']); ?>
            </span>
            <div class="mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
              <button 
                onclick='editNote(<?php echo json_encode($item); ?>)' 
                class="p-1 text-neutral-500 hover:text-black rounded hover:bg-neutral-100" 
                title="Edit"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
              </button>
              <a 
                href="notes.php?action=delete&id=<?php echo urlencode($item['id']); ?>" 
                onclick="return confirm('Delete this note from the library?');" 
                class="p-1 text-red-500 hover:text-red-700 rounded hover:bg-red-50" 
                title="Delete"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </a>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<!-- Note Add/Edit Modal -->
<div id="noteModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in-95 duration-150">
    <button onclick="closeNoteModal()" class="absolute top-4 right-4 text-neutral-400 hover:text-neutral-800">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    <h3 id="modalTitle" class="text-base font-bold text-neutral-900 mb-1">Add Fragrance Note</h3>
    <p class="text-xs text-neutral-500 mb-4">Add note ingredient details and picture for your scent pyramid.</p>

    <form method="POST" action="notes.php" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="note_id" id="modalNoteId">
      <input type="hidden" name="existing_image" id="modalExistingImage">

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Note Name *</label>
        <input 
          type="text" 
          name="note_name" 
          id="modalNoteName" 
          required 
          placeholder="e.g. Raspberry, Rose, Patchouli" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Default Tier</label>
        <select name="tier_default" id="modalTier" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white">
          <option value="top">Top Note (Opening / Burst)</option>
          <option value="middle">Middle Note (Heart / Core)</option>
          <option value="base">Base Note (Drydown / Anchor)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Note Photo / Icon</label>
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 rounded-xl border border-neutral-200 bg-neutral-50 p-1 flex items-center justify-center flex-shrink-0 overflow-hidden">
            <img id="modalPreviewImg" src="../assets/images/notes/patchouli.png" class="max-w-full max-h-full object-contain">
          </div>
          <div class="flex-1">
            <input 
              type="file" 
              name="note_image_file" 
              accept="image/*" 
              onchange="previewModalImg(event)" 
              class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
            >
            <span class="text-[10px] text-neutral-400 block mt-1">Square format JPG, PNG, or WEBP recommended.</span>
          </div>
        </div>
      </div>

      <div class="pt-3 flex gap-2">
        <button 
          type="submit" 
          class="flex-1 bg-black hover:bg-neutral-800 text-white py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition"
        >
          Save to Library
        </button>
        <button 
          type="button" 
          onclick="closeNoteModal()" 
          class="px-4 py-2.5 rounded-full text-xs font-semibold text-neutral-600 hover:bg-neutral-100 transition"
        >
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openNoteModal() {
  document.getElementById('modalTitle').textContent = 'Add Fragrance Note';
  document.getElementById('modalNoteId').value = '';
  document.getElementById('modalNoteName').value = '';
  document.getElementById('modalExistingImage').value = '';
  document.getElementById('modalTier').value = 'top';
  document.getElementById('modalPreviewImg').src = '../assets/images/notes/patchouli.png';
  document.getElementById('noteModal').classList.remove('hidden');
}

function editNote(item) {
  document.getElementById('modalTitle').textContent = 'Edit Fragrance Note';
  document.getElementById('modalNoteId').value = item.id || '';
  document.getElementById('modalNoteName').value = item.name || '';
  document.getElementById('modalExistingImage').value = item.image || '';
  document.getElementById('modalTier').value = item.tier_default || 'top';
  document.getElementById('modalPreviewImg').src = '../' + (item.image || 'assets/images/notes/patchouli.png');
  document.getElementById('noteModal').classList.remove('hidden');
}

function closeNoteModal() {
  document.getElementById('noteModal').classList.add('hidden');
}

function previewModalImg(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(evt) {
      document.getElementById('modalPreviewImg').src = evt.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>