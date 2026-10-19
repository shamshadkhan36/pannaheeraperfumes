<?php
define('APP_INIT', true);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/storage.php';

startAdminSession();

if (checkAdminAuth()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (loginAdmin($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Panna Heera Perfumes</title>
  <link rel="icon" type="image/jpeg" href="../assets/images/logo-dark-bg.jpg">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
  </style>
</head>
<body class="bg-[#111111] min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-md bg-neutral-900 border border-neutral-800 rounded-2xl p-8 shadow-2xl">
    
    <!-- Brand Logo & Header -->
    <div class="text-center mb-8">
      <div class="w-16 h-20 bg-black rounded-lg mx-auto mb-4 p-1 border border-neutral-700 shadow-md flex items-center justify-center">
        <img src="../assets/images/logo-dark-bg.jpg" alt="Panna Heera Perfumes" class="w-full h-full object-contain">
      </div>
      <h1 class="text-xl font-black tracking-widest text-white">PANNA HEERA</h1>
      <p class="text-xs text-[#C5A059] tracking-widest uppercase font-bold mt-0.5">Control Panel Portal</p>
    </div>

    <!-- Error Alert -->
    <?php if (!empty($error)): ?>
      <div class="mb-5 p-3 rounded-lg bg-red-950/60 border border-red-800 text-red-300 text-xs font-medium">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="login.php" class="space-y-4">
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-400 mb-1.5">Username</label>
        <input 
          type="text" 
          name="username" 
          required 
          value="admin"
          placeholder="admin" 
          class="w-full px-4 py-3 bg-neutral-800 border border-neutral-700 rounded-xl text-white text-sm outline-none focus:border-[#C5A059] transition"
        >
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-400 mb-1.5">Password</label>
        <input 
          type="password" 
          name="password" 
          required 
          placeholder="••••••••" 
          class="w-full px-4 py-3 bg-neutral-800 border border-neutral-700 rounded-xl text-white text-sm outline-none focus:border-[#C5A059] transition"
        >
      </div>

      <div class="pt-2">
        <button 
          type="submit" 
          class="w-full bg-[#C5A059] hover:bg-[#b08b42] text-white py-3.5 rounded-xl font-bold text-sm tracking-wide transition shadow-lg"
        >
          Sign In to Dashboard &rarr;
        </button>
      </div>
    </form>

    <!-- Default Login Hint -->
    <div class="mt-6 p-3 bg-neutral-800/60 border border-neutral-800 rounded-lg text-center text-neutral-400 text-xs">
      Default Access: <code class="text-white font-mono font-bold">admin</code> / <code class="text-white font-mono font-bold">admin123</code>
    </div>

    <div class="mt-6 text-center">
      <a href="../index.php" class="text-xs text-neutral-500 hover:text-white transition">
        &larr; Back to Live Website
      </a>
    </div>

  </div>

</body>
</html>
