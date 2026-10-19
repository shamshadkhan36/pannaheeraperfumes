<?php
$pageTitle = 'Hero Banner Settings';
include_once __DIR__ . '/includes/header.php';

$banner = $siteData['banner'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayStyle = isset($_POST['display_style']) ? trim($_POST['display_style']) : 'image_only';
    $bannerLink = isset($_POST['link']) ? trim($_POST['link']) : '';
    $bannerAlt = isset($_POST['alt']) ? trim($_POST['alt']) : 'Panna Heera Perfumery';
    
    // Text overlay fields (used if with_text is selected)
    $headline = isset($_POST['headline']) ? trim($_POST['headline']) : '';
    $subheadline = isset($_POST['subheadline']) ? trim($_POST['subheadline']) : '';
    $buttonText = isset($_POST['button_text']) ? trim($_POST['button_text']) : 'Quick WhatsApp Quote';

    // Handle Image Upload
    $uploadedBanner = handleImageUpload('banner_image_file');
    $currentImage = !empty($banner['image']) ? $banner['image'] : (!empty($banner['background_image']) ? $banner['background_image'] : 'assets/images/hero-perfume-bg.jpg');
    
    // Check if preset selected
    if (!empty($_POST['preset_image'])) {
        $currentImage = trim($_POST['preset_image']);
    }
    
    // Uploaded image overrides preset
    if ($uploadedBanner) {
        $currentImage = $uploadedBanner;
    }

    // Process Marquee Items (one per line)
    $marqueeRaw = isset($_POST['marquee_items']) ? trim($_POST['marquee_items']) : '';
    $marqueeLines = array_values(array_filter(array_map('trim', explode("\n", $marqueeRaw))));

    $siteData['banner'] = [
        'display_style' => $displayStyle,
        'image' => $currentImage,
        'background_image' => $currentImage,
        'link' => $bannerLink,
        'alt' => $bannerAlt,
        'headline' => $headline,
        'subheadline' => $subheadline,
        'button_text' => $buttonText,
        'marquee_items' => $marqueeLines
    ];

    saveSiteData($siteData);
    $_SESSION['flash_success'] = 'Hero banner image updated successfully!';
    header('Location: banner.php');
    exit;
}

// Current values
$displayStyle = $banner['display_style'] ?? 'image_only';
$currentImage = !empty($banner['image']) ? $banner['image'] : (!empty($banner['background_image']) ? $banner['background_image'] : 'assets/images/hero-perfume-bg.jpg');
$bannerLink = $banner['link'] ?? getWhatsAppLink('Hi Panna Heera Perfumes, I am interested in your perfume bottles and special offers.');
$bannerAlt = $banner['alt'] ?? 'Panna Heera Perfumery Luxury Glass Bottles and Caps';
$headline = $banner['headline'] ?? 'Exquisite Glass Bottles & Designer Closures';
$subheadline = $banner['subheadline'] ?? 'Empowering prestige perfume brands with luxury super-flint glass bottles, heavy Zamac magnetic caps, and high-atomization fine mist pumps.';
$buttonText = $banner['button_text'] ?? 'Quick WhatsApp Quote';

$marqueeString = implode("\n", $banner['marquee_items'] ?? [
    'Scalable Supply',
    'Competitive Pricing',
    'Industry Trusted',
    'Long Lasting Fragrances',
    'High Quality Glass Bottles',
    'Designer Caps',
    'High Quality Pumps',
    'Custom Branding & Silk Printing',
    'Fast Turnaround'
]);
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-xl sm:text-2xl font-bold text-neutral-900">Hero Banner Settings</h1>
    <p class="text-xs text-neutral-500 mt-1">Upload and customize your homepage hero banner image, destination link, and scrolling ticker.</p>
  </div>
  <div>
    <a href="../index.php" target="_blank" class="bg-neutral-900 hover:bg-black text-white text-xs font-semibold px-4 py-2.5 rounded-full inline-flex items-center gap-1.5 transition shadow-sm">
      <span>Preview on Homepage</span>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
    </a>
  </div>
</div>

<form method="POST" action="banner.php" enctype="multipart/form-data" class="space-y-6 max-w-4xl pb-16">

  <!-- ======================================================== -->
  <!-- 1. HERO BANNER IMAGE UPLOAD & PREVIEW                    -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-5">
    <div class="border-b border-neutral-100 pb-3">
      <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900 flex items-center gap-2">
        <span>🖼️ Hero Banner Image</span>
      </h2>
      <p class="text-xs text-neutral-400 mt-0.5">The primary showcase image displayed at the very top of your homepage.</p>
    </div>

    <!-- Live Current Banner Preview -->
    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-2">Current Active Hero Banner</label>
      <div class="relative w-full rounded-xl overflow-hidden border border-neutral-300 bg-neutral-950 shadow-inner group">
        <img 
          src="../<?php echo htmlspecialchars($currentImage); ?>" 
          alt="Current Banner" 
          class="w-full h-auto max-h-[340px] object-cover mx-auto"
        >
        <div class="absolute bottom-3 left-3 bg-black/75 backdrop-blur-md text-white text-[11px] px-3 py-1.5 rounded-lg border border-white/20">
          File: <span class="font-mono text-gold"><?php echo htmlspecialchars($currentImage); ?></span>
        </div>
      </div>
    </div>

    <!-- Upload Input -->
    <div class="pt-2">
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Upload New Banner Image</label>
      <input 
        type="file" 
        name="banner_image_file" 
        accept="image/*" 
        class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-neutral-900 file:text-white hover:file:bg-black cursor-pointer"
      >
      <p class="text-[11px] text-neutral-400 mt-1.5">
        Recommended size: <strong>1920x650px</strong>, <strong>1400x550px</strong>, or wide banner graphics (JPG, PNG, WEBP).
      </p>
    </div>

    <!-- Preset Luxury Backgrounds -->
    <div class="pt-2 border-t border-neutral-100">
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-2">Or Choose from Preset Images</label>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        
        <label class="border-2 rounded-xl p-2 cursor-pointer transition flex items-center gap-2.5 <?php echo $currentImage === 'assets/images/hero-perfume-bg.jpg' ? 'border-gold bg-amber-50/30' : 'border-neutral-200 hover:border-neutral-300'; ?>">
          <input type="radio" name="preset_image" value="assets/images/hero-perfume-bg.jpg" <?php echo $currentImage === 'assets/images/hero-perfume-bg.jpg' ? 'checked' : ''; ?>>
          <img src="../assets/images/hero-perfume-bg.jpg" class="w-12 h-8 object-cover rounded">
          <span class="text-[11px] font-semibold text-neutral-800">Luxury Table</span>
        </label>

        <label class="border-2 rounded-xl p-2 cursor-pointer transition flex items-center gap-2.5 <?php echo $currentImage === 'assets/images/categories/bottles-caps-pumps.jpg' ? 'border-gold bg-amber-50/30' : 'border-neutral-200 hover:border-neutral-300'; ?>">
          <input type="radio" name="preset_image" value="assets/images/categories/bottles-caps-pumps.jpg" <?php echo $currentImage === 'assets/images/categories/bottles-caps-pumps.jpg' ? 'checked' : ''; ?>>
          <img src="../assets/images/categories/bottles-caps-pumps.jpg" class="w-12 h-8 object-cover rounded">
          <span class="text-[11px] font-semibold text-neutral-800">Bottles & Caps</span>
        </label>

        <label class="border-2 rounded-xl p-2 cursor-pointer transition flex items-center gap-2.5 <?php echo $currentImage === 'assets/images/categories/box-packaging.jpg' ? 'border-gold bg-amber-50/30' : 'border-neutral-200 hover:border-neutral-300'; ?>">
          <input type="radio" name="preset_image" value="assets/images/categories/box-packaging.jpg" <?php echo $currentImage === 'assets/images/categories/box-packaging.jpg' ? 'checked' : ''; ?>>
          <img src="../assets/images/categories/box-packaging.jpg" class="w-12 h-8 object-cover rounded">
          <span class="text-[11px] font-semibold text-neutral-800">Luxury Boxes</span>
        </label>

      </div>
    </div>
  </div>


  <!-- ======================================================== -->
  <!-- 2. BANNER CLICK LINK & DISPLAY STYLE                     -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-5">
    <div class="border-b border-neutral-100 pb-3">
      <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900 flex items-center gap-2">
        <span>🔗 Banner Link & Display Style</span>
      </h2>
      <p class="text-xs text-neutral-400 mt-0.5">Control where customers go when they click the banner and whether text should be displayed over the image.</p>
    </div>

    <!-- Display Style Selector -->
    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-2">Display Style</label>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        
        <label class="border-2 rounded-xl p-3.5 cursor-pointer transition flex items-start gap-3 <?php echo $displayStyle === 'image_only' ? 'border-gold bg-amber-50/40' : 'border-neutral-200 hover:border-neutral-300'; ?>">
          <input type="radio" name="display_style" value="image_only" <?php echo $displayStyle === 'image_only' ? 'checked' : ''; ?> class="mt-0.5" onchange="toggleTextSection(false)">
          <div>
            <div class="flex items-center gap-1.5">
              <span class="text-xs font-bold text-neutral-900">Simple Clean Banner Image (Recommended)</span>
              <span class="px-1.5 py-0.5 bg-emerald-600 text-white text-[10px] font-bold rounded">Clean</span>
            </div>
            <p class="text-[11px] text-neutral-500 mt-1 leading-relaxed">
              Displays the full banner image cleanly without any text or widgets covering the photo. The entire banner is clickable.
            </p>
          </div>
        </label>

        <label class="border-2 rounded-xl p-3.5 cursor-pointer transition flex items-start gap-3 <?php echo $displayStyle === 'with_text' ? 'border-gold bg-amber-50/40' : 'border-neutral-200 hover:border-neutral-300'; ?>">
          <input type="radio" name="display_style" value="with_text" <?php echo $displayStyle === 'with_text' ? 'checked' : ''; ?> class="mt-0.5" onchange="toggleTextSection(true)">
          <div>
            <span class="text-xs font-bold text-neutral-900">Banner with Title & Button Overlay</span>
            <p class="text-[11px] text-neutral-500 mt-1 leading-relaxed">
              Adds a simple headline, subtitle, and WhatsApp button over the background image.
            </p>
          </div>
        </label>

      </div>
    </div>

    <!-- Destination Link -->
    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Banner Click Destination Link</label>
      <input 
        type="text" 
        id="banner_link_input" 
        name="link" 
        value="<?php echo htmlspecialchars($bannerLink); ?>" 
        placeholder="e.g. WhatsApp quote link or #products-section"
        class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-mono"
      >
      
      <!-- Quick Fill Buttons -->
      <div class="flex items-center gap-2 mt-2 flex-wrap">
        <button 
          type="button" 
          onclick="document.getElementById('banner_link_input').value = '<?php echo htmlspecialchars(getWhatsAppLink('Hi Panna Heera Perfumes, I saw your hero banner and want to inquire about custom bottles and special offers!')); ?>'"
          class="text-[11px] bg-neutral-100 hover:bg-neutral-200 text-neutral-700 px-3 py-1 rounded-full font-semibold transition"
        >
          💬 Set to WhatsApp Quote Link
        </button>
        <button 
          type="button" 
          onclick="document.getElementById('banner_link_input').value = '#products-section'"
          class="text-[11px] bg-neutral-100 hover:bg-neutral-200 text-neutral-700 px-3 py-1 rounded-full font-semibold transition"
        >
          🧴 Set to Products Section (#products-section)
        </button>
      </div>
    </div>

    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Image Alt Text (SEO)</label>
      <input 
        type="text" 
        name="alt" 
        value="<?php echo htmlspecialchars($bannerAlt); ?>" 
        placeholder="e.g. Panna Heera Perfumery Luxury Glass Bottles and Caps"
        class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
      >
    </div>

    <!-- Text Overlay Options (Hidden by default if image_only is selected) -->
    <div id="text_overlay_section" class="<?php echo $displayStyle === 'with_text' ? '' : 'hidden'; ?> p-4 bg-neutral-50 rounded-xl border border-neutral-200 space-y-3">
      <h3 class="text-xs font-bold text-neutral-800 uppercase tracking-wider">Optional Text Overlay Fields</h3>
      
      <div>
        <label class="block text-[11px] font-semibold text-neutral-700 mb-1">Headline</label>
        <input 
          type="text" 
          name="headline" 
          value="<?php echo htmlspecialchars($headline); ?>" 
          class="w-full px-3 py-2 text-xs rounded border border-neutral-300 bg-white"
        >
      </div>

      <div>
        <label class="block text-[11px] font-semibold text-neutral-700 mb-1">Subheadline</label>
        <textarea 
          name="subheadline" 
          rows="2" 
          class="w-full px-3 py-2 text-xs rounded border border-neutral-300 bg-white"
        ><?php echo htmlspecialchars($subheadline); ?></textarea>
      </div>

      <div>
        <label class="block text-[11px] font-semibold text-neutral-700 mb-1">Button Text</label>
        <input 
          type="text" 
          name="button_text" 
          value="<?php echo htmlspecialchars($buttonText); ?>" 
          class="w-full px-3 py-2 text-xs rounded border border-neutral-300 bg-white"
        >
      </div>
    </div>

  </div>


  <!-- ======================================================== -->
  <!-- 3. MARQUEE TICKER                                        -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
    <div class="border-b border-neutral-100 pb-3">
      <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Infinite Marquee Trust Ticker</h2>
      <p class="text-xs text-neutral-400 mt-0.5">Scrolling trust points displayed in the dark bar directly below the hero banner.</p>
    </div>

    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Ticker Points (One item per line)</label>
      <textarea 
        name="marquee_items" 
        rows="6" 
        class="w-full font-mono text-xs px-3.5 py-2.5 rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
      ><?php echo htmlspecialchars($marqueeString); ?></textarea>
      <p class="text-[11px] text-neutral-400 mt-1">Each line is displayed smoothly in the infinite loop separated by gold diamonds (✦).</p>
    </div>
  </div>


  <!-- Save Button -->
  <div class="flex items-center justify-end gap-3 pt-2">
    <button 
      type="submit" 
      class="bg-gold hover:bg-[#b08b42] text-white px-8 py-3.5 rounded-full text-xs font-bold uppercase tracking-wider transition shadow-lg flex items-center gap-2"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
      <span>Save Hero Banner</span>
    </button>
  </div>

</form>

<script>
function toggleTextSection(show) {
  const sec = document.getElementById('text_overlay_section');
  if (show) {
    sec.classList.remove('hidden');
  } else {
    sec.classList.add('hidden');
  }
}
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
