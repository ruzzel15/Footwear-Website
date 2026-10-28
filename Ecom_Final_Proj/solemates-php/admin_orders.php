<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$page_title = 'Customer Orders – Solemates Admin';

// MUST come before any header.php include or output
// Make sure orders schema is current
ensure_orders_table();

// Get filter before any output
$status_filter = $_GET['status'] ?? 'all';

// Handle status update BEFORE any output/header include
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'] ?? '';
    $new_status = $_POST['new_status'] ?? '';
    
    try {
        $db = get_db();
        $stmt = $db->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$new_status, $order_id]);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Order status updated!'];
        header('Location: ' . BASE_URL . '/admin_orders.php?status=' . $status_filter);
        exit;
    } catch (Exception $e) {
        error_log('Update status error: ' . $e->getMessage());
    }
}

// NOW include header after all header modifications
require_once __DIR__ . '/includes/header.php';

if (empty($_SESSION['user']['is_admin'])) {
    echo '<div class="p-12 text-center"><p class="text-red-600 font-medium">Access denied. Admins only.</p><a href="' . BASE_URL . '/login.php" class="underline text-black">Sign in as admin</a></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Ensure orders table exists
try {
    $db = get_db();
    $db->exec('CREATE TABLE IF NOT EXISTS orders (
        id INT PRIMARY KEY AUTO_INCREMENT,
        order_number VARCHAR(50) NOT NULL UNIQUE,
        customer_email VARCHAR(255) NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        address TEXT,
        city VARCHAR(100),
        zip VARCHAR(20),
        items JSON NOT NULL,
        subtotal INT,
        shipping_cost INT,
        total INT,
        payment_method VARCHAR(50),
        shipping_method VARCHAR(50),
        status VARCHAR(50) DEFAULT "pending",
        ordered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_email (customer_email),
        INDEX idx_status (status)
    )');
} catch (Exception $e) {
    error_log('Orders table error: ' . $e->getMessage());
}

// Fetch orders
$orders = [];
try {
    $db = get_db();
    
    if ($status_filter === 'all') {
        $stmt = $db->query('SELECT * FROM orders ORDER BY ordered_at DESC');
    } else {
        $stmt = $db->prepare('SELECT * FROM orders WHERE status = ? ORDER BY ordered_at DESC');
        $stmt->execute([$status_filter]);
    }
    
    $orders = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Fetch orders error: ' . $e->getMessage());
}
?>

<div class="bg-gray-50 min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Customer Orders</h1>
        <p class="text-gray-500 mt-1">Monitor and manage all customer orders.</p>
      </div>
      <a href="<?= BASE_URL ?>/admin.php" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">← Back to Dashboard</a>
    </div>

    <!-- Status Filter -->
    <div class="mb-6 flex gap-2 flex-wrap">
      <a href="<?= BASE_URL ?>/admin_orders.php?status=all" class="px-4 py-2 rounded-md <?= $status_filter === 'all' ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">All Orders</a>
      <a href="<?= BASE_URL ?>/admin_orders.php?status=pending" class="px-4 py-2 rounded-md <?= $status_filter === 'pending' ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">Pending</a>
      <a href="<?= BASE_URL ?>/admin_orders.php?status=processing" class="px-4 py-2 rounded-md <?= $status_filter === 'processing' ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">Processing</a>
      <a href="<?= BASE_URL ?>/admin_orders.php?status=shipped" class="px-4 py-2 rounded-md <?= $status_filter === 'shipped' ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">Shipped</a>
      <a href="<?= BASE_URL ?>/admin_orders.php?status=delivered" class="px-4 py-2 rounded-md <?= $status_filter === 'delivered' ? 'bg-black text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?>">Delivered</a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
      <?php if (empty($orders)): ?>
      <div class="p-6 text-center text-gray-500">
        No orders found.
      </div>
      <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orders as $order): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($order['order_number']) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php
                    if (!empty($order['customer_name'])) {
                        echo htmlspecialchars($order['customer_name']);
                    } else {
                        echo htmlspecialchars(trim(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '')));
                    }
                ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($order['customer_email'] ?? $order['email'] ?? '') ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                <?php 
                  $items = json_decode($order['items'] ?? '[]', true);
                  $countItems = is_array($items) ? count($items) : 0;
                  echo $countItems . ' item' . ($countItems !== 1 ? 's' : '');
                ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₱<?= number_format($order['total'], 2) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars(ucfirst($order['payment_method'])) ?></td>
              <td class="px-6 py-4 whitespace-nowrap">
                <form method="post" style="display:inline;">
                  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                  <input type="hidden" name="update_status" value="1">
                  <select name="new_status" onchange="this.form.submit()" class="px-2 py-1 rounded text-sm font-medium border
                    <?php
                      switch($order['status']) {
                        case 'pending': echo 'bg-yellow-100 text-yellow-800 border-yellow-300'; break;
                        case 'processing': echo 'bg-blue-100 text-blue-800 border-blue-300'; break;
                        case 'shipped': echo 'bg-purple-100 text-purple-800 border-purple-300'; break;
                        case 'delivered': echo 'bg-green-100 text-green-800 border-green-300'; break;
                        default: echo 'bg-gray-100 text-gray-800 border-gray-300';
                      }
                    ?>">
                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                    <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                  </select>
                </form>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= date('M d, Y', strtotime($order['ordered_at'])) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button onclick="showOrderDetails('<?= htmlspecialchars(json_encode($order)) ?>')" class="text-blue-600 hover:text-blue-900">View Details</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Order Details Modal -->
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
  
  let html = `
    <div class="space-y-4">
      <div>
        <h4 class="font-medium text-gray-900">Order Number</h4>
        <p class="text-gray-700">${order.order_number}</p>
      </div>
      <div>
        <h4 class="font-medium text-gray-900">Customer Information</h4>
        <p class="text-gray-700">${order.customer_name || (order.first_name + ' ' + order.last_name)}<br>${order.customer_email || order.email}</p>
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
