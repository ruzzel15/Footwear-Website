<?php
$page_title = 'Track Order – Solemates';
require_once __DIR__ . '/includes/header.php';

// header already loaded config and data.php
ensure_orders_table();

$order = null;
$order_number = $_GET['order'] ?? ($_POST['order_number'] ?? '');

if ($order_number) {
    try {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM orders WHERE order_number = ?');
        $stmt->execute([$order_number]);
        $order = $stmt->fetch();
    } catch (Exception $e) {
        error_log('Track order error: ' . $e->getMessage());
    }
}
?>

<div class="bg-gray-50 min-h-screen py-10">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Track Your Order</h1>
      <p class="text-gray-500 mt-1">Enter your order number to see real-time delivery status.</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
      <form method="post" class="flex gap-2">
        <input 
          type="text" 
          name="order_number" 
          placeholder="Enter order number (e.g., ORD-001)" 
          value="<?= htmlspecialchars($order_number) ?>"
          class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
          required
        >
        <button type="submit" class="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800">
          Track
        </button>
      </form>
    </div>

    <?php if ($order_number && !$order): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
      <p class="text-red-700 font-medium">Order not found.</p>
      <p class="text-red-600 text-sm mt-1">Please check the order number and try again.</p>
    </div>
    <?php elseif ($order): ?>
    <!-- Order Found -->
    <div class="space-y-6">
      <!-- Status Timeline -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Delivery Status</h2>
        
        <?php
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        $statusLabels = [
          'pending' => 'Order Placed',
          'processing' => 'Processing',
          'shipped' => 'Shipped',
          'delivered' => 'Delivered'
        ];
        $currentStatusIndex = array_search($order['status'], $statuses);
        ?>

        <div class="flex items-center justify-between mb-8">
          <?php foreach ($statuses as $idx => $status): ?>
          <div class="flex flex-col items-center flex-1">
            <div class="<?php
              if ($idx < $currentStatusIndex) {
                echo 'bg-green-500 text-white';
              } elseif ($idx === $currentStatusIndex) {
                echo 'bg-blue-500 text-white';
              } else {
                echo 'bg-gray-200 text-gray-500';
              }
            ?> w-12 h-12 rounded-full flex items-center justify-center font-bold mb-3 text-lg">
              <?php
              if ($idx < $currentStatusIndex) {
                echo '✓';
              } elseif ($idx === $currentStatusIndex) {
                echo '→';
              } else {
                echo $idx + 1;
              }
              ?>
            </div>
            <p class="text-sm font-medium text-center text-gray-900"><?= $statusLabels[$status] ?></p>
          </div>
          <?php if ($idx < count($statuses) - 1): ?>
            <div class="flex-1 h-1 <?= $idx < $currentStatusIndex ? 'bg-green-500' : 'bg-gray-200' ?> mx-2 mb-8"></div>
          <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded p-4">
          <p class="text-blue-900 font-semibold"><?= ucfirst($order['status']) ?></p>
          <p class="text-blue-700 text-sm mt-1">
            <?php
            switch ($order['status']) {
              case 'pending':
                echo 'Your order has been received and is awaiting confirmation.';
                break;
              case 'processing':
                echo 'Your order is being prepared for shipment.';
                break;
              case 'shipped':
                echo 'Your order is on the way! You should receive it soon.';
                break;
              case 'delivered':
                echo 'Your order has been delivered. Thank you for your purchase!';
                break;
            }
            ?>
          </p>
        </div>
      </div>

      <!-- Order Details Card -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Details</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <p class="text-sm text-gray-500 uppercase">Order Number</p>
            <p class="text-lg font-medium text-gray-900 font-mono"><?= htmlspecialchars($order['order_number']) ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-500 uppercase">Order Date</p>
            <p class="text-lg font-medium text-gray-900"><?php
              $dateField = isset($order['ordered_at']) ? $order['ordered_at'] : $order['created_at'];
              echo date('M d, Y · g:i A', strtotime($dateField));
            ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-500 uppercase">Shipping Method</p>
            <p class="text-lg font-medium text-gray-900"><?= ucfirst($order['shipping_method']) ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-500 uppercase">Total Amount</p>
            <p class="text-lg font-medium text-gray-900">₱<?= number_format($order['total'], 2) ?></p>
          </div>
        </div>

        <div class="border-t border-gray-200 mt-6 pt-6">
          <p class="text-sm text-gray-500 uppercase mb-2">Shipping Address</p>
          <p class="text-gray-900"><?= htmlspecialchars($order['address'] ?? '') ?></p>
          <p class="text-gray-900"><?= htmlspecialchars($order['city'] ?? '' . ', ' . ($order['zip'] ?? '')) ?></p>
        </div>
      </div>

      <!-- Items Card -->
      <?php 
      $items = json_decode($order['items'] ?? '[]', true);
      if (!empty($items)):
      ?>
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Items in Order</h3>
        <div class="space-y-3">
          <?php foreach ($items as $item): ?>
          <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
            <div>
              <p class="font-medium text-gray-900"><?= htmlspecialchars($item['name'] ?? 'Item') ?></p>
              <p class="text-sm text-gray-600">Size: <?= htmlspecialchars($item['selected_size'] ?? 'N/A') ?> · Qty: <?= $item['quantity'] ?? 1 ?></p>
            </div>
            <p class="font-medium text-gray-900">₱<?= number_format($item['price'] * ($item['quantity'] ?? 1), 2) ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Help Section -->
      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <p class="text-yellow-900 font-semibold">💡 Need Help?</p>
        <p class="text-yellow-800 text-sm mt-2">
          If your order status hasn't updated in a while, please <a href="<?= BASE_URL ?>/contact.php" class="underline font-medium">contact us</a>.
        </p>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php';
