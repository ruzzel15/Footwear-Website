<?php
require_once __DIR__ . '/includes/data.php';
$id = $_GET['id'] ?? '';
$product = get_product_by_id($id);
if (!$product) {
    $page_title = 'Product Not Found – Solemates';
    require_once __DIR__ . '/includes/header.php';
    echo '<div class="p-12 text-center"><p>Product not found. <a href="<?= BASE_URL ?>/catalog.php" class="underline">Back to shop</a></p></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
$page_title = htmlspecialchars($product['name']) . ' – Solemates';
require_once __DIR__ . '/includes/header.php';
?>

<div class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="<?= BASE_URL ?>/catalog.php" class="inline-flex items-center text-sm text-gray-500 hover:text-black mb-8">
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Back to Catalog
    </a>

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
      <!-- Image Gallery -->
      <div class="flex flex-col-reverse">
        <!-- Thumbnails -->
        <div class="hidden mt-6 w-full sm:block">
          <div class="grid grid-cols-4 gap-4">
            <?php foreach ($product['images'] as $idx => $img): ?>
            <button onclick="setImage('<?= htmlspecialchars($img) ?>', this)"
              class="thumb-btn relative h-24 bg-white rounded-md overflow-hidden border-2 <?= $idx===0?'border-black':'border-transparent' ?> hover:border-gray-400 focus:outline-none">
              <img src="<?= htmlspecialchars($img) ?>" alt="" class="w-full h-full object-cover">
            </button>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- Main Image -->
        <div class="w-full rounded-lg overflow-hidden bg-gray-100 h-[500px]">
          <img id="main-image" src="<?= htmlspecialchars($product['images'][0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
            class="w-full h-full object-cover object-center">
        </div>
      </div>

      <!-- Product Info -->
      <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900"><?= htmlspecialchars($product['name']) ?></h1>
        <div class="mt-3">
          <p class="text-3xl text-gray-900">₱<?= number_format($product['price'], 2) ?></p>
        </div>

        <!-- Stars -->
        <div class="mt-3 flex items-center">
          <div class="flex items-center text-yellow-400">
            <?php for($i=0;$i<5;$i++): ?>
            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <?php endfor; ?>
          </div>
          <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">117 reviews</a>
        </div>

        <div class="mt-6 text-base text-gray-700"><?= htmlspecialchars($product['description']) ?></div>

        <?php if (empty($_SESSION['user']['is_admin'])): ?>
        <!-- Size Selector -->
        <form method="post" action="<?= BASE_URL ?>/actions.php" id="add-cart-form">
          <input type="hidden" name="action" value="add_to_cart">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="hidden" name="size" id="selected-size-input" value="">
          <input type="hidden" name="redirect" value="<?= BASE_URL ?>/cart.php">

          <div class="mt-8">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-900">Size</h3>
              <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
            </div>
            <div class="grid grid-cols-4 gap-4 sm:grid-cols-6 lg:grid-cols-4 mt-4">
              <?php foreach ($product['sizes'] as $size): ?>
              <button type="button" onclick="selectSize(<?= $size ?>, this)"
                class="size-btn group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none border-gray-200 bg-white text-gray-900">
                <?= $size ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="mt-10">
            <button type="submit" id="add-to-cart-btn" disabled
              class="w-full flex items-center justify-center rounded-md border border-transparent py-3 px-8 text-base font-medium text-white bg-gray-300 cursor-not-allowed focus:outline-none">
              Select a size
            </button>
          </div>
        </form>
        <?php else: ?>
        <div class="mt-10 space-y-3">
          <div class="p-4 bg-gray-100 rounded-md border border-gray-300 text-center">
            <p class="text-gray-700 font-medium">Admin accounts cannot add products to cart.</p>
          </div>
          <button onclick="showEditProductModal()" class="w-full flex items-center justify-center rounded-md border border-transparent py-3 px-8 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
            ✏️ Edit Price & Images
          </button>
        </div>
        <?php endif; ?>

        <!-- Features -->
        <div class="mt-8 border-t border-gray-200 pt-8">
          <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.1 7.7A2 2 0 008.1 18h7.8a2 2 0 001.99-2.3L17 8M10 12v4m4-4v4"/></svg>
              <span class="text-sm text-gray-500">Free Shipping</span>
            </div>
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              <span class="text-sm text-gray-500">2 Year Warranty</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function setImage(src, btn) {
  document.getElementById('main-image').src = src;
  document.querySelectorAll('.thumb-btn').forEach(b => b.classList.replace('border-black','border-transparent'));
  btn.classList.replace('border-transparent','border-black');
}
function selectSize(size, btn) {
  document.getElementById('selected-size-input').value = size;
  document.querySelectorAll('.size-btn').forEach(b => {
    b.classList.remove('bg-black','text-white','border-transparent');
    b.classList.add('bg-white','text-gray-900','border-gray-200');
  });
  btn.classList.remove('bg-white','text-gray-900','border-gray-200');
  btn.classList.add('bg-black','text-white','border-transparent');
  const addBtn = document.getElementById('add-to-cart-btn');
  addBtn.disabled = false;
  addBtn.textContent = 'Add to bag';
  addBtn.classList.remove('bg-gray-300','cursor-not-allowed');
  addBtn.classList.add('bg-black','hover:bg-gray-800');
}
function showEditProductModal() {
  const product = <?= json_encode($product) ?>;
  document.getElementById('edit_product_price').value = product.price;
  document.getElementById('edit_product_images').value = product.images.join('\n');
  document.getElementById('editProductModal').classList.remove('hidden');
}
function closeEditProductModal() {
  document.getElementById('editProductModal').classList.add('hidden');
}
</script>

<!-- Edit Product Modal for Admins -->
<div id="editProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white">
      <h3 class="text-lg font-semibold">Edit Price & Images</h3>
      <button onclick="closeEditProductModal()" class="text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
    <form method="post" action="<?= BASE_URL ?>/admin_actions.php" class="p-6 space-y-4">
      <input type="hidden" name="action" value="update_product_details">
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <input type="hidden" name="redirect" value="<?= BASE_URL ?>/product.php?id=<?= $product['id'] ?>">
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Product Price (₱)</label>
        <input type="number" name="price" id="edit_product_price" required class="w-full border border-gray-300 rounded-md p-2" min="0" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Product Images (URL, one per line)</label>
        <textarea name="images" id="edit_product_images" rows="6" class="w-full border border-gray-300 rounded-md p-2 font-mono text-sm" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg"></textarea>
        <p class="text-xs text-gray-500 mt-1">Enter image URLs separated by new lines</p>
      </div>
      <div class="flex gap-3 justify-end pt-4 border-t">
        <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Changes</button>
      </div>
    </form>
  </div>
</div>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
