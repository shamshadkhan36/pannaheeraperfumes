<?php
/**
 * Classic Brand Showcase Hero Slide
 */
$stdBg = !empty($banner['background_image']) ? $banner['background_image'] : 'assets/images/hero-perfume-bg.jpg';
?>
<section class="hero-banner relative flex items-end sm:items-center" style="background-image: url('<?php echo htmlspecialchars($stdBg); ?>');">
  <!-- Subtle gradient for text contrast -->
  <div class="hero-overlay"></div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 w-full">
    <div class="max-w-xl text-white">
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md text-gold border border-white/20 uppercase tracking-widest mb-4">
        <?php echo htmlspecialchars($banner['tagline'] ?? '✦ Premium Perfumery Packaging'); ?>
      </span>
      <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight font-serif">
        <?php echo htmlspecialchars($banner['headline'] ?? 'Exquisite Glass Bottles & Designer Closures'); ?>
      </h1>
      <p class="mt-3 sm:mt-4 text-sm sm:text-base text-neutral-200 leading-relaxed font-normal">
        <?php echo htmlspecialchars($banner['subheadline'] ?? 'Empowering prestige perfume brands with luxury super-flint glass bottles, heavy Zamac magnetic caps, and high-atomization fine mist pumps.'); ?>
      </p>
      
      <div class="mt-6 sm:mt-8 flex flex-wrap gap-4">
        <a href="<?php echo htmlspecialchars($banner['button1_link'] ?? '#products-section'); ?>" class="bg-white text-neutral-900 hover:bg-neutral-100 px-7 py-3.5 rounded-full text-sm font-bold tracking-wide transition shadow-lg inline-flex items-center gap-2">
          <?php echo htmlspecialchars($banner['button1_text'] ?? 'Explore Products'); ?>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
        </a>
        <a href="<?php echo htmlspecialchars(!empty($banner['button2_link']) ? $banner['button2_link'] : getWhatsAppLink()); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-7 py-3.5 rounded-full text-sm font-bold tracking-wide transition shadow-lg inline-flex items-center gap-2">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
          <span><?php echo htmlspecialchars($banner['button2_text'] ?? 'Quick WhatsApp Quote'); ?></span>
        </a>
      </div>
    </div>
  </div>
</section>
