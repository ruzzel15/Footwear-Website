<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect to login if not authenticated (BEFORE header output)
if (!isset($_SESSION['user'])) {
    $_SESSION['flash'] = ['type' => 'info', 'msg' => 'Please log in to proceed with checkout.'];
    header('Location: ' . (defined('BASE_URL') ? BASE_URL : '/') . '/login.php');
    exit;
}

$page_title = 'Checkout – Solemates';
require_once __DIR__ . '/includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$subtotal = get_cart_total();

// Handle POST (step advance)
$step = (int)($_POST['step'] ?? $_GET['step'] ?? 1);
$shipping_method = $_POST['shipping_method'] ?? $_SESSION['checkout']['shipping_method'] ?? 'standard';
$shipping_cost = $shipping_method === 'express' ? 15 : 0;
$total = $subtotal + $shipping_cost;
$form_data = $_SESSION['checkout']['form_data'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['next_step'])) {
    // Persist form data
    $form_data = array_merge($form_data, array_intersect_key($_POST, array_flip(['email','firstName','lastName','address','city','zip','paymentMethod'])));
    $_SESSION['checkout']['form_data'] = $form_data;
    $_SESSION['checkout']['shipping_method'] = $shipping_method;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $order_num = 'SLM-' . rand(10000, 99999);
    
    // Prepare order data from session
    // prefer session user details when available so orders are linked to the account
    $customer_email = $_SESSION['user']['email'] ?? ($form_data['email'] ?? 'unknown@example.com');
    if (!empty($_SESSION['user']['name'])) {
        $customer_name = $_SESSION['user']['name'];
    } else {
        $customer_name = ($form_data['firstName'] ?? 'Customer') . ' ' . ($form_data['lastName'] ?? 'User');
    }
    $address = $form_data['address'] ?? '';
    $city = $form_data['city'] ?? '';
    $zip = $form_data['zip'] ?? '';
    $payment_method = $_POST['paymentMethod'] ?? 'card';
    
    // Save order to database
    save_order($order_num, $customer_email, $customer_name, $address, $city, $zip, $cart, $subtotal, $shipping_cost, $total, $payment_method, $shipping_method);
    
    $_SESSION['cart'] = [];
    unset($_SESSION['checkout']);
    $page_title = 'Order Confirmed – Solemates';
?>
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center px-4">
  <svg class="w-20 h-20 text-green-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
  </svg>
  <h1 class="text-3xl font-bold text-gray-900">Order Confirmed!</h1>
  <p class="mt-2 text-gray-600 text-center">Thank you for shopping with Solemates. Your order #<?= $order_num ?> is on its way.</p>
  <a href="<?= BASE_URL ?>/index.php" class="mt-8 px-8 py-3 bg-black text-white rounded-md hover:bg-gray-800">Return to Home</a>
</div>
<?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

if (empty($cart)): ?>
<div class="p-12 text-center text-gray-600">Your cart is empty. <a href="<?= BASE_URL ?>/catalog.php" class="underline">Start shopping</a>.</div>
<?php require_once __DIR__ . '/includes/footer.php'; exit; endif;
?>

<div class="bg-gray-50 min-h-screen py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Checkout</h1>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
      <!-- Steps / Form -->
      <div class="lg:col-span-7 bg-white p-6 rounded-lg shadow-sm">

        <!-- Step Indicators -->
        <div class="flex justify-between mb-8 border-b border-gray-200 pb-4">
          <?php foreach (['Information', 'Shipping', 'Payment'] as $i => $label): ?>
          <?php $n = $i+1; $active = $step >= $n; ?>
          <div class="flex flex-col items-center <?= $active?'text-black':'text-gray-400' ?>">
            <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 mb-1 <?= $active?'border-black bg-black text-white':'border-gray-300' ?>"><?= $n ?></div>
            <span class="text-xs font-medium"><?= $label ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Step 1: Information -->
        <?php if ($step === 1): ?>
        <form method="post">
          <input type="hidden" name="step" value="1">
          <input type="hidden" name="next_step" value="1">
          <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>
            <input type="email" name="email" placeholder="Email address" required value="<?= htmlspecialchars($_SESSION['user']['email'] ?? $form_data['email'] ?? '') ?>"
              class="block w-full border-gray-300 rounded-md shadow-sm p-3 border focus:ring-black focus:border-black">
            <h2 class="text-lg font-medium text-gray-900 mt-6">Shipping Address</h2>
            <div class="grid grid-cols-2 gap-4">
              <input type="text" name="firstName" placeholder="First Name" required value="<?= htmlspecialchars($form_data['firstName'] ?? '') ?>" class="block w-full border-gray-300 rounded-md p-3 border">
              <input type="text" name="lastName" placeholder="Last Name" required value="<?= htmlspecialchars($form_data['lastName'] ?? '') ?>" class="block w-full border-gray-300 rounded-md p-3 border">
            </div>
            <input type="text" name="address" placeholder="Address" required value="<?= htmlspecialchars($form_data['address'] ?? '') ?>" class="block w-full border-gray-300 rounded-md p-3 border">
            <div class="grid grid-cols-2 gap-4">
              <input type="text" name="city" placeholder="City" required value="<?= htmlspecialchars($form_data['city'] ?? '') ?>" class="block w-full border-gray-300 rounded-md p-3 border">
              <input type="text" name="zip" placeholder="ZIP / Postal Code" required value="<?= htmlspecialchars($form_data['zip'] ?? '') ?>" class="block w-full border-gray-300 rounded-md p-3 border">
            </div>
            <a href="<?= BASE_URL ?>/checkout.php?step=2" onclick="this.closest('form').submit(); return false;"
              class="hidden"></a>
            <button type="submit" formaction="<?= BASE_URL ?>/checkout.php?step=2" name="step" value="2"
              class="w-full mt-6 bg-black text-white py-3 rounded-md hover:bg-gray-800">Continue to Shipping</button>
          </div>
        </form>

        <?php elseif ($step === 2): ?>
        <form method="post" action="<?= BASE_URL ?>/checkout.php?step=3">
          <input type="hidden" name="step" value="3">
          <input type="hidden" name="next_step" value="1">
          <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-900">Shipping Method</h2>
            <label class="block border rounded-md p-4 flex items-center justify-between cursor-pointer <?= $shipping_method==='standard'?'border-black ring-1 ring-black':'border-gray-200' ?>">
              <div class="flex items-center gap-3">
                <input type="radio" name="shipping_method" value="standard" <?= $shipping_method==='standard'?'checked':'' ?> class="sr-only">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.1 7.7A2 2 0 008.1 18h7.8a2 2 0 001.99-2.3L17 8"/></svg>
                <div>
                  <p class="font-medium">Standard Shipping</p>
                  <p class="text-sm text-gray-500">5-7 Business Days</p>
                </div>
              </div>
              <span class="font-bold">Free</span>
            </label>
            <label class="block border rounded-md p-4 flex items-center justify-between cursor-pointer <?= $shipping_method==='express'?'border-black ring-1 ring-black':'border-gray-200' ?>">
              <div class="flex items-center gap-3">
                <input type="radio" name="shipping_method" value="express" <?= $shipping_method==='express'?'checked':'' ?> class="sr-only">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <div>
                  <p class="font-medium">Express Shipping</p>
                  <p class="text-sm text-gray-500">1-2 Business Days</p>
                </div>
              </div>
              <span class="font-bold">$15.00</span>
            </label>
            <div class="flex gap-4 mt-6">
              <a href="<?= BASE_URL ?>/checkout.php?step=1" class="w-full py-3 border border-gray-300 rounded-md hover:bg-gray-50 text-center">Back</a>
              <button type="submit" class="w-full bg-black text-white py-3 rounded-md hover:bg-gray-800">Continue to Payment</button>
            </div>
          </div>
        </form>
        <script>
          document.querySelectorAll('input[name="shipping_method"]').forEach(r => {
            r.addEventListener('change', () => {
              document.querySelectorAll('label').forEach(l => {
                l.classList.remove('border-black','ring-1','ring-black');
                l.classList.add('border-gray-200');
              });
              r.closest('label').classList.add('border-black','ring-1','ring-black');
              r.closest('label').classList.remove('border-gray-200');
            });
          });
        </script>

        <?php elseif ($step === 3): ?>
        <form method="post" action="<?= BASE_URL ?>/checkout.php">
          <input type="hidden" name="place_order" value="1">
          <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-900">Payment</h2>
            <div class="space-y-2">
              <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                <input type="radio" name="paymentMethod" value="card" checked class="accent-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Credit / Debit Card
              </label>
              <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                <input type="radio" name="paymentMethod" value="gcash" class="accent-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                GCash
              </label>
              <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                <input type="radio" name="paymentMethod" value="maya" class="accent-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                Maya
              </label>
              <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                <input type="radio" name="paymentMethod" value="cod" class="accent-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                Cash on Delivery (COD)
              </label>
            </div>
            <div id="card-fields" class="p-4 bg-gray-50 rounded-md space-y-4 border border-gray-100">
              <input type="text" placeholder="Card Number" class="block w-full border-gray-300 rounded-md p-3 border">
              <div class="grid grid-cols-2 gap-4">
                <input type="text" placeholder="MM / YY" class="block w-full border-gray-300 rounded-md p-3 border">
                <input type="text" placeholder="CVC" class="block w-full border-gray-300 rounded-md p-3 border">
              </div>
            </div>
            <div id="gcash-fields" class="p-4 bg-gray-50 rounded-md space-y-4 border border-gray-100 hidden">
              <p class="text-sm text-gray-700 font-medium">GCash Payment Instructions</p>
              <p class="text-sm text-gray-600">Send payment to: <strong>09XX-XXX-XXXX</strong></p>
              <p class="text-sm text-gray-600">Reference: Your order number will be provided after placing the order.</p>
              <input type="text" placeholder="GCash Recipient Name" class="block w-full border-gray-300 rounded-md p-3 border">
            </div>
            <div id="maya-fields" class="p-4 bg-gray-50 rounded-md space-y-4 border border-gray-100 hidden">
              <p class="text-sm text-gray-700 font-medium">Maya Payment Instructions</p>
              <p class="text-sm text-gray-600">Send payment to: <strong>09XX-XXX-XXXX</strong></p>
              <p class="text-sm text-gray-600">Reference: Your order number will be provided after placing the order.</p>
              <input type="text" placeholder="Maya Account Name" class="block w-full border-gray-300 rounded-md p-3 border">
            </div>
            <div id="cod-fields" class="p-4 bg-blue-50 rounded-md space-y-2 border border-blue-100 hidden">
              <p class="text-sm font-medium text-blue-900">Cash on Delivery</p>
              <p class="text-sm text-blue-700">Pay directly to the delivery driver when your order arrives.</p>
            </div>
            <div class="flex gap-4 mt-6">
              <a href="<?= BASE_URL ?>/checkout.php?step=2" class="w-full py-3 border border-gray-300 rounded-md hover:bg-gray-50 text-center">Back</a>
              <button type="submit" class="w-full bg-black text-white py-3 rounded-md hover:bg-gray-800">Place Order</button>
            </div>
          </div>
        </form>
        <script>
          function togglePaymentFields() {
            const method = document.querySelector('input[name="paymentMethod"]:checked').value;
            document.getElementById('card-fields').style.display = method === 'card' ? 'block' : 'none';
            document.getElementById('gcash-fields').style.display = method === 'gcash' ? 'block' : 'none';
            document.getElementById('maya-fields').style.display = method === 'maya' ? 'block' : 'none';
            document.getElementById('cod-fields').style.display = method === 'cod' ? 'block' : 'none';
          }
          document.querySelectorAll('input[name="paymentMethod"]').forEach(r => {
            r.addEventListener('change', togglePaymentFields);
          });
          // Initialize on page load
          togglePaymentFields();
        </script>
        <?php endif; ?>
      </div>

      <!-- Order Summary Sidebar -->
      <div class="lg:col-span-5 mt-8 lg:mt-0">
        <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24">
          <h2 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h2>
          <ul class="-my-4 divide-y divide-gray-200">
            <?php foreach ($cart as $item): ?>
            <li class="flex py-4">
              <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="h-full w-full object-cover object-center">
              </div>
              <div class="ml-4 flex flex-1 flex-col">
                <div class="flex justify-between text-base font-medium text-gray-900">
                  <h3><?= htmlspecialchars($item['name']) ?></h3>
                  <p>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                </div>
                <p class="mt-1 text-sm text-gray-500">Qty <?= $item['quantity'] ?></p>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
          <dl class="mt-6 space-y-4 border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between">
              <dt class="text-sm text-gray-600">Subtotal</dt>
              <dd class="text-sm font-medium text-gray-900">₱<?= number_format($subtotal, 2) ?></dd>
            </div>
            <div class="flex items-center justify-between">
              <dt class="text-sm text-gray-600">Shipping</dt>
              <dd class="text-sm font-medium text-gray-900"><?= $shipping_cost === 0 ? 'Free' : '₱' . number_format($shipping_cost, 2) ?></dd>
            </div>
            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
              <dt class="text-base font-bold text-gray-900">Total</dt>
              <dd class="text-base font-bold text-gray-900">₱<?= number_format($total, 2) ?></dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
