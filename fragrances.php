<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$pageTitle = 'Haute Fragrance Compounds & Wholesale Rate List (1,040 Oils)';
$currentPage = 'fragrances';
include_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumbs -->
<div class="bg-neutral-100 border-b border-neutral-200 py-3 text-xs text-neutral-500">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <a href="index.php" class="hover:text-neutral-900">Home</a>
      <span>/</span>
      <span class="text-neutral-900 font-semibold">Fragrance Compounds (1,040 Products)</span>
    </div>
    <a href="assets/docs/panna-heera-price-list.pdf" download class="inline-flex items-center gap-1.5 text-xs font-bold text-neutral-900 hover:text-gold transition">
      <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Download Official PDF Rate List
    </a>
  </div>
</div>

<!-- Page Header Hero -->
<section class="bg-neutral-950 text-white py-12 sm:py-16 border-b border-neutral-800 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d4af37_1px,transparent_1px)] [background-size:16px_16px]"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
      <div class="space-y-3 max-w-3xl">
        <div class="flex items-center gap-2.5 flex-wrap">
          <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-widest uppercase bg-gold/20 text-gold border border-gold/40">
            Official B2B Rate List
          </span>
          <span class="px-3 py-1 rounded-full text-[11px] font-semibold tracking-wider bg-white/10 text-neutral-300">
            ✦ 100% Alcohol-Free Pure Compounds
          </span>
          <span class="px-3 py-1 rounded-full text-[11px] font-semibold tracking-wider bg-white/10 text-neutral-300">
            ✦ 1,040 Varieties In Stock
          </span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black font-serif tracking-tight leading-tight">
          Haute Fragrance Compounds & Oils
        </h1>
        <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed max-w-2xl">
          Direct wholesale supplier of ultra-concentrated French, Oriental, Arabic, and Artisanal fragrance oils. Available in wholesale lots of <strong class="text-white">1 KG</strong>, <strong class="text-white">100 GM</strong>, and <strong class="text-white">25 GM</strong> trial packs.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row lg:flex-col gap-3 flex-shrink-0">
        <a href="assets/docs/panna-heera-price-list.pdf" download class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-neutral-950 font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition shadow-lg">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download PDF Price List
        </a>
        <a href="<?php echo getWhatsAppLink('Hello Panna Heera Perfumery, I would like to inquire about wholesale fragrance oils.'); ?>" target="_blank" class="inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition shadow-lg">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
          Quick WhatsApp Quote
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Explorer & Directory Section -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" id="catalogApp">
  
  <!-- Search & Filter Controls Card -->
  <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-4 sm:p-6 mb-8 space-y-5">
    
    <!-- Top Row: Search Input & View Toggle -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4">
      <div class="relative flex-1">
        <svg class="w-5 h-5 text-neutral-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input 
          type="text" 
          id="oilSearchInput" 
          placeholder="Search 1,040 fragrances by name, house (e.g. Aventus, Aqua Di Gio, Tom Ford, Oud, Rose)..." 
          class="w-full pl-12 pr-10 py-3.5 text-xs sm:text-sm rounded-xl border border-neutral-300 focus:outline-none focus:border-neutral-900 shadow-inner font-medium"
        >
        <button id="clearSearchBtn" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-700 text-xs font-bold w-6 h-6 rounded-full bg-neutral-100 flex items-center justify-center">✕</button>
      </div>

      <!-- Filters & View Mode -->
      <div class="flex items-center gap-3 flex-wrap">
        <!-- Brand / House Dropdown -->
        <select id="oilBrandFilter" class="px-3.5 py-3 text-xs rounded-xl border border-neutral-300 bg-white font-semibold text-neutral-800 focus:outline-none focus:border-neutral-900 shadow-sm">
          <option value="all">All Houses & Brands (140+)</option>
          <!-- Populated by JS -->
        </select>

        <!-- Sort Select -->
        <select id="oilSortSelect" class="px-3.5 py-3 text-xs rounded-xl border border-neutral-300 bg-white font-semibold text-neutral-800 focus:outline-none focus:border-neutral-900 shadow-sm">
          <option value="sno_asc">Default Catalog Order (#1 - #1040)</option>
          <option value="name_asc">Name: A to Z</option>
          <option value="price_1kg_asc">1 KG Price: Low to High</option>
          <option value="price_1kg_desc">1 KG Price: High to Low</option>
          <option value="price_25g_asc">25 GM Trial: Low to High</option>
        </select>

        <!-- Per Page Select -->
        <select id="oilPerPageSelect" class="px-3.5 py-3 text-xs rounded-xl border border-neutral-300 bg-white font-semibold text-neutral-800 focus:outline-none focus:border-neutral-900 shadow-sm">
          <option value="24">24 Cards / Page</option>
          <option value="48">48 Cards / Page</option>
          <option value="96">96 Cards / Page</option>
        </select>

        <!-- View Mode (Cards / Table) -->
        <div class="inline-flex rounded-xl border border-neutral-200 p-1 bg-neutral-100">
          <button id="viewCardsBtn" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition bg-white text-neutral-900 shadow-sm inline-flex items-center gap-1.5" title="Card Grid View">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Cards View
          </button>
          <button id="viewTableBtn" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition text-neutral-600 hover:text-neutral-900 inline-flex items-center gap-1.5" title="Table View">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            Table View
          </button>
        </div>
      </div>
    </div>

    <!-- Category / Olfactory Family Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin">
      <button class="family-pill active" data-family="all">
        All Fragrances (1,040)
      </button>
      <button class="family-pill" data-family="Designer Fragrance">
        Designer Inspirations (662)
      </button>
      <button class="family-pill" data-family="Oriental & Arabic">
        Oriental & Arabic Attars (257)
      </button>
      <button class="family-pill" data-family="Niche Luxury">
        Niche Luxury Houses (91)
      </button>
      <button class="family-pill" data-family="Fruits & Gourmand">
        Fruits Fragrances (20)
      </button>
      <button class="family-pill" data-family="Floral & Botanical">
        Floral Fragrances (10)
      </button>
    </div>

  </div>

  <!-- Results Summary Bar -->
  <div class="flex items-center justify-between mb-4 px-1 text-xs text-neutral-500">
    <div id="resultsCountText">
      Showing <strong class="text-neutral-900">1,040</strong> fragrance compounds
    </div>
    <div class="flex items-center gap-3">
      <span class="inline-flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        Ready for Immediate Dispatch
      </span>
    </div>
  </div>

  <!-- Container for Cards View (Primary Default) -->
  <div id="cardsViewContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <!-- Populated by JS -->
  </div>

  <!-- Container for Table View (Secondary, Hidden by default) -->
  <div id="tableViewContainer" class="hidden bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs">
        <thead>
          <tr class="bg-neutral-900 text-white uppercase text-[11px] tracking-wider">
            <th class="py-3.5 px-4 font-bold text-center w-16"># S.No</th>
            <th class="py-3.5 px-4 font-bold">Fragrance Compound Name</th>
            <th class="py-3.5 px-4 font-bold">House / Brand</th>
            <th class="py-3.5 px-4 font-bold">Category</th>
            <th class="py-3.5 px-4 font-bold text-right">25 GM Pack</th>
            <th class="py-3.5 px-4 font-bold text-right">100 GM Pack</th>
            <th class="py-3.5 px-4 font-bold text-right text-amber-300">1 KG Wholesale</th>
            <th class="py-3.5 px-4 font-bold text-center">Quick WhatsApp Order</th>
          </tr>
        </thead>
        <tbody id="oilTableBody" class="divide-y divide-neutral-100">
          <!-- Populated by JS -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Empty Search Results State -->
  <div id="emptyResultsState" class="hidden bg-white rounded-2xl border border-neutral-200 p-12 text-center space-y-4">
    <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto text-neutral-400">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <h3 class="text-base font-bold text-neutral-800">No fragrance compounds found</h3>
    <p class="text-xs text-neutral-500 max-w-md mx-auto">
      We could not find any oils matching your query. Try searching by popular keywords like "Oud", "Aventus", "Rose", "Armani", or clear your filter.
    </p>
    <button id="resetFiltersBtn" class="bg-neutral-900 hover:bg-black text-white px-5 py-2.5 rounded-full text-xs font-bold transition">
      Reset All Filters
    </button>
  </div>

  <!-- Pagination Controls -->
  <div id="paginationContainer" class="mt-8 flex items-center justify-between flex-wrap gap-4 pt-4 border-t border-neutral-200">
    <div class="text-xs text-neutral-500" id="paginationInfo">
      Showing 1 to 50 of 1,040 items
    </div>
    <div class="flex items-center gap-1.5" id="paginationButtons">
      <!-- Buttons populated by JS -->
    </div>
  </div>

  <!-- B2B Wholesale Notice Box -->
  <div class="mt-14 p-6 sm:p-8 rounded-2xl bg-neutral-50 border border-neutral-200 space-y-4">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 rounded-full bg-gold"></span>
      <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-900">Official Wholesale Terms & Information</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-neutral-600">
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">1. Branded Inspiration Reference</strong>
        <p class="leading-relaxed">Names listed are olfactive inspiration benchmarks to identify scent profiles and notes. Products are proprietary Panna Heera compound formulations.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">2. 100% Pure & Alcohol-Free</strong>
        <p class="leading-relaxed">All fragrance oils supplied in this catalog are pure, undiluted, and completely alcohol-free concentrates suitable for perfume blending and attar manufacture.</p>
      </div>
      <div class="space-y-1">
        <strong class="text-neutral-900 block font-semibold">3. Tier Pricing & Dispatch</strong>
        <p class="leading-relaxed">Minimum trial order per variant is 25 GM. Bulk 1 KG aluminum flacons feature special wholesale volume discounts. Orders ship pan-India with secure couriers.</p>
      </div>
    </div>
  </div>

</main>

<!-- Load Fragrance Data & Logic -->
<script src="assets/js/fragrance-data.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const rawData = typeof FRAGRANCE_OILS_DATA !== 'undefined' ? FRAGRANCE_OILS_DATA : [];
    
    // State
    let searchQuery = '';
    let selectedFamily = 'all';
    let selectedBrand = 'all';
    let sortMode = 'sno_asc';
    let currentPageNum = 1;
    let itemsPerPage = 24;
    let viewMode = 'cards'; // Default to Cards View

    // DOM Elements
    const searchInput = document.getElementById('oilSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const brandFilter = document.getElementById('oilBrandFilter');
    const sortSelect = document.getElementById('oilSortSelect');
    const perPageSelect = document.getElementById('oilPerPageSelect');
    const tableBody = document.getElementById('oilTableBody');
    const cardsContainer = document.getElementById('cardsViewContainer');
    const tableView = document.getElementById('tableViewContainer');
    const emptyState = document.getElementById('emptyResultsState');
    const resultsCount = document.getElementById('resultsCountText');
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationButtons = document.getElementById('paginationButtons');
    const resetBtn = document.getElementById('resetFiltersBtn');
    const viewTableBtn = document.getElementById('viewTableBtn');
    const viewCardsBtn = document.getElementById('viewCardsBtn');

    // Populate Brand Dropdown
    const brandSet = new Set();
    rawData.forEach(item => {
      if (item.brand && item.brand !== 'Panna Heera Originals') {
        brandSet.add(item.brand);
      }
    });
    const sortedBrands = Array.from(brandSet).sort();
    sortedBrands.forEach(brand => {
      const opt = document.createElement('option');
      opt.value = brand;
      opt.textContent = brand;
      brandFilter.appendChild(opt);
    });

    // Family Pills click handler
    document.querySelectorAll('.family-pill').forEach(btn => {
      btn.addEventListener('click', (e) => {
        document.querySelectorAll('.family-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        selectedFamily = btn.getAttribute('data-family');
        currentPageNum = 1;
        render();
      });
    });

    // View toggles
    viewCardsBtn?.addEventListener('click', () => {
      viewMode = 'cards';
      viewCardsBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition bg-white text-neutral-900 shadow-sm inline-flex items-center gap-1.5';
      viewTableBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition text-neutral-600 hover:text-neutral-900 inline-flex items-center gap-1.5';
      tableView.classList.add('hidden');
      cardsContainer.classList.remove('hidden');
      render();
    });

    viewTableBtn?.addEventListener('click', () => {
      viewMode = 'table';
      viewTableBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition bg-white text-neutral-900 shadow-sm inline-flex items-center gap-1.5';
      viewCardsBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition text-neutral-600 hover:text-neutral-900 inline-flex items-center gap-1.5';
      tableView.classList.remove('hidden');
      cardsContainer.classList.add('hidden');
      render();
    });

    // Per Page Select Handler
    perPageSelect?.addEventListener('change', (e) => {
      itemsPerPage = parseInt(e.target.value) || 24;
      currentPageNum = 1;
      render();
    });

    // Search input handler with debounce
    let debounceTimer;
    searchInput.addEventListener('input', (e) => {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => {
        searchQuery = e.target.value.trim().toLowerCase();
        if (searchQuery.length > 0) {
          clearBtn.classList.remove('hidden');
        } else {
          clearBtn.classList.add('hidden');
        }
        currentPageNum = 1;
        render();
      }, 150);
    });

    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      searchQuery = '';
      clearBtn.classList.add('hidden');
      currentPageNum = 1;
      render();
    });

    brandFilter.addEventListener('change', (e) => {
      selectedBrand = e.target.value;
      currentPageNum = 1;
      render();
    });

    sortSelect.addEventListener('change', (e) => {
      sortMode = e.target.value;
      currentPageNum = 1;
      render();
    });

    resetBtn.addEventListener('click', () => {
      searchQuery = '';
      searchInput.value = '';
      selectedFamily = 'all';
      selectedBrand = 'all';
      brandFilter.value = 'all';
      sortMode = 'sno_asc';
      sortSelect.value = 'sno_asc';
      document.querySelectorAll('.family-pill').forEach(b => {
        b.classList.toggle('active', b.getAttribute('data-family') === 'all');
      });
      currentPageNum = 1;
      render();
    });

    function filterAndSortData() {
      return rawData.filter(item => {
        // Family filter
        if (selectedFamily !== 'all' && item.family !== selectedFamily) {
          return false;
        }
        // Brand filter
        if (selectedBrand !== 'all' && item.brand !== selectedBrand) {
          return false;
        }
        // Search filter
        if (searchQuery) {
          const matchFull = item.full_name.toLowerCase().includes(searchQuery);
          const matchBrand = item.brand.toLowerCase().includes(searchQuery);
          const matchSno = item.sno.toString().includes(searchQuery);
          if (!matchFull && !matchBrand && !matchSno) {
            return false;
          }
        }
        return true;
      }).sort((a, b) => {
        if (sortMode === 'sno_asc') return a.sno - b.sno;
        if (sortMode === 'name_asc') return a.full_name.localeCompare(b.full_name);
        if (sortMode === 'price_1kg_asc') return a.price_1kg - b.price_1kg;
        if (sortMode === 'price_1kg_desc') return b.price_1kg - a.price_1kg;
        if (sortMode === 'price_25g_asc') return a.price_25gm - b.price_25gm;
        return 0;
      });
    }

    function buildWhatsAppLink(item, weight, price) {
      const text = `Hello Panna Heera Perfumery! I would like to order:\n\n*Fragrance:* ${item.full_name} (#${item.sno})\n*Selected Weight:* ${weight}\n*Listed Rate:* ₹${price.toLocaleString('en-IN')}\n\nPlease share delivery timeline and payment details.`;
      return `https://wa.me/919876543210?text=${encodeURIComponent(text)}`;
    }

    function render() {
      const filtered = filterAndSortData();
      const total = filtered.length;

      // Update count
      resultsCount.innerHTML = `Showing <strong class="text-neutral-900">${total.toLocaleString()}</strong> fragrance compounds`;

      if (total === 0) {
        tableView.classList.add('hidden');
        cardsContainer.classList.add('hidden');
        emptyState.classList.remove('hidden');
        document.getElementById('paginationContainer').classList.add('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      document.getElementById('paginationContainer').classList.remove('hidden');

      if (viewMode === 'table') {
        tableView.classList.remove('hidden');
        cardsContainer.classList.add('hidden');
      } else {
        tableView.classList.add('hidden');
        cardsContainer.classList.remove('hidden');
      }

      // Pagination slice
      const totalPages = Math.ceil(total / itemsPerPage);
      if (currentPageNum > totalPages) currentPageNum = totalPages;
      if (currentPageNum < 1) currentPageNum = 1;

      const startIndex = (currentPageNum - 1) * itemsPerPage;
      const endIndex = Math.min(startIndex + itemsPerPage, total);
      const pageItems = filtered.slice(startIndex, endIndex);

      paginationInfo.textContent = `Showing ${(startIndex + 1).toLocaleString()} to ${endIndex.toLocaleString()} of ${total.toLocaleString()} items`;

      // Render Table Rows
      tableBody.innerHTML = pageItems.map((item, idx) => {
        const rowBg = idx % 2 === 0 ? 'bg-white' : 'bg-neutral-50/50';
        return `
          <tr class="${rowBg} hover:bg-amber-50/60 transition group border-b border-neutral-100 last:border-b-0">
            <td class="py-3 px-4 font-mono font-bold text-center text-neutral-400 group-hover:text-gold">
              #${item.sno}
            </td>
            <td class="py-3 px-4 font-bold text-neutral-900">
              <span class="block">${item.fragrance_name}</span>
              <span class="text-[10px] font-mono text-neutral-400 sm:hidden block mt-0.5">${item.brand}</span>
            </td>
            <td class="py-3 px-4 text-neutral-600 font-medium">
              <span class="inline-block px-2 py-0.5 rounded bg-neutral-100 text-[11px] font-semibold text-neutral-700">
                ${item.brand}
              </span>
            </td>
            <td class="py-3 px-4 text-neutral-500 text-[11px]">
              ${item.family}
            </td>
            <td class="py-3 px-4 text-right font-mono font-semibold text-neutral-700">
              ₹${item.price_25gm.toLocaleString('en-IN')}
            </td>
            <td class="py-3 px-4 text-right font-mono font-semibold text-neutral-800">
              ₹${item.price_100gm.toLocaleString('en-IN')}
            </td>
            <td class="py-3 px-4 text-right font-mono font-bold text-neutral-900 text-sm">
              ₹${item.price_1kg.toLocaleString('en-IN')}
            </td>
            <td class="py-3 px-4 text-center">
              <div class="inline-flex items-center gap-1">
                <a 
                  href="${buildWhatsAppLink(item, '1 KG', item.price_1kg)}" 
                  target="_blank" 
                  title="Order 1 KG on WhatsApp"
                  class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold inline-flex items-center gap-1 transition shadow-sm"
                >
                  <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
                  <span>Order 1 KG</span>
                </a>
                <a 
                  href="${buildWhatsAppLink(item, '100 GM', item.price_100gm)}" 
                  target="_blank" 
                  title="Order 100 GM on WhatsApp"
                  class="bg-neutral-900 hover:bg-black text-white px-2 py-1.5 rounded-lg text-[10px] font-semibold transition"
                >
                  100g
                </a>
                <a 
                  href="${buildWhatsAppLink(item, '25 GM', item.price_25gm)}" 
                  target="_blank" 
                  title="Order 25 GM Sample on WhatsApp"
                  class="bg-neutral-100 hover:bg-neutral-200 text-neutral-800 px-2 py-1.5 rounded-lg text-[10px] font-semibold transition border border-neutral-200"
                >
                  25g
                </a>
              </div>
            </td>
          </tr>
        `;
      }).join('');

      // Render Cards View
      cardsContainer.innerHTML = pageItems.map(item => {
        const order1kgUrl = buildWhatsAppLink(item, '1 KG Wholesale', item.price_1kg);
        const order100gUrl = buildWhatsAppLink(item, '100 GM Pack', item.price_100gm);
        const order25gUrl = buildWhatsAppLink(item, '25 GM Trial', item.price_25gm);

        return `
        <div class="product-card group bg-white rounded-2xl border border-neutral-200/80 shadow-sm hover:shadow-xl hover:border-neutral-300 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
          <div>
            <!-- Product Photo & High-End Badges -->
            <div class="relative aspect-square bg-gradient-to-br from-neutral-100 via-neutral-50 to-amber-50/40 overflow-hidden flex items-center justify-center border-b border-neutral-100">
              <img 
                src="assets/images/categories/fragrance-oils.jpg" 
                alt="${item.full_name}" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
              >
              
              <!-- Top Badges -->
              <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                <span class="bg-neutral-950/85 backdrop-blur text-white text-[10px] font-mono font-black px-2.5 py-0.5 rounded-full shadow border border-white/10">
                  #${item.sno}
                </span>
                <span class="bg-gradient-to-r from-amber-500 to-amber-600 text-neutral-950 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full shadow">
                  100% Pure Oil
                </span>
              </div>

              <!-- Bottom Overlays on Image -->
              <div class="absolute bottom-2.5 left-2.5 right-2.5 flex items-center justify-between gap-1 pointer-events-none">
                <span class="bg-white/95 backdrop-blur text-neutral-900 text-[10px] font-extrabold px-2 py-0.5 rounded-md shadow-sm truncate max-w-[65%] border border-neutral-200/60">
                  ${item.brand}
                </span>
                <span class="bg-black/80 backdrop-blur text-gold text-[9px] font-bold px-1.5 py-0.5 rounded-md">
                  0% Alcohol
                </span>
              </div>
            </div>

            <!-- Middle Text Content -->
            <div class="p-4 space-y-2">
              <div class="flex items-center gap-1.5 text-[10px] text-neutral-400 font-semibold uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                <span class="truncate">${item.family}</span>
              </div>

              <h3 class="font-extrabold text-neutral-900 text-sm leading-snug line-clamp-2 min-h-[2.5rem] group-hover:text-amber-700 transition" title="${item.fragrance_name}">
                ${item.fragrance_name}
              </h3>

              <div class="text-[11px] text-neutral-500 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                  In Stock
                </span>
                <span>•</span>
                <span>MOQ: 25 GM</span>
              </div>
            </div>
          </div>

          <!-- Bottom: 3-Tier Wholesale Rates & Quick Order -->
          <div class="p-4 pt-0 space-y-3">
            <!-- 3 Pricing Boxes -->
            <div class="grid grid-cols-3 gap-1.5 text-center bg-neutral-50 p-2 rounded-xl border border-neutral-200/80">
              <a href="${order25gUrl}" target="_blank" title="Order 25 GM Trial Pack on WhatsApp" class="hover:bg-white p-1 rounded-lg transition group/p">
                <span class="text-neutral-400 block text-[9px] font-bold uppercase tracking-wider group-hover/p:text-neutral-700">25 GM</span>
                <strong class="text-neutral-800 font-mono block text-xs font-bold whitespace-nowrap">₹${item.price_25gm.toLocaleString('en-IN')}</strong>
              </a>
              <a href="${order100gUrl}" target="_blank" title="Order 100 GM Pack on WhatsApp" class="hover:bg-white p-1 rounded-lg transition group/p">
                <span class="text-neutral-400 block text-[9px] font-bold uppercase tracking-wider group-hover/p:text-neutral-700">100 GM</span>
                <strong class="text-neutral-800 font-mono block text-xs font-bold whitespace-nowrap">₹${item.price_100gm.toLocaleString('en-IN')}</strong>
              </a>
              <a href="${order1kgUrl}" target="_blank" title="Order 1 KG Bulk Flacon on WhatsApp" class="bg-amber-100/70 hover:bg-amber-200/70 p-1 rounded-lg border border-amber-300/60 transition group/p">
                <span class="text-amber-800 block text-[9px] font-black uppercase tracking-wider">1 KG Bulk</span>
                <strong class="text-amber-950 font-mono block text-xs font-black whitespace-nowrap">₹${item.price_1kg.toLocaleString('en-IN')}</strong>
              </a>
            </div>

            <!-- WhatsApp CTA Button -->
            <div class="flex items-center gap-1.5">
              <a 
                href="${order1kgUrl}" 
                target="_blank" 
                class="flex-1 bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 px-3 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-1.5 transition shadow-sm hover:shadow-md"
              >
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
                <span>WhatsApp Order</span>
              </a>
              <a 
                href="${order25gUrl}" 
                target="_blank" 
                title="Order 25 GM Sample Pack"
                class="bg-neutral-100 hover:bg-neutral-200 text-neutral-800 text-[11px] font-bold py-2.5 px-2.5 rounded-xl transition border border-neutral-200"
              >
                25g Trial
              </a>
            </div>
          </div>
        </div>
        `;
      }).join('');

      // Render Pagination Buttons
      renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
      if (totalPages <= 1) {
        paginationButtons.innerHTML = '';
        return;
      }

      let btnsHtml = '';

      // Prev
      if (currentPageNum > 1) {
        btnsHtml += `<button class="page-nav-btn" data-page="${currentPageNum - 1}">‹ Prev</button>`;
      }

      // Page numbers window
      const maxVisible = 5;
      let startP = Math.max(1, currentPageNum - 2);
      let endP = Math.min(totalPages, startP + maxVisible - 1);
      if (endP - startP < maxVisible - 1) {
        startP = Math.max(1, endP - maxVisible + 1);
      }

      if (startP > 1) {
        btnsHtml += `<button class="page-num-btn" data-page="1">1</button>`;
        if (startP > 2) btnsHtml += `<span class="px-2 text-neutral-400">...</span>`;
      }

      for (let p = startP; p <= endP; p++) {
        const activeClass = p === currentPageNum ? 'active' : '';
        btnsHtml += `<button class="page-num-btn ${activeClass}" data-page="${p}">${p}</button>`;
      }

      if (endP < totalPages) {
        if (endP < totalPages - 1) btnsHtml += `<span class="px-2 text-neutral-400">...</span>`;
        btnsHtml += `<button class="page-num-btn" data-page="${totalPages}">${totalPages}</button>`;
      }

      // Next
      if (currentPageNum < totalPages) {
        btnsHtml += `<button class="page-nav-btn" data-page="${currentPageNum + 1}">Next ›</button>`;
      }

      paginationButtons.innerHTML = btnsHtml;

      paginationButtons.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
          currentPageNum = parseInt(btn.getAttribute('data-page'));
          render();
          document.getElementById('catalogApp').scrollIntoView({ behavior: 'smooth' });
        });
      });
    }

    // Initial render
    render();
  });
</script>

<style>
  .family-pill {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 9999px;
    white-space: nowrap;
    border: 1px solid #e5e7eb;
    background-color: #f9fafb;
    color: #4b5563;
    transition: all 0.2s;
  }
  .family-pill:hover {
    background-color: #f3f4f6;
    color: #111827;
  }
  .family-pill.active {
    background-color: #171717;
    color: #ffffff;
    border-color: #171717;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .page-num-btn {
    min-width: 2rem;
    height: 2rem;
    padding: 0 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #374151;
    transition: all 0.15s;
  }
  .page-num-btn:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
  }
  .page-num-btn.active {
    background: #171717;
    color: #ffffff;
    border-color: #171717;
  }
  .page-nav-btn {
    height: 2rem;
    padding: 0 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    color: #374151;
    transition: all 0.15s;
  }
  .page-nav-btn:hover {
    background: #f3f4f6;
  }
</style>

<?php
include_once __DIR__ . '/includes/modals.php';
include_once __DIR__ . '/includes/footer.php';
?>
