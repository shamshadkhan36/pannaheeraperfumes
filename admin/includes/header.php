<?php
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../includes/storage.php';

requireAdminAuth();

$siteData = loadSiteData();
$currentAdminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Admin Control Panel - Panna Heera Perfumes</title>
  
  <link rel="icon" type="image/jpeg" href="../assets/images/logo-dark-bg.jpg">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: {
              DEFAULT: '#C5A059',
              500: '#C5A059',
              600: '#B08B42',
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
  </style>
</head>
<body class="bg-neutral-100 text-neutral-800 antialiased min-h-screen flex flex-col">

  <div class="flex flex-1 min-h-screen">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-[#111111] text-white flex-shrink-0 flex flex-col justify-between hidden md:flex border-r border-neutral-800">
      <div>
        <!-- Admin Brand Header -->
        <div class="p-5 border-b border-neutral-800 flex items-center gap-3">
          <img src="../assets/images/logo-dark-bg.jpg" alt="Panna Heera" class="w-10 h-12 object-contain rounded border border-neutral-700">
          <div>
            <h2 class="text-sm font-black tracking-widest text-white leading-tight">PANNA HEERA</h2>
            <span class="text-[10px] font-bold text-gold tracking-widest uppercase">Admin Panel</span>
          </div>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-1.5 text-xs font-semibold">
          <a href="index.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition <?php echo $currentAdminPage === 'index' ? 'bg-gold text-white shadow-sm' : 'text-neutral-400 hover:bg-neutral-900 hover:text-white'; ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>Dashboard</span>
          </a>

          <a href="banner.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition <?php echo $currentAdminPage === 'banner' ? 'bg-gold text-white shadow-sm' : 'text-neutral-400 hover:bg-neutral-900 hover:text-white'; ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>Hero Banner</span>
          </a>

          <a href="categories.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition <?php echo $currentAdminPage === 'categories' ? 'bg-gold text-white shadow-sm' : 'text-neutral-400 hover:bg-neutral-900 hover:text-white'; ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>Manage Categories</span>
            <span class="ml-auto bg-neutral-800 text-neutral-300 text-[10px] px-1.5 py-0.5 rounded"><?php echo count($siteData['categories'] ?? []); ?></span>
          </a>

          <a href="products.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition <?php echo ($currentAdminPage === 'products' || $currentAdminPage === 'product-form') ? 'bg-gold text-white shadow-sm' : 'text-neutral-400 hover:bg-neutral-900 hover:text-white'; ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span>Manage Products</span>
            <span class="ml-auto bg-neutral-800 text-neutral-300 text-[10px] px-1.5 py-0.5 rounded"><?php echo count($siteData['products'] ?? []); ?></span>
          </a>

          <a href="settings.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition <?php echo $currentAdminPage === 'settings' ? 'bg-gold text-white shadow-sm' : 'text-neutral-400 hover:bg-neutral-900 hover:text-white'; ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Site & Contact Settings</span>
          </a>
        </nav>
      </div>

      <!-- Bottom Links -->
      <div class="p-4 border-t border-neutral-800 space-y-2">
        <a href="../index.php" target="_blank" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-neutral-400 hover:text-white rounded-lg hover:bg-neutral-900 transition">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
          <span>View Live Store</span>
        </a>
        <a href="logout.php" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-red-400 hover:text-red-300 rounded-lg hover:bg-red-950/40 transition">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          <span>Log Out</span>
        </a>
      </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
      
      <!-- Topbar -->
      <header class="bg-white border-b border-neutral-200 h-16 flex items-center justify-between px-6 z-10">
        <div class="flex items-center gap-3">
          <span class="text-sm font-bold text-neutral-800 md:hidden">Panna Heera Admin</span>
          <span class="text-xs text-neutral-500 hidden sm:inline-block">Logged in as: <strong class="text-neutral-900"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin'); ?></strong></span>
        </div>

        <div class="flex items-center space-x-3">
          <a href="../index.php" target="_blank" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-800 text-xs font-semibold px-3 py-1.5 rounded-full inline-flex items-center gap-1.5 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Live Site</span>
          </a>
          <a href="logout.php" class="text-xs text-red-600 hover:text-red-800 font-semibold px-2 py-1">
            Logout
          </a>
        </div>
      </header>

      <!-- Flash Notification Messages -->
      <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="mx-6 mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800 text-xs font-semibold flex items-center justify-between">
          <span>✓ <?php echo htmlspecialchars($_SESSION['flash_success']); ?></span>
          <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">✕</button>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-800 text-xs font-semibold flex items-center justify-between">
          <span>✕ <?php echo htmlspecialchars($_SESSION['flash_error']); ?></span>
          <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-800">✕</button>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
      <?php endif; ?>

      <!-- Main Container Content -->
      <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
