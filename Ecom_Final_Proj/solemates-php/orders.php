<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// only logged in users can see their orders
if (!isset($_SESSION['user'])) {
    $_SESSION['flash'] = ['type' => 'info', 'msg' => 'Please log in to view your orders.'];
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$page_title = 'My Orders – Solemates';
require_once __DIR__ . '/includes/header.php';

// now data.php is loaded, ensure orders table is up to date for column compatibility
ensure_orders_table();

// fetch orders for this customer by email
$orders = [];
try {
    $db = get_db();
    // determine which column to query
    $colsStmt = $db->query('SHOW COLUMNS FROM orders');
    $cols = array_column($colsStmt->fetchAll(), 'Field');
    $emailField = in_array('customer_email', $cols) ? 'customer_email' : 'email';
    $dateField = in_array('ordered_at', $cols) ? 'ordered_at' : 'created_at';

    $stmt = $db->prepare("SELECT * FROM orders WHERE $emailField = ? ORDER BY $dateField DESC");
    $stmt->execute([$_SESSION['user']['email']]);
    $orders = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Fetch customer orders error: ' . $e->getMessage());
}
?>

<div class="bg-gray-50 min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
    </div>

    <?php if (empty($orders)): ?>
      <div class="p-6 text-center text-gray-500">
        You haven't placed any orders yet.
      </div>
    <?php else: ?>
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($orders as $order): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($order['order_number']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  <?php
                    $items = json_decode($order['items'], true);
                    echo count($items) . ' item' . (count($items) !== 1 ? 's' : '');
                  ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₱<?= number_format($order['total'], 2) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 rounded text-sm font-medium
                    <?php
                      switch($order['status']) {
                        case 'pending': echo 'bg-yellow-100 text-yellow-800 border-yellow-300'; break;
                        case 'processing': echo 'bg-blue-100 text-blue-800 border-blue-300'; break;
                        case 'shipped': echo 'bg-purple-100 text-purple-800 border-purple-300'; break;
                        case 'delivered': echo 'bg-green-100 text-green-800 border-green-300'; break;
                        default: echo 'bg-gray-100 text-gray-800 border-gray-300';
                      }
                    ?>"><?= htmlspecialchars(ucfirst($order['status'])) ?></span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= date('M d, Y', strtotime($order['ordered_at'])) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <button onclick="showOrderDetails('<?= htmlspecialchars(json_encode($order)) ?>')" class="text-blue-600 hover:text-blue-900">View</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- reuse modal from admin but simpler -->
<div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white">
      <h3 class="text-lg font-semibold">Order Details</h3>
      <button onclick="closeOrderModal()" class="text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
    <div class="p-6 space-y-4" id="orderDetails"></div>
  </div>
</div>

<script>
function showOrderDetails(orderJson) {
  const order = JSON.parse(orderJson);
  const items = order.items ? JSON.parse(order.items) : [];
  
  // order status timeline
  const statusTimeline = [
    { status: 'pending', label: 'Order Placed', icon: '✓' },
    { status: 'processing', label: 'Processing', icon: '⚙' },
    { status: 'shipped', label: 'Shipped', icon: '📦' },
    { status: 'delivered', label: 'Delivered', icon: '✓' }
  ];
  
  const currentStatusIndex = statusTimeline.findIndex(s => s.status === order.status);
  
  let timelineHtml = '<div class="mb-6"><h4 class="font-medium text-gray-900 mb-4">Order Status</h4><div class="flex items-center justify-between">';
  
  statusTimeline.forEach((step, idx) => {
    const isComplete = idx <= currentStatusIndex;
    const isCurrent = idx === currentStatusIndex;
    timelineHtml += `
      <div class="flex flex-col items-center flex-1">
        <div class="${isComplete ? 'bg-green-500 text-white' : isCurrent ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500'} w-10 h-10 rounded-full flex items-center justify-center font-bold mb-2">
          ${step.icon}
        </div>
        <p class="text-xs font-medium text-center ${isComplete ? 'text-green-700' : isCurrent ? 'text-blue-700' : 'text-gray-500'}">${step.label}</p>
      </div>
      ${idx < statusTimeline.length - 1 ? `<div class="flex-1 h-1 ${isComplete && idx < currentStatusIndex ? 'bg-green-500' : 'bg-gray-200'} mx-1 mb-6"></div>` : ''}
    `;
  });
  
  timelineHtml += '</div></div>';
  
  let html = timelineHtml + `
    <div class="space-y-4">
      <div>
        <h4 class="font-medium text-gray-900">Order Number</h4>
        <p class="text-gray-700 font-mono">${order.order_number}</p>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Current Status</h4>
        <p class="text-gray-700 font-semibold text-lg">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</p>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Shipping Address</h4>
        <p class="text-gray-700">${order.address}<br>${order.city}, ${order.zip}</p>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Items Ordered</h4>
        <div class="space-y-2">
  `;
  
  for (const item of items) {
    html += `
      <div class="flex justify-between p-2 bg-gray-50 rounded">
        <div>
          <p class="font-medium">${item.name}</p>
          <p class="text-sm text-gray-600">Size: ${item.selected_size} × ${item.quantity}</p>
        </div>
        <p class="font-medium">₱${(item.price * item.quantity).toLocaleString('en-PH', {minimumFractionDigits: 2})}</p>
      </div>
    `;
  }
  
  html += `
        </div>
      </div>
      <div class="border-t pt-4">
        <div class="flex justify-between mb-2">
          <span>Subtotal</span>
          <span>₱${order.subtotal.toLocaleString('en-PH', {minimumFractionDigits: 0})}</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping (${order.shipping_method === 'express' ? 'Express' : 'Standard'})</span>
          <span>₱${order.shipping_cost.toLocaleString('en-PH', {minimumFractionDigits: 0})}</span>
        </div>
        <div class="flex justify-between font-bold text-lg border-t pt-2">
          <span>Total</span>
          <span>₱${order.total.toLocaleString('en-PH', {minimumFractionDigits: 0})}</span>
        </div>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Payment Method</h4>
        <p class="text-gray-700">${order.payment_method.charAt(0).toUpperCase() + order.payment_method.slice(1)}</p>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Order Date</h4>
        <p class="text-gray-700">${new Date(order.ordered_at).toLocaleString()}</p>
      </div>
    </div>
  `;
  document.getElementById('orderDetails').innerHTML = html;
  document.getElementById('orderModal').classList.remove('hidden');
}
function closeOrderModal() {
  document.getElementById('orderModal').classList.add('hidden');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php';
