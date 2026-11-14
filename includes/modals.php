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
      <p class="text-xs text-neutral-500 max-w-xs mx-auto mb-5">Browse our 1,040 pure fragrance compounds and wholesale perfume oils to request a bulk quote.</p>
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
      <span id="cartSubtotalAmount" class="text-lg font-bold text-neutral-900"><?php echo getCurrencySymbol(); ?> 0.00</span>
    </div>
    <div class="text-[11px] text-neutral-400">
      * Taxes (GST), custom branding tooling, and dispatch freight calculated upon order confirmation.
    </div>
    
    <div class="pt-2 space-y-2">
      <!-- Direct WhatsApp Inquiry / Order Action -->
      <button id="cartWhatsAppCheckout" class="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-3.5 px-4 rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-md transition">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
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
      placeholder="Search 1,040 fragrance oils by name, house (e.g. Aventus, Aqua Di Gio, Tom Ford, Oud, Rose)..." 
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
