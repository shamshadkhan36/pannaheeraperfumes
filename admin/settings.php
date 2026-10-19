<?php
$pageTitle = 'Site & Contact Settings';
include_once __DIR__ . '/includes/header.php';

$settings = $siteData['settings'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'save_contact') {
        $siteData['settings']['whatsapp_number'] = trim($_POST['whatsapp_number'] ?? '');
        $siteData['settings']['phone'] = trim($_POST['phone'] ?? '');
        $siteData['settings']['email'] = trim($_POST['email'] ?? '');
        $siteData['settings']['address'] = trim($_POST['address'] ?? '');

        saveSiteData($siteData);
        $_SESSION['flash_success'] = 'Contact and WhatsApp settings updated successfully!';
    } elseif ($action === 'change_password') {
        $newPass = trim($_POST['new_password'] ?? '');
        $confirmPass = trim($_POST['confirm_password'] ?? '');

        if (!empty($newPass) && $newPass === $confirmPass) {
            changeAdminPassword($newPass, $_SESSION['admin_username'] ?? 'admin');
            $_SESSION['flash_success'] = 'Admin password changed successfully!';
        } else {
            $_SESSION['flash_error'] = 'Passwords do not match or are empty.';
        }
    }

    header('Location: settings.php');
    exit;
}
?>

<div class="mb-6">
  <h1 class="text-xl font-bold text-neutral-900">Site Settings & Contact Configuration</h1>
  <p class="text-xs text-neutral-500 mt-0.5">Manage live WhatsApp order routing numbers, showroom address, and administrator credentials.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  
  <!-- Form 1: WhatsApp & Contact Details -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
    <div class="border-b border-neutral-100 pb-3">
      <h3 class="font-bold text-sm text-neutral-900">WhatsApp & Direct Inquiries Desk</h3>
      <p class="text-xs text-neutral-400 mt-0.5">Where customer quotations and cart drawer orders are delivered.</p>
    </div>

    <form method="POST" action="settings.php" class="space-y-4">
      <input type="hidden" name="action" value="save_contact">

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">WhatsApp Phone Number *</label>
        <input 
          type="text" 
          name="whatsapp_number" 
          required 
          placeholder="919876543210" 
          value="<?php echo htmlspecialchars($settings['whatsapp_number'] ?? '919876543210'); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 font-mono font-bold"
        >
        <p class="text-[11px] text-neutral-400 mt-1">Country code + 10 digits without '+' or spaces (e.g. 919876543210 for India).</p>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Display Phone Number</label>
        <input 
          type="text" 
          name="phone" 
          placeholder="+91 98765 43210" 
          value="<?php echo htmlspecialchars($settings['phone'] ?? '+91 98765 43210'); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Official Sales Email</label>
        <input 
          type="email" 
          name="email" 
          placeholder="sales@pannaheeraparfums.com" 
          value="<?php echo htmlspecialchars($settings['email'] ?? 'sales@pannaheeraparfums.com'); ?>" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Warehouse / Showroom Address</label>
        <textarea 
          name="address" 
          rows="3" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        ><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
      </div>

      <button 
        type="submit" 
        class="bg-neutral-900 hover:bg-black text-white px-6 py-2.5 rounded-full text-xs font-bold transition shadow-sm"
      >
        Update Contact Settings
      </button>
    </form>
  </div>

  <!-- Form 2: Admin Password Change -->
  <div class="bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm space-y-4">
    <div class="border-b border-neutral-100 pb-3">
      <h3 class="font-bold text-sm text-neutral-900">Administrator Security Credentials</h3>
      <p class="text-xs text-neutral-400 mt-0.5">Change the password used to access this admin panel.</p>
    </div>

    <form method="POST" action="settings.php" class="space-y-4">
      <input type="hidden" name="action" value="change_password">

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">New Password</label>
        <input 
          type="password" 
          name="new_password" 
          required 
          placeholder="••••••••" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Confirm New Password</label>
        <input 
          type="password" 
          name="confirm_password" 
          required 
          placeholder="••••••••" 
          class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"
        >
      </div>

      <button 
        type="submit" 
        class="bg-gold hover:bg-[#b08b42] text-white px-6 py-2.5 rounded-full text-xs font-bold transition shadow-sm"
      >
        Change Password
      </button>
    </form>

    <div class="mt-6 p-4 bg-neutral-50 border border-neutral-200 rounded-xl text-xs space-y-2">
      <h4 class="font-bold text-neutral-800">Quick Links</h4>
      <p class="text-neutral-500">Live Website URL: <a href="../index.php" target="_blank" class="text-blue-600 font-semibold hover:underline">View Store</a></p>
      <p class="text-neutral-500">Admin Login URL: <code class="font-mono text-neutral-800">/admin/login.php</code></p>
    </div>
  </div>

</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
