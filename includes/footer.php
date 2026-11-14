<?php
/**
 * Panna Heera Perfumery - Footer Partial
 */
?>
  <!-- Modals (Cart Drawer, Option Selector, Search) -->
  <?php include_once __DIR__ . '/modals.php'; ?>

  <!-- Floating WhatsApp Action Button -->
  <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-float" title="Instant WhatsApp Support & Orders">
    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
  </a>

  <!-- Scroll-to-Top Floating Button -->
  <button id="backToTopBtn" class="back-to-top" title="Back to top">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
    </svg>
  </button>

  <!-- Main Website Footer -->
  <footer class="bg-[#111111] text-neutral-300 pt-16 pb-12 border-t border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Top Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-neutral-800">
        
        <!-- Brand Info (2 cols) -->
        <div class="lg:col-span-2 space-y-4">
          <div class="flex items-center gap-3">
            <div class="h-16 w-12 bg-neutral-900 rounded-md overflow-hidden p-0.5 border border-neutral-700 shadow flex items-center justify-center flex-shrink-0">
              <img src="assets/images/logo-dark-bg.jpg" alt="Panna Heera Perfumes" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
              <span class="text-xl font-black tracking-widest text-white leading-none">
                <?php echo BRAND_FIRST_NAME; ?>
              </span>
              <span class="text-xs font-bold tracking-[0.35em] text-gold uppercase mt-1">
                PERFUMES
              </span>
            </div>
          </div>
          <p class="text-xs sm:text-sm text-neutral-400 max-w-sm leading-relaxed">
            Your trusted wholesale manufacturer and distributor of pure, 100% alcohol-free fragrance oils and fine perfumery compounds. Stocking over 1,040 varieties in 1 KG and 100 GM wholesale packs with pan-India dispatch.
          </p>
          <div class="pt-2 flex items-center space-x-3">
            <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-[#25D366] text-white flex items-center justify-center transition">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            </a>
            <a href="tel:<?php echo PHONE_RAW; ?>" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-gold text-white flex items-center justify-center transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </a>
            <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-gold text-white flex items-center justify-center transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Categories -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-4">Top Categories</h4>
          <ul class="space-y-2.5 text-xs">
            <?php foreach (array_slice($categories, 0, 6) as $c): 
              $fUrl = 'products.php?category=' . urlencode($c['id']);
            ?>
              <li>
                <a href="<?php echo $fUrl; ?>" class="hover:text-gold transition flex items-center justify-between">
                  <span><?php echo htmlspecialchars($c['title']); ?></span>
                  <span class="text-[10px] text-neutral-400 font-bold font-mono"><?php echo $c['count']; ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Col 3: B2B Services -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-4">B2B Solutions</h4>
          <ul class="space-y-2.5 text-xs">
            <li><a href="fragrances.php" class="text-amber-400 font-bold hover:underline">Fragrance Oils (1,040 Catalog)</a></li>
            <li><a href="contact.php" class="hover:text-gold transition">Request Wholesale Pricing</a></li>
            <li><a href="about.php" class="hover:text-gold transition">Our Scent Heritage</a></li>
            <li><a href="about.php#capabilities" class="hover:text-gold transition">100% Pure & Alcohol-Free</a></li>
            <li><a href="contact.php" class="hover:text-gold transition">100 GM Production Lots</a></li>
            <li><a href="contact.php" class="hover:text-gold transition">1 KG Wholesale Lots</a></li>
            <li><a href="admin/index.php" class="hover:text-gold transition">Admin Panel Portal</a></li>
          </ul>
        </div>

        <!-- Col 4: Contact & Warehouse -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-4">Contact & Inquiries</h4>
          <ul class="space-y-2.5 text-xs text-neutral-400">
            <li class="flex items-start gap-2">
              <span class="text-gold font-bold">📍</span>
              <span><?php echo !empty($siteSettings['address']) ? htmlspecialchars($siteSettings['address']) : COMPANY_ADDRESS; ?></span>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-gold font-bold">📞</span>
              <a href="tel:<?php echo PHONE_RAW; ?>" class="hover:text-white transition"><?php echo PHONE_NUMBER; ?></a>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-[#25D366] fill-current flex-shrink-0" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
              <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" class="text-[#25D366] hover:underline">WhatsApp Direct Support</a>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-gold font-bold">✉️</span>
              <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="hover:text-white transition"><?php echo CONTACT_EMAIL; ?></a>
            </li>
            <li class="text-[11px] text-neutral-500 pt-1">
              <?php echo BUSINESS_HOURS; ?>
            </li>
          </ul>
        </div>

      </div>

      <!-- Legal Trademark & Benchmark Disclaimer (Protects against any IP/Copyright/Trademark issues) -->
      <div class="pt-8 pb-4 text-[11px] text-neutral-500 border-t border-neutral-800/80 space-y-2">
        <p class="font-bold text-neutral-400 uppercase tracking-wider text-[10px]">Legal Notice & Olfactory Benchmark Disclaimer:</p>
        <p class="leading-relaxed text-neutral-400">
          All brand names, trademarks, trade names, and registered logos referenced across this website and catalog belong strictly to their respective registered trademark owners. Panna Heera Perfumery is an independent manufacturer and distributor of proprietary, 100% alcohol-free concentrated fragrance oils and compounds. References to designer houses, commercial perfumes, and celebrity scents are made strictly for descriptive and comparative purposes to guide B2B clients and perfumers regarding scent profiles, olfactory families, and aromatic character. Panna Heera Perfumery has no association, authorization, sponsorship, or endorsement from any of the trademark holders.
        </p>
      </div>

      <!-- Bottom Disclaimer & Copyright -->
      <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500 border-t border-neutral-800/50">
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. 100% Proprietary Formulations.</p>
        <div class="flex items-center space-x-6 text-[11px]">
          <span>✦ 100% Alcohol-Free Pure Extrait</span>
          <span>✦ IFRA Compliant Formulations</span>
          <span>✦ Secure Pan-India Dispatch</span>
        </div>
      </div>

    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/js/products-data.js?v=4.0"></script>
  <script src="assets/js/fragrance-data.js?v=4.0"></script>
  <script src="assets/js/main.js?v=4.0"></script>
</body>
</html>
