<?php
/**
 * Panna Heera Perfumery - Interactive Modals (Cart Drawer, Product Options, Spotlight Search)
 */
?>

<!-- ============================================ -->
<!-- 1. SLIDE-OUT INQUIRY & CART DRAWER           -->
<!-- ============================================ -->
<div id="cartBackdrop" class="modal-backdrop"></div>
<div id="cartDrawer" class="slide-drawer">
  <!-- Drawer Header -->
  <div class="p-5 border-b border-neutral-100 flex items-center justify-between bg-neutral-50">
    <div class="flex items-center gap-2">
      <svg class="w-5 h-5 text-neutral-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
      </svg>
      <h3 class="font-bold text-sm uppercase tracking-wider text-neutral-900">Your Inquiry Bag</h3>
    </div>
    <button id="cartDrawerClose" class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-neutral-200 text-neutral-600 transition">
      ✕
    </button>
  </div>

  <!-- Cart Content Body -->
  <div class="flex-1 overflow-y-auto p-5">
    <!-- Empty State -->
    <div id="cartEmptyState" class="py-12 text-center" style="display: none;">
      <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-4 text-neutral-400">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
      </div>
      <h4 class="font-bold text-neutral-800 mb-1">Your inquiry list is empty</h4>
      <p class="text-xs text-neutral-500 max-w-xs mx-auto mb-5">Browse our luxury perfume bottles, designer caps, and fine mist sprayers to request a bulk quote.</p>
      <a href="products.php" class="inline-block bg-black text-white text-xs font-semibold px-5 py-2.5 rounded-full hover:bg-neutral-800 transition">
        Browse Catalog
      </a>
    </div>

    <!-- Active List -->
    <div id="cartItemsList" class="divide-y divide-neutral-100">
      <!-- Injected via JavaScript -->
    </div>
  </div>

  <!-- Drawer Footer -->
  <div id="cartFooter" class="p-5 border-t border-neutral-100 bg-neutral-50 space-y-3">
    <div class="flex items-center justify-between text-sm">
      <span class="text-neutral-500 font-medium">Estimated Subtotal:</span>
      <span id="cartSubtotalAmount" class="text-lg font-bold text-neutral-900"><?php echo CURRENCY_SYMBOL; ?> 0.00</span>
    </div>
    <div class="text-[11px] text-neutral-400">
      * Taxes (GST), custom branding tooling, and dispatch freight calculated upon order confirmation.
    </div>
    
    <div class="pt-2 space-y-2">
      <!-- Direct WhatsApp Inquiry / Order Action -->
      <button id="cartWhatsAppCheckout" class="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-3.5 px-4 rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-md transition">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
          <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/>
        </svg>
        Send Order on WhatsApp
      </button>

      <button id="clearCartBtn" class="w-full text-center text-xs text-neutral-500 hover:text-neutral-800 py-1 font-medium transition">
        Clear Inquiry List
      </button>
    </div>
  </div>
</div>


<!-- ============================================ -->
<!-- 2. PRODUCT OPTIONS MODAL DIALOG             -->
<!-- ============================================ -->
<div id="productModalBackdrop" class="modal-backdrop"></div>
<div id="productModalDialog" class="product-dialog">
  <!-- Content dynamically filled by showProductModal(product) in main.js -->
</div>


<!-- ============================================ -->
<!-- 3. INSTANT SPOTLIGHT SEARCH MODAL            -->
<!-- ============================================ -->
<div id="searchModalBackdrop" class="modal-backdrop"></div>
<div id="searchModalDialog" class="search-dialog">
  <div class="p-4 border-b border-neutral-100 flex items-center gap-3 bg-white">
    <svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <input 
      type="text" 
      id="searchInputField" 
      placeholder="Search glass bottles, caps, pumps, 10ml, 100ml, Victor, Cyrill..." 
      class="w-full text-sm outline-none text-neutral-800 placeholder-neutral-400 font-medium py-1"
      autocomplete="off"
    >
    <button id="searchModalClose" class="w-7 h-7 rounded-full flex items-center justify-center hover:bg-neutral-100 text-neutral-500 flex-shrink-0">
      ✕
    </button>
  </div>

  <div id="searchResultsContainer" class="p-3 max-h-[60vh] overflow-y-auto divide-y divide-neutral-100 bg-white">
    <!-- Populated dynamically via JS -->
  </div>

  <div class="px-4 py-2.5 bg-neutral-50 border-t border-neutral-100 text-[11px] text-neutral-400 flex items-center justify-between">
    <span>Tip: Press ESC or click outside to dismiss</span>
    <span>Panna Heera Perfumery Catalog</span>
  </div>
</div>
