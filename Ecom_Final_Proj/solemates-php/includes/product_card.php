<div class="group relative product-card">
  <div class="relative w-full overflow-hidden rounded-md bg-gray-200 lg:h-80">
    <img src="<?= htmlspecialchars($product['images'][0]) ?>"
      alt="<?= htmlspecialchars($product['name']) ?>"
      class="h-full w-full object-cover object-center transition-opacity duration-300 group-hover:opacity-75 lg:h-full lg:w-full">
    <?php if ($product['featured']): ?>
    <div class="absolute top-2 left-2 bg-black text-white text-xs font-bold px-2 py-1 rounded">FEATURED</div>
    <?php endif; ?>
  </div>
  <div class="mt-4 flex justify-between">
    <div>
      <h3 class="text-sm font-medium text-gray-900">
        <a href="<?= BASE_URL ?>/product.php?id=<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></a>
      </h3>
      <p class="mt-1 text-sm text-gray-500"><?= htmlspecialchars($product['category']) ?></p>
    </div>
    <p class="text-sm font-medium text-gray-900">₱<?= number_format($product['price'], 2) ?></p>
  </div>
  <a href="<?= BASE_URL ?>/product.php?id=<?= $product['id'] ?>"
    class="card-btn mt-2 w-full flex items-center justify-center rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 opacity-0 transition-opacity">
    View Details
  </a>
</div>
