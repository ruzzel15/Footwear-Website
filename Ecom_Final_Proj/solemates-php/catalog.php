<?php
$page_title = 'Shop All Footwear – Solemates';
require_once __DIR__ . '/includes/header.php';

$current_category = $_GET['category'] ?? 'All';
$sort = $_GET['sort'] ?? 'newest';
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 20000;

// Get all products with database updates applied
$all_products = get_all_products_with_updates();

// Filter
$filtered = $all_products;
if ($current_category !== 'All') {
    $filtered = array_filter($filtered, fn($p) => $p['category'] === $current_category);
}
$filtered = array_filter($filtered, fn($p) => $p['price'] <= $max_price);
$filtered = array_values($filtered);

// Sort
if ($sort === 'price-low') {
    usort($filtered, fn($a, $b) => $a['price'] <=> $b['price']);
} elseif ($sort === 'price-high') {
    usort($filtered, fn($a, $b) => $b['price'] <=> $a['price']);
}
?>

<div class="bg-white min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-6 border-b border-gray-200">
      <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($current_category) ?> Collection</h1>
      <div class="mt-4 md:mt-0 flex items-center gap-4">
        <form method="get" id="sort-form">
          <input type="hidden" name="category" value="<?= htmlspecialchars($current_category) ?>">
          <input type="hidden" name="max_price" value="<?= $max_price ?>">
          <div class="relative">
            <select name="sort" onchange="document.getElementById('sort-form').submit()"
              class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-gray-500">
              <option value="newest" <?= $sort==='newest'?'selected':'' ?>>Newest Arrivals</option>
              <option value="price-low" <?= $sort==='price-low'?'selected':'' ?>>Price: Low to High</option>
              <option value="price-high" <?= $sort==='price-high'?'selected':'' ?>>Price: High to Low</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="flex gap-8 mt-8">
      <!-- Sidebar Filters -->
      <aside class="w-64 flex-shrink-0 hidden md:block">
        <div class="space-y-8 sticky top-24">
          <!-- Categories -->
          <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Categories</h3>
            <ul class="space-y-3">
              <?php foreach ($categories as $cat): ?>
              <li>
                <a href="<?= BASE_URL ?>/catalog.php?category=<?= urlencode($cat) ?>&sort=<?= $sort ?>&max_price=<?= $max_price ?>"
                  class="text-sm <?= $current_category===$cat ? 'font-bold text-black' : 'text-gray-600 hover:text-black' ?>">
                  <?= htmlspecialchars($cat) ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <!-- Price Range -->
          <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Price Range</h3>
            <form method="get" id="price-form">
              <input type="hidden" name="category" value="<?= htmlspecialchars($current_category) ?>">
              <input type="hidden" name="sort" value="<?= $sort ?>">
              <input type="range" name="max_price" min="0" max="20000" value="<?= $max_price ?>"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-black"
                oninput="document.getElementById('price-label').textContent=this.value"
                onchange="document.getElementById('price-form').submit()">
            </form>
            <div class="flex justify-between mt-2 text-sm text-gray-600">
              <span>$0</span>
              <span id="price-label">₱<?= $max_price ?></span>
            </div>
          </div>
          <?php if ($current_category !== 'All' || $max_price < 20000): ?>
          <a href="<?= BASE_URL ?>/catalog.php" class="text-sm text-black underline">Clear all filters</a>
          <?php endif; ?>
        </div>
      </aside>

      <!-- Product Grid -->
      <main class="flex-1">
        <?php if (count($filtered) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-10 gap-x-6">
          <?php foreach ($filtered as $product): ?>
          <?php include __DIR__ . '/includes/product_card.php'; ?>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-24">
          <h3 class="text-lg font-medium text-gray-900">No products found</h3>
          <p class="mt-1 text-gray-500">Try adjusting your filters.</p>
          <a href="<?= BASE_URL ?>/catalog.php" class="mt-4 inline-block text-black underline">Clear all filters</a>
        </div>
        <?php endif; ?>
      </main>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
