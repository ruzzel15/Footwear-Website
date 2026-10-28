<?php
$page_title = 'Shopping Cart – Solemates';
require_once __DIR__ . '/includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = get_cart_total();
?>

<?php if (empty($cart)): ?>
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center py-12 sm:px-6 lg:px-8">
  <h2 class="text-3xl font-extrabold text-gray-900">Your cart is empty</h2>
  <p class="mt-2 text-gray-600">Looks like you haven't added any shoes yet.</p>
  <a href="<?= BASE_URL ?>/catalog.php" class="mt-6 px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-800">Start Shopping</a>
</div>

<?php else: ?>
<div class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-8">Shopping Cart</h1>

    <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
      <!-- Items -->
      <section class="lg:col-span-7">
        <ul class="border-t border-b border-gray-200 divide-y divide-gray-200">
          <?php foreach ($cart as $item): ?>
          <li class="flex py-6 sm:py-10">
            <div class="flex-shrink-0">
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
            </div>
            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
              <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                <div>
                  <div class="flex justify-between">
                    <h3 class="text-sm">
                      <a href="<?= BASE_URL ?>/product.php?id=<?= $item['id'] ?>" class="font-medium text-gray-700 hover:text-gray-800"><?= htmlspecialchars($item['name']) ?></a>
                    </h3>
                  </div>
                  <div class="mt-1 flex text-sm">
                    <p class="text-gray-500"><?= htmlspecialchars($item['category']) ?></p>
                    <p class="ml-4 border-l border-gray-200 pl-4 text-gray-500">Size: <?= $item['selected_size'] ?></p>
                  </div>
                  <p class="mt-1 text-sm font-medium text-gray-900">₱<?= number_format($item['price'], 2) ?></p>
                </div>

                <div class="mt-4 sm:mt-0 sm:pr-9">
                  <!-- Quantity -->
                  <form method="post" action="<?= BASE_URL ?>/actions.php" class="flex items-center border border-gray-300 rounded-md w-32">
                    <input type="hidden" name="action" value="update_quantity">
                    <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']) ?>">
                    <button type="submit" name="quantity" value="<?= $item['quantity'] - 1 ?>"
                      <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>
                      class="p-2 hover:bg-gray-100 disabled:opacity-50">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </button>
                    <span class="flex-1 text-center text-sm py-2"><?= $item['quantity'] ?></span>
                    <button type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>"
                      class="p-2 hover:bg-gray-100">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                  </form>

                  <!-- Remove -->
                  <div class="absolute top-0 right-0">
                    <form method="post" action="<?= BASE_URL ?>/actions.php">
                      <input type="hidden" name="action" value="remove_from_cart">
                      <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']) ?>">
                      <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- Order Summary -->
      <section class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
        <h2 class="text-lg font-medium text-gray-900">Order summary</h2>
        <dl class="mt-6 space-y-4">
          <div class="flex items-center justify-between">
            <dt class="text-sm text-gray-600">Subtotal</dt>
            <dd class="text-sm font-medium text-gray-900">₱<?= number_format($total, 2) ?></dd>
          </div>
          <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <dt class="text-sm text-gray-600">Shipping estimate</dt>
            <dd class="text-sm font-medium text-gray-900">Calculated at checkout</dd>
          </div>
          <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <dt class="text-base font-medium text-gray-900">Order total</dt>
            <dd class="text-base font-medium text-gray-900">₱<?= number_format($total, 2) ?></dd>
          </div>
        </dl>
        <div class="mt-6">
          <a href="<?= BASE_URL ?>/checkout.php"
            class="w-full bg-black border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-800 flex items-center justify-center gap-2">
            Proceed to Checkout
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </section>
    </div>
  </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
