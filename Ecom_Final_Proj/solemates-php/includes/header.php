<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/data.php';

$flash = $_SESSION['flash'] ?? null;
if ($flash) unset($_SESSION['flash']);

$cart_count = get_cart_count();
$current_user = $_SESSION['user'] ?? null;
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title ?? 'Solemates') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .cart-drawer { transition: transform 0.3s ease; }
    .overlay { transition: opacity 0.3s ease; }
    .product-card:hover .card-btn { opacity: 1; }
    .group:hover .group-hover-scale { transform: scale(1.05); }
  </style>
</head>
<body class="bg-white text-gray-900 min-h-screen flex flex-col">

<?php if ($flash): ?>
<div id="flash-msg" class="fixed top-4 right-4 z-[100] px-5 py-3 rounded-lg shadow-lg text-sm font-medium text-white
  <?= $flash['type'] === 'success' ? 'bg-green-600' : ($flash['type'] === 'info' ? 'bg-gray-700' : 'bg-red-600') ?>">
  <?= htmlspecialchars($flash['msg']) ?>
</div>
<script>setTimeout(() => { const f = document.getElementById('flash-msg'); if(f) f.remove(); }, 3500);</script>
<?php endif; ?>

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <a href="<?= BASE_URL ?>/index.php" class="text-2xl font-black tracking-tighter text-black">SOLEMATES</a>

      <!-- Desktop Nav -->
      <div class="hidden md:flex items-center space-x-8">
        <a href="<?= BASE_URL ?>/index.php" class="text-sm font-medium transition-colors hover:text-black <?= $current_page==='index.php'?'text-black':'text-gray-500' ?>">Home</a>
        <a href="<?= BASE_URL ?>/catalog.php" class="text-sm font-medium transition-colors hover:text-black <?= $current_page==='catalog.php'?'text-black':'text-gray-500' ?>">Shop</a>
        <a href="<?= BASE_URL ?>/track.php" class="text-sm font-medium transition-colors hover:text-black <?= $current_page==='track.php'?'text-black':'text-gray-500' ?>">Track Order</a>
        <a href="<?= BASE_URL ?>/about.php" class="text-sm font-medium transition-colors hover:text-black <?= $current_page==='about.php'?'text-black':'text-gray-500' ?>">About</a>
        <a href="<?= BASE_URL ?>/contact.php" class="text-sm font-medium transition-colors hover:text-black <?= $current_page==='contact.php'?'text-black':'text-gray-500' ?>">Contact</a>
      </div>

      <!-- Icons -->
      <div class="flex items-center gap-3">
        <button class="p-2 text-gray-500 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>

        <a href="<?= BASE_URL ?>/cart.php" class="relative p-2 text-gray-500 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 9H4L5 9z"/></svg>
          <?php if ($cart_count > 0): ?>
          <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-black rounded-full translate-x-1/4 -translate-y-1/4"><?= $cart_count ?></span>
          <?php endif; ?>
        </a>

        <?php if ($current_user): ?>
        <div class="relative group">
          <button class="flex items-center gap-1 p-2 text-gray-500 hover:text-black transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-sm font-medium hidden sm:block"><?= htmlspecialchars(explode(' ', $current_user['name'])[0]) ?></span>
          </button>
          <div class="absolute right-0 w-48 mt-1 origin-top-right bg-white border border-gray-100 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="py-1">
              <?php if (!empty($current_user['is_admin'])): ?>
              <a href="<?= BASE_URL ?>/admin.php" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Admin Dashboard
              </a>
              <a href="<?= BASE_URL ?>/admin_users.php" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1116.951 6.475M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Manage Users
              </a>
              <?php endif; ?>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
              <a href="<?= BASE_URL ?>/orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
              <form method="post" action="<?= BASE_URL ?>/actions.php">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                  Sign out
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php else: ?>
        <a href="<?= BASE_URL ?>/login.php" class="p-2 text-gray-500 hover:text-black transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </a>
        <?php endif; ?>

        <!-- Mobile menu toggle -->
        <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-500 hover:text-black focus:outline-none">
          <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
    <div class="px-4 pt-2 pb-4 space-y-1">
      <a href="<?= BASE_URL ?>/index.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Home</a>
      <a href="<?= BASE_URL ?>/catalog.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Shop</a>
      <a href="<?= BASE_URL ?>/track.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Track Order</a>
      <a href="<?= BASE_URL ?>/about.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">About</a>
      <a href="<?= BASE_URL ?>/contact.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Contact</a>
      <?php if (!$current_user): ?>
      <a href="<?= BASE_URL ?>/login.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Sign In</a>
      <?php else: ?>
      <a href="<?= BASE_URL ?>/orders.php" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:text-black hover:bg-gray-50">Orders</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<script>
  const btn = document.getElementById('mobile-menu-btn');
  const menu = document.getElementById('mobile-menu');
  const menuIcon = document.getElementById('menu-icon');
  const closeIcon = document.getElementById('close-icon');
  btn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
  });
</script>

<main class="flex-1">
