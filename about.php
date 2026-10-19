<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$pageTitle = 'About Us';
include_once __DIR__ . '/includes/header.php';
?>

<!-- Page Header -->
<div class="bg-neutral-900 text-white py-14 border-b border-neutral-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <span class="text-gold text-xs font-bold tracking-widest uppercase block mb-2">Our Heritage & Expertise</span>
    <h1 class="text-3xl sm:text-5xl font-extrabold font-serif">Artisans of Luxury Perfumery Packaging</h1>
    <p class="mt-4 text-neutral-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
      At Panna Heera Perfumery, we believe a fragrance's journey begins long before the first spray. The weight of the glass, the magnetic snap of the cap, and the velvet mist of the atomiser define prestige.
    </p>
  </div>
</div>

<!-- Story Section -->
<section class="py-16 sm:py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div class="space-y-6">
        <span class="text-xs font-bold uppercase tracking-widest text-gold">The Panna Heera Standard</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 leading-tight">
          Pioneering Glass Excellence & Custom Closures for Brand Visionaries
        </h2>
        <p class="text-sm text-neutral-600 leading-relaxed">
          Founded with a commitment to uncompromised glasscraft, Panna Heera Perfumery serves independent niche houses, national retail brands, and luxury private label ventures. We bridge the gap between world-class European packaging aesthetics and responsive local supply chains.
        </p>
        <p class="text-sm text-neutral-600 leading-relaxed">
          Whether you are launching your debut 50-piece capsule collection or scaling up to 500,000 unit production runs, our team coordinates glass blow tooling, electroplated Zamac alloy casting, leak-proof pump crimping, and rigid gift box manufacturing.
        </p>
        <div class="pt-4 flex flex-wrap gap-4">
          <a href="<?php echo getWhatsAppLink('Hi Panna Heera, I want to discuss a custom packaging project for my brand.'); ?>" target="_blank" class="bg-black text-white hover:bg-neutral-800 px-6 py-3 rounded-full text-xs font-bold tracking-wide transition">
            Speak With Our Creative Director
          </a>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="p-6 bg-neutral-50 rounded-2xl border border-neutral-100 space-y-2">
          <span class="text-3xl font-extrabold text-neutral-900">500+</span>
          <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-700">Fragrance Brands Served</h4>
          <p class="text-xs text-neutral-500">From boutique niche attar houses to pan-India luxury brands.</p>
        </div>
        <div class="p-6 bg-neutral-50 rounded-2xl border border-neutral-100 space-y-2">
          <span class="text-3xl font-extrabold text-gold">99.8%</span>
          <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-700">Zero-Leakage Rate</h4>
          <p class="text-xs text-neutral-500">Rigorous vacuum & pressure testing on all pump crimps.</p>
        </div>
        <div class="p-6 bg-neutral-50 rounded-2xl border border-neutral-100 space-y-2">
          <span class="text-3xl font-extrabold text-gold">100%</span>
          <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-700">Super Flint Glass</h4>
          <p class="text-xs text-neutral-500">High optical brilliance, thick crystal bases, no greenish tint.</p>
        </div>
        <div class="p-6 bg-neutral-50 rounded-2xl border border-neutral-100 space-y-2">
          <span class="text-3xl font-extrabold text-neutral-900">18 Days</span>
          <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-700">Rapid Mold Prototyping</h4>
          <p class="text-xs text-neutral-500">CAD concept to functional sample bottle in record turnaround.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Manufacturing & Custom Moulds Anchors -->
<section id="manufacturing" class="py-16 bg-[#fafafa] border-t border-neutral-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <span class="text-xs font-bold uppercase tracking-widest text-gold block mb-1">Capabilities & Services</span>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900">End-to-End Packaging Engineering</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- 1. Custom Moulds -->
      <div id="custom-moulds" class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-3">
        <div class="w-12 h-12 rounded-xl bg-neutral-100 flex items-center justify-center text-xl text-neutral-900 font-bold">
          01
        </div>
        <h3 class="text-base font-bold text-neutral-900">Custom Bottle Moulding</h3>
        <p class="text-xs text-neutral-600 leading-relaxed">
          Create signature bottle profiles proprietary to your label. We provide 3D CAD modeling, 3D printed resin mockups, sample pilot moulds, and automated multi-cavity IS machine production.
        </p>
        <ul class="text-xs text-neutral-500 space-y-1.5 pt-2">
          <li>✓ Debossed & embossed base branding</li>
          <li>✓ Asymmetrical & geometric shapes</li>
          <li>✓ FEA 15mm crimp and 18/415 screw finishes</li>
        </ul>
      </div>

      <!-- 2. Surface Decoration -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-3">
        <div class="w-12 h-12 rounded-xl bg-neutral-100 flex items-center justify-center text-xl text-gold font-bold">
          02
        </div>
        <h3 class="text-base font-bold text-neutral-900">Surface Finishing & Printing</h3>
        <p class="text-xs text-neutral-600 leading-relaxed">
          Transform clear glass into exquisite tactile works of art with multi-pass screen printing, genuine gold foil hot stamping, gradient frosted coatings, and soft-touch rubberized lacquers.
        </p>
        <ul class="text-xs text-neutral-500 space-y-1.5 pt-2">
          <li>✓ 24K real gold & silver hot stamping</li>
          <li>✓ Matte, glossy, and iridescent color spraying</li>
          <li>✓ Alcohol & scratch-proof UV cured inks</li>
        </ul>
      </div>

      <!-- 3. Turnkey Assembly & QC -->
      <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-3">
        <div class="w-12 h-12 rounded-xl bg-neutral-100 flex items-center justify-center text-xl text-neutral-900 font-bold">
          03
        </div>
        <h3 class="text-base font-bold text-neutral-900">Caps, Pumps & Assembly</h3>
        <p class="text-xs text-neutral-600 leading-relaxed">
          Complete sets tested for zero capillary leakage. Magnetic Zamac caps, laser engraved collars, and customized dip tubes cut to exact millimetric depths to ensure every drop is atomized.
        </p>
        <ul class="text-xs text-neutral-500 space-y-1.5 pt-2">
          <li>✓ High dose fine mist sprayers (0.12ml)</li>
          <li>✓ Neodymium magnetic closures with solid snap</li>
          <li>✓ Rigid presentation boxes & EVA foam inserts</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
