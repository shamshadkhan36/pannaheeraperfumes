<?php
$pageTitle = 'Hero Banner & Special Offers';
include_once __DIR__ . '/includes/header.php';

$banner = $siteData['banner'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hero Mode & Offer Active
    $hero_mode = isset($_POST['hero_mode']) ? trim($_POST['hero_mode']) : 'offer';
    $offer_active = isset($_POST['offer_active']) && $_POST['offer_active'] === '1';

    // Offer Fields
    $offer_badge = isset($_POST['offer_badge']) ? trim($_POST['offer_badge']) : '';
    $offer_discount_text = isset($_POST['offer_discount_text']) ? trim($_POST['offer_discount_text']) : '';
    $offer_headline = isset($_POST['offer_headline']) ? trim($_POST['offer_headline']) : '';
    $offer_subheadline = isset($_POST['offer_subheadline']) ? trim($_POST['offer_subheadline']) : '';
    $offer_coupon_code = isset($_POST['offer_coupon_code']) ? strtoupper(trim($_POST['offer_coupon_code'])) : '';
    $offer_countdown_enabled = isset($_POST['offer_countdown_enabled']) && $_POST['offer_countdown_enabled'] === '1';
    $offer_end_date = isset($_POST['offer_end_date']) ? trim($_POST['offer_end_date']) : '';
    $offer_countdown_label = isset($_POST['offer_countdown_label']) ? trim($_POST['offer_countdown_label']) : 'Special Offer Expires In:';

    // Offer Perks (one per line)
    $perksRaw = isset($_POST['offer_perks']) ? trim($_POST['offer_perks']) : '';
    $perksLines = array_values(array_filter(array_map('trim', explode("\n", $perksRaw))));

    // Offer Buttons
    $offer_btn1_text = isset($_POST['offer_button1_text']) ? trim($_POST['offer_button1_text']) : '';
    $offer_btn1_link = isset($_POST['offer_button1_link']) ? trim($_POST['offer_button1_link']) : '';
    $offer_btn2_text = isset($_POST['offer_button2_text']) ? trim($_POST['offer_button2_text']) : '';
    $offer_btn2_link = isset($_POST['offer_button2_link']) ? trim($_POST['offer_button2_link']) : '';

    // Offer Spotlight Card
    $offer_card_enabled = isset($_POST['offer_card_enabled']) && $_POST['offer_card_enabled'] === '1';
    $offer_card_title = isset($_POST['offer_card_title']) ? trim($_POST['offer_card_title']) : '';
    $offer_card_subtitle = isset($_POST['offer_card_subtitle']) ? trim($_POST['offer_card_subtitle']) : '';
    $offer_card_price = isset($_POST['offer_card_price']) ? trim($_POST['offer_card_price']) : '';
    $offer_card_original_price = isset($_POST['offer_card_original_price']) ? trim($_POST['offer_card_original_price']) : '';
    $offer_card_moq = isset($_POST['offer_card_moq']) ? trim($_POST['offer_card_moq']) : '';
    $offer_card_badge = isset($_POST['offer_card_badge']) ? trim($_POST['offer_card_badge']) : '';

    // Standard Showcase Fields
    $tagline = isset($_POST['tagline']) ? trim($_POST['tagline']) : '';
    $headline = isset($_POST['headline']) ? trim($_POST['headline']) : '';
    $subheadline = isset($_POST['subheadline']) ? trim($_POST['subheadline']) : '';
    $btn1_text = isset($_POST['button1_text']) ? trim($_POST['button1_text']) : '';
    $btn1_link = isset($_POST['button1_link']) ? trim($_POST['button1_link']) : '';
    $btn2_text = isset($_POST['button2_text']) ? trim($_POST['button2_text']) : '';
    $btn2_link = isset($_POST['button2_link']) ? trim($_POST['button2_link']) : '';

    // Top Announcement Bar
    $top_announcement_enabled = isset($_POST['top_announcement_enabled']) && $_POST['top_announcement_enabled'] === '1';
    $top_announcement_text = isset($_POST['top_announcement_text']) ? trim($_POST['top_announcement_text']) : '';
    $top_announcement_link = isset($_POST['top_announcement_link']) ? trim($_POST['top_announcement_link']) : '';

    // Handle Uploads
    $uploadedBanner = handleImageUpload('banner_image_file');
    $currentImage = $banner['background_image'] ?? 'assets/images/hero-perfume-bg.jpg';
    if ($uploadedBanner) {
        $currentImage = $uploadedBanner;
    }

    $uploadedOfferBg = handleImageUpload('offer_background_image_file');
    $currentOfferBg = $banner['offer_background_image'] ?? $currentImage;
    if ($uploadedOfferBg) {
        $currentOfferBg = $uploadedOfferBg;
    }

    $uploadedOfferFeatured = handleImageUpload('offer_featured_image_file');
    $currentOfferFeatured = $banner['offer_featured_image'] ?? 'assets/images/products/100ml-victor.jpg';
    if ($uploadedOfferFeatured) {
        $currentOfferFeatured = $uploadedOfferFeatured;
    }

    // Process Marquee Items (one per line)
    $marqueeRaw = isset($_POST['marquee_items']) ? trim($_POST['marquee_items']) : '';
    $marqueeLines = array_values(array_filter(array_map('trim', explode("\n", $marqueeRaw))));

    $siteData['banner'] = [
        'hero_mode' => $hero_mode,
        'tagline' => $tagline,
        'headline' => $headline,
        'subheadline' => $subheadline,
        'button1_text' => $btn1_text,
        'button1_link' => $btn1_link,
        'button2_text' => $btn2_text,
        'button2_link' => $btn2_link,
        'background_image' => $currentImage,

        'offer_active' => $offer_active,
        'offer_badge' => $offer_badge,
        'offer_discount_text' => $offer_discount_text,
        'offer_headline' => $offer_headline,
        'offer_subheadline' => $offer_subheadline,
        'offer_coupon_code' => $offer_coupon_code,
        'offer_countdown_enabled' => $offer_countdown_enabled,
        'offer_end_date' => $offer_end_date,
        'offer_countdown_label' => $offer_countdown_label,
        'offer_perks' => $perksLines,
        'offer_button1_text' => $offer_btn1_text,
        'offer_button1_link' => $offer_btn1_link,
        'offer_button2_text' => $offer_btn2_text,
        'offer_button2_link' => $offer_btn2_link,
        'offer_background_image' => $currentOfferBg,
        'offer_featured_image' => $currentOfferFeatured,
        'offer_card_enabled' => $offer_card_enabled,
        'offer_card_title' => $offer_card_title,
        'offer_card_subtitle' => $offer_card_subtitle,
        'offer_card_price' => $offer_card_price,
        'offer_card_original_price' => $offer_card_original_price,
        'offer_card_moq' => $offer_card_moq,
        'offer_card_badge' => $offer_card_badge,

        'top_announcement_enabled' => $top_announcement_enabled,
        'top_announcement_text' => $top_announcement_text,
        'top_announcement_link' => $top_announcement_link,

        'marquee_items' => $marqueeLines
    ];

    saveSiteData($siteData);
    $_SESSION['flash_success'] = 'Hero banner & offer settings updated successfully!';
    header('Location: banner.php');
    exit;
}

// Prepare values for display
$heroMode = $banner['hero_mode'] ?? 'offer';
$offerActive = !empty($banner['offer_active']);
$offerBadge = $banner['offer_badge'] ?? '🔥 SPECIAL FESTIVE OFFER • FLAT 25% OFF';
$offerDiscount = $banner['offer_discount_text'] ?? 'FLAT 25% OFF';
$offerHeadline = $banner['offer_headline'] ?? 'Special Wholesale Offer on Bulk Perfume Bottles & Luxury Caps';
$offerSubheadline = $banner['offer_subheadline'] ?? 'Avail an exclusive 25% discount on bulk orders of 100+ flacons. Complimentary UV silk screen printing and custom discovery sample kits included this season.';
$offerCoupon = $banner['offer_coupon_code'] ?? 'PANNA25';
$offerCountdownEnabled = !empty($banner['offer_countdown_enabled']);
$offerEndDate = $banner['offer_end_date'] ?? date('Y-m-d H:i:s', strtotime('+14 days'));
$offerCountdownLabel = $banner['offer_countdown_label'] ?? 'Special Offer Expires In:';
$offerPerksString = implode("\n", $banner['offer_perks'] ?? [
    'Complimentary Custom UV Silk Printing on 100+ pcs',
    'Zero Mould Setup Fees on Bulk Orders',
    'Free Perfume Discovery Sample Kit with Every Inquiry',
    'Fast 48-Hour Dispatch Across India'
]);
$offerBtn1Text = $banner['offer_button1_text'] ?? 'Claim Offer on WhatsApp';
$offerBtn1Link = $banner['offer_button1_link'] ?? '';
$offerBtn2Text = $banner['offer_button2_text'] ?? 'Explore Offer Catalog';
$offerBtn2Link = $banner['offer_button2_link'] ?? '#products-section';
$offerBgImage = $banner['offer_background_image'] ?? ($banner['background_image'] ?? 'assets/images/hero-perfume-bg.jpg');
$offerFeaturedImage = $banner['offer_featured_image'] ?? 'assets/images/products/100ml-victor.jpg';

$offerCardEnabled = isset($banner['offer_card_enabled']) ? !empty($banner['offer_card_enabled']) : true;
$offerCardTitle = $banner['offer_card_title'] ?? '100 ML Victor Flacon + Zamac Cap Set';
$offerCardSubtitle = $banner['offer_card_subtitle'] ?? 'Architectural Square Glass & Magnetic Cap';
$offerCardPrice = $banner['offer_card_price'] ?? '63.75';
$offerCardOrigPrice = $banner['offer_card_original_price'] ?? '85.00';
$offerCardMoq = $banner['offer_card_moq'] ?? '50 pcs';
$offerCardBadge = $banner['offer_card_badge'] ?? 'SAVE 25%';

$topAnnounceEnabled = !empty($banner['top_announcement_enabled']);
$topAnnounceText = $banner['top_announcement_text'] ?? '⚡ Festive Offer: Use coupon code PANNA25 for Flat 25% OFF + Free Silk Printing on 100+ bottles!';
$topAnnounceLink = $banner['top_announcement_link'] ?? '#products-section';

// Standard showcase
$stdTagline = $banner['tagline'] ?? '✦ Premium Perfumery Packaging';
$stdHeadline = $banner['headline'] ?? 'Exquisite Glass Bottles & Designer Closures';
$stdSubheadline = $banner['subheadline'] ?? 'Empowering prestige perfume brands with luxury super-flint glass bottles, heavy Zamac magnetic caps, and high-atomization fine mist pumps.';
$stdBtn1Text = $banner['button1_text'] ?? 'Explore Products';
$stdBtn1Link = $banner['button1_link'] ?? '#products-section';
$stdBtn2Text = $banner['button2_text'] ?? 'Quick WhatsApp Quote';
$stdBtn2Link = $banner['button2_link'] ?? '';
$stdBgImage = $banner['background_image'] ?? 'assets/images/hero-perfume-bg.jpg';

$marqueeString = implode("\n", $banner['marquee_items'] ?? []);

// Format date for datetime-local input
$offerEndDateInput = date('Y-m-d\TH:i', strtotime($offerEndDate));
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-xl sm:text-2xl font-bold text-neutral-900 flex items-center gap-2">
      <span>Hero Banner & Offer Settings</span>
      <?php if ($offerActive): ?>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
          <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
          Offer Active
        </span>
      <?php else: ?>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-neutral-200 text-neutral-600">
          Offer Inactive
        </span>
      <?php endif; ?>
    </h1>
    <p class="text-xs text-neutral-500 mt-1">Configure your homepage hero banner, launch promotional offer campaigns, countdown timers, promo codes, and marquee tickers.</p>
  </div>
  <div class="flex items-center gap-2">
    <a href="../index.php" target="_blank" class="bg-neutral-900 hover:bg-black text-white text-xs font-semibold px-4 py-2.5 rounded-full inline-flex items-center gap-1.5 transition shadow-sm">
      <span>Preview on Homepage</span>
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
    </a>
  </div>
</div>

<form method="POST" action="banner.php" enctype="multipart/form-data" class="space-y-8 pb-16">

  <!-- ======================================================== -->
  <!-- HERO BANNER DISPLAY MODE & OFFER MASTER SWITCH           -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-100 pb-4">
      <div>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Hero Display Mode & Offer Switch</h2>
        <p class="text-xs text-neutral-400 mt-0.5">Choose how the hero banner is presented to visitors on the homepage.</p>
      </div>

      <!-- Quick Active Toggle -->
      <div class="flex items-center gap-3 bg-neutral-50 p-2 rounded-xl border border-neutral-200">
        <label for="offer_active_toggle" class="text-xs font-bold text-neutral-800 cursor-pointer select-none">
          Promotional Offer Status:
        </label>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" id="offer_active_toggle" name="offer_active" value="1" <?php echo $offerActive ? 'checked' : ''; ?> class="sr-only peer">
          <div class="w-11 h-6 bg-neutral-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
          <span class="ml-2 text-xs font-extrabold <?php echo $offerActive ? 'text-amber-700' : 'text-neutral-400'; ?>">
            <?php echo $offerActive ? 'LIVE' : 'OFF'; ?>
          </span>
        </label>
      </div>
    </div>

    <!-- Mode Selector Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      
      <!-- Option 1: Hero Offer Banner -->
      <label class="relative border-2 rounded-xl p-4 cursor-pointer transition flex flex-col justify-between <?php echo $heroMode === 'offer' ? 'border-amber-500 bg-amber-50/40 ring-1 ring-amber-500' : 'border-neutral-200 hover:border-neutral-300 bg-white'; ?>">
        <div class="flex items-start gap-3">
          <input type="radio" name="hero_mode" value="offer" <?php echo $heroMode === 'offer' ? 'checked' : ''; ?> class="mt-1 text-amber-600 focus:ring-amber-500">
          <div>
            <div class="flex items-center gap-1.5">
              <span class="text-xs font-bold text-neutral-900">Offer Banner Only</span>
              <span class="px-1.5 py-0.5 bg-amber-500 text-white text-[10px] font-bold rounded">High Conversion</span>
            </div>
            <p class="text-[11px] text-neutral-500 mt-1 leading-relaxed">
              Showcases your active promotional campaign with countdown timer, coupon code, perks checklist, and deal spotlight card.
            </p>
          </div>
        </div>
      </label>

      <!-- Option 2: Hero Carousel -->
      <label class="relative border-2 rounded-xl p-4 cursor-pointer transition flex flex-col justify-between <?php echo $heroMode === 'carousel' ? 'border-amber-500 bg-amber-50/40 ring-1 ring-amber-500' : 'border-neutral-200 hover:border-neutral-300 bg-white'; ?>">
        <div class="flex items-start gap-3">
          <input type="radio" name="hero_mode" value="carousel" <?php echo $heroMode === 'carousel' ? 'checked' : ''; ?> class="mt-1 text-amber-600 focus:ring-amber-500">
          <div>
            <div class="flex items-center gap-1.5">
              <span class="text-xs font-bold text-neutral-900">Hero Slider / Carousel</span>
              <span class="px-1.5 py-0.5 bg-neutral-900 text-white text-[10px] font-bold rounded">Dual Showcase</span>
            </div>
            <p class="text-[11px] text-neutral-500 mt-1 leading-relaxed">
              Rotates smoothly between your Classic Brand Showcase and Special Offer Banner with interactive dots and arrows.
            </p>
          </div>
        </div>
      </label>

      <!-- Option 3: Standard Showcase -->
      <label class="relative border-2 rounded-xl p-4 cursor-pointer transition flex flex-col justify-between <?php echo $heroMode === 'standard' ? 'border-amber-500 bg-amber-50/40 ring-1 ring-amber-500' : 'border-neutral-200 hover:border-neutral-300 bg-white'; ?>">
        <div class="flex items-start gap-3">
          <input type="radio" name="hero_mode" value="standard" <?php echo $heroMode === 'standard' ? 'checked' : ''; ?> class="mt-1 text-amber-600 focus:ring-amber-500">
          <div>
            <div class="flex items-center gap-1.5">
              <span class="text-xs font-bold text-neutral-900">Standard Brand Showcase</span>
            </div>
            <p class="text-[11px] text-neutral-500 mt-1 leading-relaxed">
              Displays the classic luxury perfume packaging showcase without promotional discounts or countdown timer.
            </p>
          </div>
        </div>
      </label>

    </div>
  </div>


  <!-- ======================================================== -->
  <!-- SECTION 1: HERO OFFER BANNER (PRIMARY PROMOTION)         -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-6">
    <div class="border-b border-neutral-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
      <div>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900 flex items-center gap-2">
          <span>🎁 Hero Offer Banner Configuration</span>
          <span class="text-[10px] px-2 py-0.5 rounded-full bg-gold/15 text-gold font-bold">Offer Mode</span>
        </h2>
        <p class="text-xs text-neutral-400 mt-0.5">Customize offer headlines, discount percentage, promo code, countdown timer, and deal spotlight.</p>
      </div>
      <div class="text-[11px] text-neutral-500 font-medium">
        Visible when mode is set to <strong>Offer Banner</strong> or <strong>Hero Slider</strong>.
      </div>
    </div>

    <!-- Live Preview Box -->
    <div>
      <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-2">Live Offer Banner Preview</label>
      <div class="relative w-full min-h-[220px] bg-neutral-950 rounded-xl overflow-hidden border border-neutral-300 p-6 flex flex-col justify-between text-white shadow-inner">
        <!-- Background Preview -->
        <img src="../<?php echo htmlspecialchars($offerBgImage); ?>" alt="Offer Background Preview" class="absolute inset-0 w-full h-full object-cover opacity-25">
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950 via-neutral-900/90 to-transparent"></div>
        
        <div class="relative z-10 max-w-xl space-y-2">
          <div class="flex items-center gap-2 flex-wrap">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-neutral-950 uppercase tracking-wider">
              <?php echo htmlspecialchars($offerDiscount); ?>
            </span>
            <span class="text-[11px] text-amber-300 font-bold uppercase tracking-widest">
              <?php echo htmlspecialchars($offerBadge); ?>
            </span>
          </div>

          <h3 class="text-lg sm:text-xl font-extrabold font-serif leading-tight text-white">
            <?php echo htmlspecialchars($offerHeadline); ?>
          </h3>

          <p class="text-xs text-neutral-300 line-clamp-2">
            <?php echo htmlspecialchars($offerSubheadline); ?>
          </p>

          <?php if (!empty($offerCoupon)): ?>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-black/60 border border-amber-500/40 text-xs font-mono">
              <span class="text-amber-400 font-bold">CODE:</span>
              <span class="text-white font-black tracking-widest"><?php echo htmlspecialchars($offerCoupon); ?></span>
            </div>
          <?php endif; ?>
        </div>

        <div class="relative z-10 mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-neutral-400">
          <span>Background: <?php echo htmlspecialchars(basename($offerBgImage)); ?></span>
          <span class="text-amber-400 font-semibold">Ready for WhatsApp Quote</span>
        </div>
      </div>
    </div>

    <!-- Image Upload: Offer Background -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Offer Banner Background Image</label>
        <input 
          type="file" 
          name="offer_background_image_file" 
          accept="image/*" 
          class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
        >
        <p class="text-[11px] text-neutral-400 mt-1">Recommended: 1920x800px luxury dark perfume flacon photo (JPG, PNG, WEBP).</p>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Current Background File</label>
        <div class="flex items-center gap-3 p-2 bg-neutral-50 rounded-lg border border-neutral-200">
          <img src="../<?php echo htmlspecialchars($offerBgImage); ?>" class="w-12 h-10 object-cover rounded border border-neutral-300">
          <span class="text-xs font-mono text-neutral-700 truncate"><?php echo htmlspecialchars($offerBgImage); ?></span>
        </div>
      </div>
    </div>

    <!-- Offer Copy Fields -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
      
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Offer Top Tagline / Badge</label>
        <input 
          type="text" 
          name="offer_badge" 
          value="<?php echo htmlspecialchars($offerBadge); ?>" 
          placeholder="e.g. 🔥 SPECIAL FESTIVE OFFER • FLAT 25% OFF"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Discount Highlight Pill</label>
        <input 
          type="text" 
          name="offer_discount_text" 
          value="<?php echo htmlspecialchars($offerDiscount); ?>" 
          placeholder="e.g. FLAT 25% OFF or SAVE UP TO 30%"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
        >
      </div>

      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Main Offer Headline *</label>
        <input 
          type="text" 
          name="offer_headline" 
          required 
          value="<?php echo htmlspecialchars($offerHeadline); ?>" 
          placeholder="e.g. Special Wholesale Offer on Bulk Perfume Bottles & Luxury Caps"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
        >
      </div>

      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Offer Subheadline / Promotional Terms</label>
        <textarea 
          name="offer_subheadline" 
          rows="3" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
          placeholder="Describe your offer, minimum quantity, and what sets it apart..."
        ><?php echo htmlspecialchars($offerSubheadline); ?></textarea>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Coupon / Promo Code</label>
        <input 
          type="text" 
          name="offer_coupon_code" 
          value="<?php echo htmlspecialchars($offerCoupon); ?>" 
          placeholder="e.g. PANNA25 (Customer can click to copy)"
          class="w-full px-3.5 py-2.5 text-xs font-mono font-bold uppercase rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
        <p class="text-[11px] text-neutral-400 mt-1">Visitors can 1-click copy this code and claim it directly on WhatsApp.</p>
      </div>

      <!-- Countdown Settings -->
      <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200">
        <div class="flex items-center justify-between mb-2">
          <label class="text-xs font-bold text-neutral-900 uppercase tracking-wider flex items-center gap-1.5">
            <span>⏱️ Live Countdown Timer</span>
          </label>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="offer_countdown_enabled" value="1" <?php echo $offerCountdownEnabled ? 'checked' : ''; ?> class="sr-only peer">
            <div class="w-9 h-5 bg-neutral-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-600"></div>
          </label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
          <div>
            <label class="block text-[11px] font-semibold text-neutral-700 mb-0.5">Expiry Date & Time</label>
            <input 
              type="datetime-local" 
              name="offer_end_date" 
              value="<?php echo htmlspecialchars($offerEndDateInput); ?>" 
              class="w-full px-2.5 py-1.5 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
            >
          </div>
          <div>
            <label class="block text-[11px] font-semibold text-neutral-700 mb-0.5">Countdown Label</label>
            <input 
              type="text" 
              name="offer_countdown_label" 
              value="<?php echo htmlspecialchars($offerCountdownLabel); ?>" 
              placeholder="e.g. Special Offer Expires In:"
              class="w-full px-2.5 py-1.5 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
            >
          </div>
        </div>
      </div>

      <!-- Offer Bullet Perks -->
      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Key Offer Perks & Highlights (One perk per line)</label>
        <textarea 
          name="offer_perks" 
          rows="4" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-sans"
          placeholder="Complimentary Custom UV Silk Printing on 100+ pcs&#10;Zero Mould Setup Fees on Bulk Orders&#10;Free Perfume Discovery Sample Kit with Every Inquiry&#10;Fast 48-Hour Dispatch Across India"
        ><?php echo htmlspecialchars($offerPerksString); ?></textarea>
        <p class="text-[11px] text-neutral-400 mt-1">Each line is rendered with a luxury gold checkmark (✓) under the offer headline.</p>
      </div>

      <!-- Action Buttons -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Primary CTA Button Text</label>
        <input 
          type="text" 
          name="offer_button1_text" 
          value="<?php echo htmlspecialchars($offerBtn1Text); ?>" 
          placeholder="e.g. Claim Offer on WhatsApp"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Primary CTA Button Link (Leave blank for WhatsApp)</label>
        <input 
          type="text" 
          name="offer_button1_link" 
          value="<?php echo htmlspecialchars($offerBtn1Link); ?>" 
          placeholder="Leave blank to auto-generate WhatsApp message with Promo Code"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Secondary CTA Button Text</label>
        <input 
          type="text" 
          name="offer_button2_text" 
          value="<?php echo htmlspecialchars($offerBtn2Text); ?>" 
          placeholder="e.g. Explore Offer Catalog"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Secondary CTA Button Link</label>
        <input 
          type="text" 
          name="offer_button2_link" 
          value="<?php echo htmlspecialchars($offerBtn2Link); ?>" 
          placeholder="e.g. #products-section"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

    </div>

    <!-- Spotlight Deal Card Settings (Right Side of Offer Banner) -->
    <div class="mt-6 p-5 bg-neutral-50 rounded-xl border border-neutral-200 space-y-4">
      <div class="flex items-center justify-between border-b border-neutral-200 pb-3">
        <div>
          <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 flex items-center gap-2">
            <span>✨ Featured Deal Spotlight Card (Desktop Showcase)</span>
          </h3>
          <p class="text-[11px] text-neutral-400 mt-0.5">Displays a floating glassmorphic product card on the right side of the hero offer banner.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" name="offer_card_enabled" value="1" <?php echo $offerCardEnabled ? 'checked' : ''; ?> class="sr-only peer">
          <div class="w-9 h-5 bg-neutral-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gold"></div>
        </label>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Deal Title</label>
          <input 
            type="text" 
            name="offer_card_title" 
            value="<?php echo htmlspecialchars($offerCardTitle); ?>" 
            placeholder="e.g. 100 ML Victor Flacon + Zamac Cap Set"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
          >
        </div>

        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Deal Subtitle</label>
          <input 
            type="text" 
            name="offer_card_subtitle" 
            value="<?php echo htmlspecialchars($offerCardSubtitle); ?>" 
            placeholder="e.g. Architectural Square Glass & Magnetic Cap"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
          >
        </div>

        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Deal Badge</label>
          <input 
            type="text" 
            name="offer_card_badge" 
            value="<?php echo htmlspecialchars($offerCardBadge); ?>" 
            placeholder="e.g. SAVE 25%"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
          >
        </div>

        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Offer Price (₹)</label>
          <input 
            type="text" 
            name="offer_card_price" 
            value="<?php echo htmlspecialchars($offerCardPrice); ?>" 
            placeholder="e.g. 63.75"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white font-bold text-amber-700"
          >
        </div>

        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Original Price (₹)</label>
          <input 
            type="text" 
            name="offer_card_original_price" 
            value="<?php echo htmlspecialchars($offerCardOrigPrice); ?>" 
            placeholder="e.g. 85.00"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white line-through text-neutral-400"
          >
        </div>

        <div>
          <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Minimum Order Qty (MOQ)</label>
          <input 
            type="text" 
            name="offer_card_moq" 
            value="<?php echo htmlspecialchars($offerCardMoq); ?>" 
            placeholder="e.g. 50 pcs"
            class="w-full px-3 py-2 text-xs rounded border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white"
          >
        </div>

        <div class="sm:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
          <div>
            <label class="block text-[11px] font-semibold uppercase tracking-wider text-neutral-700 mb-1">Upload Featured Deal Product Image</label>
            <input 
              type="file" 
              name="offer_featured_image_file" 
              accept="image/*" 
              class="block w-full text-xs text-neutral-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-200 file:text-neutral-700 hover:file:bg-neutral-300"
            >
          </div>
          <div class="flex items-center gap-3">
            <img src="../<?php echo htmlspecialchars($offerFeaturedImage); ?>" class="w-12 h-12 object-contain bg-white rounded border border-neutral-300 p-1">
            <span class="text-xs text-neutral-600 font-mono truncate"><?php echo htmlspecialchars($offerFeaturedImage); ?></span>
          </div>
        </div>

      </div>
    </div>

  </div>


  <!-- ======================================================== -->
  <!-- SECTION 2: TOP ANNOUNCEMENT TICKER BAR                  -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
    <div class="flex items-center justify-between border-b border-neutral-100 pb-4">
      <div>
        <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Top Header Announcement Bar</h2>
        <p class="text-xs text-neutral-400 mt-0.5">Sleek top bar displayed above the website navigation on all pages.</p>
      </div>
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" name="top_announcement_enabled" value="1" <?php echo $topAnnounceEnabled ? 'checked' : ''; ?> class="sr-only peer">
        <div class="w-9 h-5 bg-neutral-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gold"></div>
      </label>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Announcement Copy</label>
        <input 
          type="text" 
          name="top_announcement_text" 
          value="<?php echo htmlspecialchars($topAnnounceText); ?>" 
          placeholder="e.g. ⚡ Festive Offer: Use coupon code PANNA25 for Flat 25% OFF + Free Silk Printing on 100+ bottles!"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Destination Link</label>
        <input 
          type="text" 
          name="top_announcement_link" 
          value="<?php echo htmlspecialchars($topAnnounceLink); ?>" 
          placeholder="e.g. #products-section or WhatsApp"
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>
    </div>
  </div>


  <!-- ======================================================== -->
  <!-- SECTION 3: STANDARD BRAND SHOWCASE (DEFAULT SLIDE)      -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-6">
    <div class="border-b border-neutral-100 pb-4">
      <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Classic Brand Showcase Elements</h2>
      <p class="text-xs text-neutral-400 mt-0.5">Used as the primary hero in Standard Mode, or as Slide 1 when Hero Slider mode is enabled.</p>
    </div>

    <!-- Upload Standard Background -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Upload Showcase Background Image</label>
        <input 
          type="file" 
          name="banner_image_file" 
          accept="image/*" 
          class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200"
        >
      </div>
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Current Background File</label>
        <div class="flex items-center gap-3 p-2 bg-neutral-50 rounded-lg border border-neutral-200">
          <img src="../<?php echo htmlspecialchars($stdBgImage); ?>" class="w-12 h-10 object-cover rounded border border-neutral-300">
          <span class="text-xs font-mono text-neutral-700 truncate"><?php echo htmlspecialchars($stdBgImage); ?></span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Small Top Tagline</label>
        <input 
          type="text" 
          name="tagline" 
          value="<?php echo htmlspecialchars($stdTagline); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Main Headline</label>
        <input 
          type="text" 
          name="headline" 
          value="<?php echo htmlspecialchars($stdHeadline); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-bold"
        >
      </div>

      <div class="sm:col-span-2">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Sub-Headline / Description</label>
        <textarea 
          name="subheadline" 
          rows="3" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        ><?php echo htmlspecialchars($stdSubheadline); ?></textarea>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Button 1 Text</label>
        <input 
          type="text" 
          name="button1_text" 
          value="<?php echo htmlspecialchars($stdBtn1Text); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Button 1 Link</label>
        <input 
          type="text" 
          name="button1_link" 
          value="<?php echo htmlspecialchars($stdBtn1Link); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Button 2 Text</label>
        <input 
          type="text" 
          name="button2_text" 
          value="<?php echo htmlspecialchars($stdBtn2Text); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Button 2 Link</label>
        <input 
          type="text" 
          name="button2_link" 
          value="<?php echo htmlspecialchars($stdBtn2Link); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>
    </div>
  </div>


  <!-- ======================================================== -->
  <!-- SECTION 4: INFINITE MARQUEE TICKER                      -->
  <!-- ======================================================== -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
    <div class="border-b border-neutral-100 pb-4">
      <h2 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Infinite Marquee Trust Ticker</h2>
      <p class="text-xs text-neutral-400 mt-0.5">Edit scrolling trust points separated by star icons (✦) on the black ticker banner.</p>
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


  <!-- Sticky Bottom Save Bar -->
  <div class="sticky bottom-4 z-20 bg-neutral-900/90 backdrop-blur-md text-white p-4 rounded-2xl border border-neutral-700 shadow-2xl flex items-center justify-between gap-4">
    <div class="hidden sm:block">
      <span class="text-xs font-bold text-white block">Hero Banner Configuration Ready</span>
      <span class="text-[11px] text-neutral-400">Mode: <strong><?php echo ucfirst($heroMode); ?></strong> • Offer: <strong><?php echo $offerActive ? 'Active' : 'Inactive'; ?></strong></span>
    </div>
    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
      <a href="../index.php" target="_blank" class="text-xs font-semibold text-neutral-300 hover:text-white px-4 py-2.5">
        Preview Store &rarr;
      </a>
      <button 
        type="submit" 
        class="bg-gold hover:bg-[#b08b42] text-white px-8 py-3 rounded-full text-xs font-bold uppercase tracking-wider transition shadow-lg flex items-center gap-2"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span>Save Banner & Offer Settings</span>
      </button>
    </div>
  </div>

</form>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
