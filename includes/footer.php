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
      <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/>
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
            Your premier destination for high-end perfumery packaging. We specialize in super flint glass bottles, precision crimp pumps, heavy Zamac magnetic caps, and bespoke branding solutions for luxury fragrance houses worldwide.
          </p>
          <div class="pt-2 flex items-center space-x-3">
            <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-[#25D366] text-white flex items-center justify-center transition">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
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
            <?php foreach (array_slice($categories, 0, 6) as $c): ?>
              <li><a href="products.php?category=<?php echo urlencode($c['id']); ?>" class="hover:text-gold transition"><?php echo htmlspecialchars($c['title']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Col 3: B2B Services -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-4">B2B Solutions</h4>
          <ul class="space-y-2.5 text-xs">
            <li><a href="about.php#custom-moulds" class="hover:text-gold transition">Custom Bottle Moulding</a></li>
            <li><a href="about.php#manufacturing" class="hover:text-gold transition">Silk Screen & Hot Stamping</a></li>
            <li><a href="products.php" class="hover:text-gold transition">Wholesale Sample Kits</a></li>
            <li><a href="contact.php" class="hover:text-gold transition">Bulk Quantity Pricing</a></li>
            <li><a href="contact.php" class="hover:text-gold transition">Pan-India & Export Logistics</a></li>
            <li><a href="admin/index.php" class="hover:text-gold transition">Admin Panel Portal</a></li>
          </ul>
        </div>

        <!-- Col 4: Contact & Warehouse -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-4">Contact & Inquiries</h4>
          <ul class="space-y-2.5 text-xs text-neutral-400">
            <li class="flex items-start gap-2">
              <span class="text-gold font-bold">📍</span>
              <span><?php echo COMPANY_ADDRESS; ?></span>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-gold font-bold">📞</span>
              <a href="tel:<?php echo PHONE_RAW; ?>" class="hover:text-white transition"><?php echo PHONE_NUMBER; ?></a>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-gold font-bold">💬</span>
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

      <!-- Bottom Disclaimer & Copyright -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500">
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        <div class="flex items-center space-x-6 text-[11px]">
          <span>✦ ISO 9001:2015 Certified Supply</span>
          <span>✦ 100% Super Flint Glass</span>
          <span>✦ Secure B2B Dispatch</span>
        </div>
      </div>

    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/js/products-data.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
