/**
 * Panna Heera Perfumery - Interactive Client Logic
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initBackToTop();
  initCart();
  initProductModal();
  initSearchModal();
  initOfferCountdown();
  initHeroCarousel();
});

// Config constants
const WHATSAPP_PHONE = '919876543210';
const CURRENCY_SYM = '₹';

/**
 * Header Scroll & Mobile Nav
 */
function initHeader() {
  const header = document.querySelector('.header-sticky');
  const mobileToggle = document.getElementById('mobileMenuToggle');
  const mobileDrawer = document.getElementById('mobileNavDrawer');
  const mobileClose = document.getElementById('mobileNavClose');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      header?.classList.add('header-scrolled');
    } else {
      header?.classList.remove('header-scrolled');
    }
  });

  if (mobileToggle && mobileDrawer) {
    mobileToggle.addEventListener('click', () => {
      mobileDrawer.classList.toggle('translate-x-full');
      document.body.classList.toggle('overflow-hidden');
    });
  }

  if (mobileClose && mobileDrawer) {
    mobileClose.addEventListener('click', () => {
      mobileDrawer.classList.add('translate-x-full');
      document.body.classList.remove('overflow-hidden');
    });
  }
}

/**
 * Back to Top Smooth Scroll
 */
function initBackToTop() {
  const btt = document.getElementById('backToTopBtn');
  if (!btt) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 350) {
      btt.classList.add('visible');
    } else {
      btt.classList.remove('visible');
    }
  });

  btt.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/**
 * Cart Management (Local Storage + Slide Drawer)
 */
let cart = [];

function initCart() {
  try {
    const saved = localStorage.getItem('panna_heera_cart');
    if (saved) {
      cart = JSON.parse(saved);
    }
  } catch (e) {
    console.error('Cart load error', e);
  }

  updateCartUI();

  // Cart trigger buttons
  const cartTriggers = document.querySelectorAll('.cart-drawer-trigger');
  const cartDrawer = document.getElementById('cartDrawer');
  const cartBackdrop = document.getElementById('cartBackdrop');
  const cartClose = document.getElementById('cartDrawerClose');

  function openCart() {
    cartBackdrop?.classList.add('active');
    cartDrawer?.classList.add('active');
    document.body.classList.add('overflow-hidden');
    renderCartItems();
  }

  function closeCart() {
    cartBackdrop?.classList.remove('active');
    cartDrawer?.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
  }

  cartTriggers.forEach(btn => btn.addEventListener('click', (e) => {
    e.preventDefault();
    openCart();
  }));

  cartBackdrop?.addEventListener('click', closeCart);
  cartClose?.addEventListener('click', closeCart);

  // Cart WhatsApp checkout button
  const whatsappCheckoutBtn = document.getElementById('cartWhatsAppCheckout');
  if (whatsappCheckoutBtn) {
    whatsappCheckoutBtn.addEventListener('click', () => {
      if (cart.length === 0) {
        alert('Your inquiry bag is empty. Please select products first.');
        return;
      }

      let msg = `*Inquiry Order Request - Panna Heera Perfumery*\n\n`;
      let total = 0;

      cart.forEach((item, idx) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        const optionsList = Object.entries(item.selectedOptions || {})
          .map(([k, v]) => `${k}: ${v}`)
          .join(', ');
        
        msg += `${idx + 1}. *${item.title}*\n`;
        if (optionsList) msg += `   Options: ${optionsList}\n`;
        msg += `   Quantity: ${item.quantity} pcs @ ${CURRENCY_SYM}${item.price} each = ${CURRENCY_SYM}${itemTotal.toFixed(2)}\n\n`;
      });

      msg += `*Estimated Subtotal:* ${CURRENCY_SYM}${total.toFixed(2)}\n\n`;
      msg += `Please provide formal quotation, stock availability, and shipping schedule for this order. Thank you!`;

      const waUrl = `https://wa.me/${WHATSAPP_PHONE}?text=${encodeURIComponent(msg)}`;
      window.open(waUrl, '_blank');
    });
  }

  // Clear cart button
  const clearBtn = document.getElementById('clearCartBtn');
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      if (confirm('Are you sure you want to clear your inquiry list?')) {
        cart = [];
        saveCart();
        updateCartUI();
        renderCartItems();
      }
    });
  }
}

function saveCart() {
  try {
    localStorage.setItem('panna_heera_cart', JSON.stringify(cart));
  } catch (e) {
    console.error('Cart save error', e);
  }
}

function updateCartUI() {
  const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
  const badgeEls = document.querySelectorAll('.cart-badge');
  badgeEls.forEach(badge => {
    badge.textContent = totalCount;
    if (totalCount > 0) {
      badge.style.display = 'flex';
    } else {
      badge.style.display = 'none';
    }
  });
}

function renderCartItems() {
  const listContainer = document.getElementById('cartItemsList');
  const emptyState = document.getElementById('cartEmptyState');
  const footerEl = document.getElementById('cartFooter');
  const totalEl = document.getElementById('cartSubtotalAmount');

  if (!listContainer) return;

  if (cart.length === 0) {
    if (emptyState) emptyState.style.display = 'block';
    if (footerEl) footerEl.style.display = 'none';
    listContainer.innerHTML = '';
    return;
  }

  if (emptyState) emptyState.style.display = 'none';
  if (footerEl) footerEl.style.display = 'block';

  let total = 0;
  listContainer.innerHTML = cart.map((item, index) => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;
    const optionsHtml = Object.entries(item.selectedOptions || {})
      .map(([k, v]) => `<span class="inline-block bg-neutral-100 text-neutral-600 text-xs px-2 py-0.5 rounded mr-1 mb-1">${k}: <strong>${v}</strong></span>`)
      .join('');

    return `
      <div class="flex gap-3 py-4 border-b border-neutral-100 items-start">
        <div class="w-16 h-16 bg-neutral-50 rounded border border-neutral-200 overflow-hidden flex-shrink-0">
          <img src="${item.image}" alt="${item.title}" class="w-full h-full object-contain">
        </div>
        <div class="flex-1 min-w-0">
          <h4 class="text-xs font-bold uppercase text-neutral-900 line-clamp-2 leading-tight">${item.title}</h4>
          <div class="mt-1 flex flex-wrap">${optionsHtml}</div>
          <div class="flex items-center justify-between mt-2">
            <div class="text-sm font-semibold text-neutral-900">${CURRENCY_SYM}${item.price} <span class="text-xs text-neutral-500 font-normal">/pc</span></div>
            <div class="flex items-center gap-2">
              <button onclick="changeCartQty(${index}, -1)" class="w-6 h-6 rounded bg-neutral-100 hover:bg-neutral-200 text-neutral-700 flex items-center justify-center text-xs font-bold">-</button>
              <span class="text-xs font-semibold px-1">${item.quantity}</span>
              <button onclick="changeCartQty(${index}, 1)" class="w-6 h-6 rounded bg-neutral-100 hover:bg-neutral-200 text-neutral-700 flex items-center justify-center text-xs font-bold">+</button>
              <button onclick="removeCartItem(${index})" class="text-neutral-400 hover:text-red-500 text-xs ml-2" title="Remove">✕</button>
            </div>
          </div>
        </div>
      </div>
    `;
  }).join('');

  if (totalEl) {
    totalEl.textContent = `${CURRENCY_SYM} ${total.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
  }
}

window.changeCartQty = function(index, delta) {
  if (!cart[index]) return;
  cart[index].quantity += delta;
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  saveCart();
  updateCartUI();
  renderCartItems();
};

window.removeCartItem = function(index) {
  cart.splice(index, 1);
  saveCart();
  updateCartUI();
  renderCartItems();
};

/**
 * Product Options Selector Modal
 */
function initProductModal() {
  const modalBackdrop = document.getElementById('productModalBackdrop');
  const modalDialog = document.getElementById('productModalDialog');
  const modalClose = document.getElementById('productModalClose');

  function closeModal() {
    modalBackdrop?.classList.remove('active');
    modalDialog?.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
  }

  modalBackdrop?.addEventListener('click', closeModal);
  modalClose?.addEventListener('click', closeModal);

  // Bind to any Select Options buttons
  document.querySelectorAll('.open-product-modal').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const prodId = btn.getAttribute('data-product-id');
      const prod = PRODUCTS_DATA.find(p => p.id === prodId);
      if (prod) {
        showProductModal(prod);
      }
    });
  });
}

function showProductModal(product) {
  const modalBackdrop = document.getElementById('productModalBackdrop');
  const modalDialog = document.getElementById('productModalDialog');
  if (!modalDialog) return;

  const selectedOptions = {};

  // Initialize defaults
  if (product.options) {
    Object.keys(product.options).forEach(optKey => {
      selectedOptions[optKey] = product.options[optKey][0];
    });
  }

  let quantity = product.moq || 50;

  // Build Options HTML
  let optionsHtml = '';
  if (product.options) {
    optionsHtml = Object.entries(product.options).map(([optName, optValues]) => `
      <div class="mb-4">
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-600 mb-2">${optName}</label>
        <div class="flex flex-wrap gap-2" data-option-group="${optName}">
          ${optValues.map((val, i) => `
            <button type="button" 
              class="variant-btn ${i === 0 ? 'selected' : ''}" 
              data-opt-name="${optName}" 
              data-opt-val="${val}">
              ${val}
            </button>
          `).join('')}
        </div>
      </div>
    `).join('');
  }

  // Dimension Blueprint Block
  let specsHtml = '';
  if (product.dimensions) {
    const dims = Object.entries(product.dimensions).map(([k, v]) => `
      <div class="bg-neutral-50 p-2 rounded text-xs border border-neutral-200">
        <span class="text-neutral-500 uppercase">${k}:</span>
        <strong class="text-neutral-800 ml-1">${v}</strong>
      </div>
    `).join('');
    specsHtml = `
      <div class="mt-4 p-3 bg-neutral-50 rounded-lg border border-neutral-200">
        <h5 class="text-xs font-bold uppercase tracking-wider text-neutral-700 mb-2">Technical Dimensions & Specs</h5>
        <div class="grid grid-cols-2 gap-2">${dims}</div>
      </div>
    `;
  }

  // Modal Inner Content
  modalDialog.innerHTML = `
    <div class="p-6">
      <div class="flex items-center justify-between border-b pb-3 mb-4">
        <span class="text-xs font-bold uppercase tracking-wider text-neutral-500">${product.category_title || 'Perfumery Packaging'}</span>
        <button id="modalInnerCloseBtn" class="text-neutral-400 hover:text-neutral-800 text-xl font-bold w-8 h-8 rounded-full flex items-center justify-center hover:bg-neutral-100">✕</button>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Image & Technical diagram -->
        <div>
          <div class="w-full aspect-square bg-white border border-neutral-200 rounded-lg overflow-hidden flex items-center justify-center p-4">
            <img src="${product.image}" alt="${product.title}" class="max-w-full max-h-full object-contain">
          </div>
          ${specsHtml}
        </div>

        <!-- Details & Options -->
        <div class="flex flex-col">
          <h2 class="text-base sm:text-lg font-bold uppercase leading-tight text-neutral-900 mb-2">${product.title}</h2>
          
          <div class="flex items-center gap-3 mb-4">
            <div class="text-2xl font-bold text-neutral-900">${CURRENCY_SYM}${product.price} <span class="text-xs text-neutral-500 font-normal">/ piece</span></div>
            <div class="text-xs bg-amber-50 text-amber-800 font-semibold px-2.5 py-1 rounded border border-amber-200">MOQ: ${product.moq} pcs</div>
          </div>

          <p class="text-xs text-neutral-600 mb-4 leading-relaxed">${product.description || ''}</p>

          <form id="productModalForm" onsubmit="return false;">
            ${optionsHtml}

            <!-- Quantity Selector -->
            <div class="mb-5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-600 mb-2">Order Quantity (Pieces)</label>
              <div class="flex items-center gap-3">
                <div class="qty-control">
                  <button type="button" id="modalQtyMinus" class="qty-btn">-</button>
                  <input type="number" id="modalQtyInput" class="qty-input" value="${quantity}" min="${product.moq || 1}" step="10">
                  <button type="button" id="modalQtyPlus" class="qty-btn">+</button>
                </div>
                <span class="text-xs text-neutral-500">Min. requirement: ${product.moq} pcs</span>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 mt-auto pt-4 border-t">
              <button type="button" id="modalAddToCartBtn" class="flex-1 bg-black text-white hover:bg-neutral-800 font-semibold text-sm py-3 px-5 rounded-full flex items-center justify-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Add to Cart
              </button>
              <button type="button" id="modalWhatsAppInquiryBtn" class="flex-1 bg-[#25D366] text-white hover:bg-[#20ba5a] font-semibold text-sm py-3 px-5 rounded-full flex items-center justify-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
                WhatsApp Quote
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  `;

  // Attach Variant Pill Listeners
  modalDialog.querySelectorAll('.variant-btn').forEach(pill => {
    pill.addEventListener('click', () => {
      const group = pill.closest('[data-option-group]');
      group.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('selected'));
      pill.classList.add('selected');
      const optName = pill.getAttribute('data-opt-name');
      const optVal = pill.getAttribute('data-opt-val');
      selectedOptions[optName] = optVal;
    });
  });

  // Quantity control
  const qtyInput = modalDialog.querySelector('#modalQtyInput');
  const qtyMinus = modalDialog.querySelector('#modalQtyMinus');
  const qtyPlus = modalDialog.querySelector('#modalQtyPlus');

  qtyMinus.addEventListener('click', () => {
    let cur = parseInt(qtyInput.value) || product.moq;
    cur = Math.max((product.moq || 1), cur - 10);
    qtyInput.value = cur;
  });

  qtyPlus.addEventListener('click', () => {
    let cur = parseInt(qtyInput.value) || product.moq;
    qtyInput.value = cur + 10;
  });

  // Close inner button
  modalDialog.querySelector('#modalInnerCloseBtn').addEventListener('click', () => {
    modalBackdrop?.classList.remove('active');
    modalDialog?.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
  });

  // Add to cart action
  modalDialog.querySelector('#modalAddToCartBtn').addEventListener('click', () => {
    const finalQty = parseInt(qtyInput.value) || product.moq || 50;
    cart.push({
      id: product.id,
      title: product.title,
      image: product.image,
      price: product.price,
      quantity: finalQty,
      selectedOptions: { ...selectedOptions }
    });
    saveCart();
    updateCartUI();

    // Close modal & open cart drawer
    modalBackdrop?.classList.remove('active');
    modalDialog?.classList.remove('active');
    document.body.classList.remove('overflow-hidden');

    const cartBackdrop = document.getElementById('cartBackdrop');
    const cartDrawer = document.getElementById('cartDrawer');
    cartBackdrop?.classList.add('active');
    cartDrawer?.classList.add('active');
    document.body.classList.add('overflow-hidden');
    renderCartItems();
  });

  // Direct WhatsApp Quote Action
  modalDialog.querySelector('#modalWhatsAppInquiryBtn').addEventListener('click', () => {
    const finalQty = parseInt(qtyInput.value) || product.moq || 50;
    const optionsSummary = Object.entries(selectedOptions).map(([k, v]) => `${k}: ${v}`).join(', ');
    const msg = `*Product Inquiry - Panna Heera Perfumery*\n\n` +
      `Product: *${product.title}*\n` +
      `Estimated Quantity: *${finalQty} pcs*\n` +
      (optionsSummary ? `Options: *${optionsSummary}*\n` : '') +
      `Base Price: ${CURRENCY_SYM}${product.price} / pc\n\n` +
      `Please provide quotation, sample policy, and dispatch timeline.`;
    
    window.open(`https://wa.me/${WHATSAPP_PHONE}?text=${encodeURIComponent(msg)}`, '_blank');
  });

  // Show modal
  modalBackdrop?.classList.add('active');
  modalDialog?.classList.add('active');
  document.body.classList.add('overflow-hidden');
}

/**
 * Instant Spotlight Search Modal
 */
function initSearchModal() {
  const searchTriggers = document.querySelectorAll('.search-modal-trigger');
  const searchBackdrop = document.getElementById('searchModalBackdrop');
  const searchDialog = document.getElementById('searchModalDialog');
  const searchInput = document.getElementById('searchInputField');
  const searchResults = document.getElementById('searchResultsContainer');
  const searchClose = document.getElementById('searchModalClose');

  function openSearch() {
    searchBackdrop?.classList.add('active');
    searchDialog?.classList.add('active');
    document.body.classList.add('overflow-hidden');
    setTimeout(() => searchInput?.focus(), 100);
    renderSearchResults('');
  }

  function closeSearch() {
    searchBackdrop?.classList.remove('active');
    searchDialog?.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
    if (searchInput) searchInput.value = '';
  }

  searchTriggers.forEach(btn => btn.addEventListener('click', (e) => {
    e.preventDefault();
    openSearch();
  }));

  searchBackdrop?.addEventListener('click', closeSearch);
  searchClose?.addEventListener('click', closeSearch);

  searchInput?.addEventListener('input', (e) => {
    renderSearchResults(e.target.value.trim().toLowerCase());
  });

  function renderSearchResults(query) {
    if (!searchResults) return;

    const filtered = PRODUCTS_DATA.filter(p => {
      if (!query) return true;
      return p.title.toLowerCase().includes(query) ||
             p.category_title.toLowerCase().includes(query) ||
             (p.capacity && p.capacity.toLowerCase().includes(query)) ||
             (p.neck_size && p.neck_size.toLowerCase().includes(query));
    });

    if (filtered.length === 0) {
      searchResults.innerHTML = `
        <div class="py-8 text-center text-neutral-400 text-sm">
          No perfume packaging found matching "${query}". Try searching "100ml", "Victor", "Tester", "Cap", or "Pump".
        </div>
      `;
      return;
    }

    searchResults.innerHTML = filtered.map(p => `
      <div class="flex items-center justify-between p-3 hover:bg-neutral-50 rounded-lg transition border-b border-neutral-100 last:border-b-0">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-white rounded border border-neutral-200 overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
            <img src="${p.image}" alt="${p.title}" class="max-w-full max-h-full object-contain">
          </div>
          <div>
            <h4 class="text-xs font-bold uppercase text-neutral-900 line-clamp-1">${p.title}</h4>
            <div class="flex items-center gap-2 text-xs text-neutral-500 mt-0.5">
              <span>${p.category_title}</span>
              <span>•</span>
              <span class="font-semibold text-neutral-800">${CURRENCY_SYM}${p.price}</span>
            </div>
          </div>
        </div>
        <button onclick="selectProductFromSearch('${p.id}')" class="bg-neutral-900 text-white hover:bg-black text-xs font-medium px-3 py-1.5 rounded-full transition flex-shrink-0">
          Select options
        </button>
      </div>
    `).join('');
  }
}

window.selectProductFromSearch = function(productId) {
  const searchBackdrop = document.getElementById('searchModalBackdrop');
  const searchDialog = document.getElementById('searchModalDialog');
  searchBackdrop?.classList.remove('active');
  searchDialog?.classList.remove('active');

  const prod = PRODUCTS_DATA.find(p => p.id === productId);
  if (prod) {
    showProductModal(prod);
  }
};

/**
 * Copy Offer Coupon Code to Clipboard
 */
window.copyOfferCode = function(code, btnElement) {
  if (!code) return;
  navigator.clipboard.writeText(code).then(() => {
    const originalHtml = btnElement.innerHTML;
    btnElement.innerHTML = `
      <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
      <span>Copied!</span>
    `;
    btnElement.classList.add('bg-emerald-600', 'text-white');
    
    // Toast notification
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 right-6 z-50 bg-neutral-900 border border-gold text-white text-xs px-4 py-2.5 rounded-full shadow-2xl flex items-center gap-2 transform translate-y-2 opacity-0 transition-all duration-300';
    toast.innerHTML = `<span class="text-gold font-bold">✓</span> Coupon <strong>${code}</strong> copied to clipboard!`;
    document.body.appendChild(toast);
    
    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-2', 'opacity-0');
    });

    setTimeout(() => {
      btnElement.innerHTML = originalHtml;
      btnElement.classList.remove('bg-emerald-600', 'text-white');
      toast.classList.add('translate-y-2', 'opacity-0');
      setTimeout(() => toast.remove(), 300);
    }, 2500);
  }).catch(err => {
    console.warn('Clipboard write failed, fallback prompt', err);
    prompt('Copy your promo coupon code:', code);
  });
};

/**
 * Initialize Hero Offer Countdown Timer
 */
function initOfferCountdown() {
  const timerContainers = document.querySelectorAll('[data-countdown-end]');
  if (!timerContainers.length) return;

  timerContainers.forEach(container => {
    const endStr = container.getAttribute('data-countdown-end');
    if (!endStr) return;

    // Support ISO and space-separated timestamps
    const targetDate = new Date(endStr.replace(' ', 'T')).getTime();
    if (isNaN(targetDate)) return;

    const daysEl = container.querySelector('[data-cd-days]');
    const hoursEl = container.querySelector('[data-cd-hours]');
    const minsEl = container.querySelector('[data-cd-mins]');
    const secsEl = container.querySelector('[data-cd-secs]');

    function update() {
      const now = new Date().getTime();
      const diff = targetDate - now;

      if (diff <= 0) {
        if (daysEl) daysEl.textContent = '00';
        if (hoursEl) hoursEl.textContent = '00';
        if (minsEl) minsEl.textContent = '00';
        if (secsEl) secsEl.textContent = '00';
        return;
      }

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const secs = Math.floor((diff % (1000 * 60)) / 1000);

      if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
      if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
      if (minsEl) minsEl.textContent = String(mins).padStart(2, '0');
      if (secsEl) secsEl.textContent = String(secs).padStart(2, '0');
    }

    update();
    setInterval(update, 1000);
  });
}

/**
 * Initialize Hero Banner Carousel (When Carousel Mode is Active)
 */
function initHeroCarousel() {
  const container = document.querySelector('.hero-carousel-container');
  if (!container) return;

  const track = container.querySelector('.hero-carousel-track');
  const slides = container.querySelectorAll('.hero-carousel-slide');
  const prevBtn = container.querySelector('.carousel-nav-btn.prev');
  const nextBtn = container.querySelector('.carousel-nav-btn.next');
  const dots = container.querySelectorAll('.carousel-indicator-dot');

  if (!track || slides.length <= 1) return;

  let currentIndex = 0;
  let autoplayTimer = null;
  const slideCount = slides.length;

  function goToSlide(index) {
    if (index < 0) index = slideCount - 1;
    if (index >= slideCount) index = 0;
    currentIndex = index;

    track.style.transform = `translateX(-${currentIndex * 100}%)`;

    dots.forEach((dot, i) => {
      if (i === currentIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(() => {
      goToSlide(currentIndex + 1);
    }, 6000);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      goToSlide(currentIndex - 1);
      startAutoplay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      goToSlide(currentIndex + 1);
      startAutoplay();
    });
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      goToSlide(i);
      startAutoplay();
    });
  });

  container.addEventListener('mouseenter', stopAutoplay);
  container.addEventListener('mouseleave', startAutoplay);

  // Initialize
  goToSlide(0);
  startAutoplay();
}

