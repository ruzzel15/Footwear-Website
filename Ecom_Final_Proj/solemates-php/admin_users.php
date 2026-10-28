<?php
$page_title = 'User Accounts – Solemates Admin';
require_once __DIR__ . '/includes/header.php';

if (empty($_SESSION['user']['is_admin'])) {
    echo '<div class="p-12 text-center"><p class="text-red-600 font-medium">Access denied. Admins only.</p><a href="' . BASE_URL . '/login.php" class="underline text-black">Sign in as admin</a></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// make sure table exists (helper already runs on actions but safe)
ensure_users_table();

// If the admin is logged in but not yet stored in DB (from pre-change sessions), add them automatically.
if (!empty($_SESSION['user']['email'])) {
    $sessionEmail = $_SESSION['user']['email'];
    if (!get_user_by_email($sessionEmail)) {
        // generate a dummy password since it's not used for session logins
        $dummy = bin2hex(random_bytes(8));
        create_user($_SESSION['user']['name'] ?? 'Admin', $sessionEmail, $dummy, !empty($_SESSION['user']['is_admin']));
    }
}

$users = get_all_users();

// if fetch returned empty but there are actually users in the table, show a warning for debugging
$user_count = 0;
try {
    $db = get_db();
    $stmt = $db->query('SELECT COUNT(*) as cnt FROM users');
    $user_count = $stmt->fetch()['cnt'] ?? 0;
} catch (Exception $e) {
    // ignore
}
?>

<div class="bg-gray-50 min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">User Accounts</h1>
        <p class="text-gray-500 mt-1">Browse and manage registered customers.</p>
      </div>
      <a href="<?= BASE_URL ?>/admin.php" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">← Back to Dashboard</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
      <?php if (empty($users)): ?>
      <div class="p-6 text-center text-gray-500">
        <?php if ($user_count > 0): ?>
        <p class="text-red-600 font-medium">Warning: the user table contains <?= $user_count ?> row<?= $user_count!==1?'s':'' ?> but none could be retrieved. Check error log.</p>
        <?php else: ?>
        No users found.
        <?php endif; ?>
      </div>
      <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($users as $user): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['name']) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= (int)$user['order_count'] ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <?php if (!empty($user['is_admin'])): ?>
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                <?php else: ?>
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">No</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                <form method="post" class="inline">
                  <input type="hidden" name="action" value="toggle_user_admin">
                  <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                  <?php if (!empty($user['is_admin'])): ?>
                    <button type="submit" name="make_admin" value="0" class="text-yellow-600 hover:text-yellow-800">Revoke</button>
                  <?php else: ?>
                    <button type="submit" name="make_admin" value="1" class="text-blue-600 hover:text-blue-800">Make Admin</button>
                  <?php endif; ?>
                </form>
                <form method="post" class="inline" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                  <input type="hidden" name="action" value="delete_user">
                  <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                  <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                </form>
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

<?php require_once __DIR__ . '/includes/footer.php';
