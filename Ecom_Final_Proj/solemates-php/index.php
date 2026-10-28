<?php
$page_title = 'Solemates – Step Into Your Perfect Sole';
require_once __DIR__ . '/includes/header.php';
$all_products = get_all_products_with_updates();
$featured = array_filter($all_products, fn($p) => $p['featured']);
?>

<!-- Hero -->
<div class="relative bg-gray-900 h-[600px] flex items-center overflow-hidden">
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1767589325064-a20f42c1da11?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080"
      alt="Hero Background" class="w-full h-full object-cover opacity-60">
  </div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
      <span class="block">Step Into Your</span>
      <span class="block text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-600">Perfect Sole</span>
    </h1>
    <p class="mt-4 text-xl text-gray-300 max-w-lg">Discover the latest collection of premium footwear designed for comfort, style, and performance.</p>
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center sm:justify-start">
      <a href="<?= BASE_URL ?>/catalog.php" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-100 md:py-4 md:text-lg md:px-10 flex items-center justify-center gap-2">
        Shop Now
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
      <a href="<?= BASE_URL ?>/catalog.php?category=Running" class="px-8 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-gray-900 md:py-4 md:text-lg md:px-10 transition-colors">View Collection</a>
    </div>
  </div>
</div>

<!-- Featured Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
  <div class="flex justify-between items-end mb-8">
    <div>
      <h2 class="text-3xl font-bold tracking-tight text-gray-900">Featured Kicks</h2>
      <p class="mt-2 text-gray-500">Curated selection just for you.</p>
    </div>
    <a href="<?= BASE_URL ?>/catalog.php" class="text-black font-medium hover:underline flex items-center gap-1">
      View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-6 xl:gap-x-8">
    <?php foreach ($featured as $product): ?>
    <?php include __DIR__ . '/includes/product_card.php'; ?>
    <?php endforeach; ?>
  </div>
</div>

<!-- Categories -->
<div class="bg-gray-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Shop by Category</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
      $cats = [
        ['name' => 'Sneakers', 'img' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'],
        ['name' => 'Running',  'img' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'],
        ['name' => 'Boots',    'img' => 'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'],
      ];
      foreach ($cats as $cat): ?>
      <a href="<?= BASE_URL ?>/catalog.php?category=<?= urlencode($cat['name']) ?>" class="group relative rounded-lg overflow-hidden h-64 block">
        <img src="<?= $cat['img'] ?>" alt="<?= $cat['name'] ?>"
          class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors flex items-center justify-center">
          <span class="text-white text-2xl font-bold tracking-wider"><?= $cat['name'] ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
