<?php
$page_title = 'Admin Dashboard – Solemates';
require_once __DIR__ . '/includes/header.php';

if (empty($_SESSION['user']['is_admin'])) {
    echo '<div class="p-12 text-center"><p class="text-red-600 font-medium">Access denied. Admins only.</p><a href="<?= BASE_URL ?>/login.php" class="underline text-black">Sign in as admin</a></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Get all products with database updates applied
$all_products = get_all_products_with_updates();

// Get actual order stats
$total_orders = 0;
$orders_today = 0;
$revenue_today = 0;
$total_users = 0; // count of registered users

try {
    $db = get_db();
    $stmt = $db->query('SELECT COUNT(*) as cnt FROM users');
    $row = $stmt->fetch();
    $total_users = $row['cnt'] ?? 0;
} catch (Exception $e) {
    // if table doesn't exist yet, ignore
}    

try {
    $db = get_db();
    // ensure orders schema is up-to-date
    ensure_orders_table();

    // determine date column for filtering
    $colsStmt = $db->query('SHOW COLUMNS FROM orders');
    $cols = array_column($colsStmt->fetchAll(), 'Field');
    $dateField = in_array('ordered_at', $cols) ? 'ordered_at' : 'created_at';

    // Get total orders
    $stmt = $db->query('SELECT COUNT(*) as count FROM orders');
    $total_orders = $stmt->fetch()['count'] ?? 0;
    
    // Get orders today
    $stmt = $db->query("SELECT COUNT(*) as count FROM orders WHERE DATE($dateField) = CURDATE()");
    $orders_today = $stmt->fetch()['count'] ?? 0;
    
    // Get revenue today
    $stmt = $db->query("SELECT SUM(total) as total FROM orders WHERE DATE($dateField) = CURDATE()");
    $revenue_result = $stmt->fetch();
    $revenue_today = $revenue_result['total'] ?? 0;
} catch (Exception $e) {
    error_log('Admin stats error: ' . $e->getMessage());
}
?>

<div class="bg-gray-50 min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>.</p>
      </div>
      <div class="flex gap-2">
        <a href="<?= BASE_URL ?>/admin_orders.php" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          View All Orders
        </a>
        <a href="<?= BASE_URL ?>/admin_users.php" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1116.951 6.475M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Manage Users
        </a>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <?php
      $stats = [
        ['label' => 'Total Products',  'value' => count($all_products), 'link' => BASE_URL . '/admin.php', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['label' => 'Registered Users', 'value' => $total_users,        'link' => BASE_URL . '/admin_users.php', 'icon' => 'M5.121 17.804A9 9 0 1116.951 6.475M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => 'Orders Today',    'value' => $orders_today,       'link' => BASE_URL . '/admin_orders.php', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Revenue Today',   'value' => '₱' . number_format($revenue_today, 0), 'link' => BASE_URL . '/admin_orders.php', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Total Orders',    'value' => $total_orders,       'link' => BASE_URL . '/admin_orders.php', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
      ];
      foreach ($stats as $stat): ?>
      <a href="<?= $stat['link'] ?>" class="bg-white rounded-lg shadow-sm p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $stat['icon'] ?>"/></svg>
        </div>
        <div>
          <p class="text-sm text-gray-500"><?= $stat['label'] ?></p>
          <p class="text-2xl font-bold text-gray-900"><?= $stat['value'] ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Product Inventory</h2>
        <button onclick="showAddModal()" class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">+ Add Product</button>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sizes</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($all_products as $product): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img src="<?= htmlspecialchars($product['images'][0]) ?>" class="w-10 h-10 rounded-md object-cover">
                  <a href="<?= BASE_URL ?>/product.php?id=<?= $product['id'] ?>" class="text-sm font-medium text-gray-900 hover:underline"><?= htmlspecialchars($product['name']) ?></a>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?= htmlspecialchars($product['category']) ?></span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱<?= number_format($product['price'], 2) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <?php if ($product['featured']): ?>
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                <?php else: ?>
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">No</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= implode(', ', $product['sizes']) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="<?= BASE_URL ?>/product.php?id=<?= $product['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                <button onclick="showEditModal(<?= htmlspecialchars(json_encode($product)) ?>)" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                <button onclick="confirmDelete('<?= $product['id'] ?>', '<?= htmlspecialchars($product['name']) ?>')" class="text-red-500 hover:text-red-700">Delete</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Product Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white">
      <h3 class="text-lg font-semibold">Add New Product</h3>
      <button onclick="closeAddModal()" class="text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
    <form method="post" action="<?= BASE_URL ?>/admin_actions.php" class="p-6 space-y-4">
      <input type="hidden" name="action" value="add_product">
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Product Name</label>
        <input type="text" name="name" required class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900 mb-1">Category</label>
          <select name="category" class="w-full border border-gray-300 rounded-md p-2">
            <option>Sneakers</option>
            <option>Running</option>
            <option>Casual</option>
            <option>Boots</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-900 mb-1">Price (₱)</label>
          <input type="number" name="price" required class="w-full border border-gray-300 rounded-md p-2">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-md p-2"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Image URL</label>
        <input type="url" name="image_url" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="featured" id="featured_add" class="rounded">
        <label for="featured_add" class="text-sm font-medium text-gray-900">Featured Product</label>
      </div>
      <div class="flex gap-3 justify-end pt-4 border-t">
        <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Add Product</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Product Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white">
      <h3 class="text-lg font-semibold">Edit Product</h3>
      <button onclick="closeEditModal()" class="text-gray-500 hover:text-black text-2xl">&times;</button>
    </div>
    <form method="post" action="<?= BASE_URL ?>/admin_actions.php" class="p-6 space-y-4">
      <input type="hidden" name="action" value="edit_product">
      <input type="hidden" name="product_id" id="edit_product_id">
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Product Name</label>
        <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900 mb-1">Category</label>
          <select name="category" id="edit_category" class="w-full border border-gray-300 rounded-md p-2">
            <option>Sneakers</option>
            <option>Running</option>
            <option>Casual</option>
            <option>Boots</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-900 mb-1">Price (₱)</label>
          <input type="number" name="price" id="edit_price" required class="w-full border border-gray-300 rounded-md p-2">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Description</label>
        <textarea name="description" id="edit_description" rows="3" class="w-full border border-gray-300 rounded-md p-2"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900 mb-1">Image URL</label>
        <input type="url" name="image_url" id="edit_image_url" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="featured" id="featured_edit" class="rounded">
        <label for="featured_edit" class="text-sm font-medium text-gray-900">Featured Product</label>
      </div>
      <div class="flex gap-3 justify-end pt-4 border-t">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg max-w-sm w-full">
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-lg font-semibold">Confirm Delete</h3>
    </div>
    <div class="p-6">
      <p class="text-gray-700">Are you sure you want to delete <strong id="delete_product_name"></strong>? This action cannot be undone.</p>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end">
      <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
      <form id="deleteForm" method="post" action="<?= BASE_URL ?>/admin_actions.php" style="display:inline;">
        <input type="hidden" name="action" value="delete_product">
        <input type="hidden" name="product_id" id="delete_product_id">
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
      </form>
    </div>
  </div>
</div>

<script>
  function showAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
  }
  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
  }
  function showEditModal(product) {
    document.getElementById('edit_product_id').value = product.id;
    document.getElementById('edit_name').value = product.name;
    document.getElementById('edit_category').value = product.category;
    document.getElementById('edit_price').value = product.price;
    document.getElementById('edit_description').value = product.description;
    document.getElementById('edit_image_url').value = product.images[0];
    document.getElementById('featured_edit').checked = product.featured;
    document.getElementById('editModal').classList.remove('hidden');
  }
  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
  function confirmDelete(productId, productName) {
    document.getElementById('delete_product_id').value = productId;
    document.getElementById('delete_product_name').textContent = productName;
    document.getElementById('deleteModal').classList.remove('hidden');
  }
  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
  }
</script>
