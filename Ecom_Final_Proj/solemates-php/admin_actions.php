<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

// Redirect if not admin
if (empty($_SESSION['user']['is_admin'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

// Ensure product_updates table exists
function ensure_product_updates_table() {
    try {
        $db = get_db();
        $db->exec('CREATE TABLE IF NOT EXISTS product_updates (
            id INT PRIMARY KEY AUTO_INCREMENT,
            product_id VARCHAR(20) NOT NULL UNIQUE,
            price INT,
            images JSON,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )');
    } catch (Exception $e) {
        error_log('Table creation error: ' . $e->getMessage());
    }
}

// Ensure custom products table exists
function ensure_custom_products_table() {
    try {
        $db = get_db();
        $db->exec('CREATE TABLE IF NOT EXISTS custom_products (
            id INT PRIMARY KEY AUTO_INCREMENT,
            product_id VARCHAR(20) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            category VARCHAR(100),
            price INT,
            description TEXT,
            images JSON,
            sizes JSON,
            featured BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )');
    } catch (Exception $e) {
        error_log('Custom products table creation error: ' . $e->getMessage());
    }
}

// orders table migration is handled by ensure_orders_table() defined in data.php, which has already been required above
ensure_product_updates_table();
ensure_custom_products_table();
ensure_orders_table();
// ensure the users table exists so admins can manage accounts
ensure_users_table();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the next product ID
            $new_id = (string)(max(array_merge(
                array_map(fn($p) => (int)$p['id'], $products),
                [26] // Default to 26 if no products exist
            )) + 1);
            
            $new_product = [
                'id' => $new_id,
                'name' => $_POST['name'] ?? '',
                'category' => $_POST['category'] ?? 'Casual',
                'price' => (int)($_POST['price'] ?? 0),
                'description' => $_POST['description'] ?? '',
                'images' => [$_POST['image_url'] ?? 'https://via.placeholder.com/500'],
                'sizes' => [7, 8, 9, 10, 11],
                'featured' => isset($_POST['featured']) ? true : false
            ];
            
            // Save to database
            try {
                $db = get_db();
                $stmt = $db->prepare('INSERT INTO custom_products (product_id, name, category, price, description, images, sizes, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([
                    $new_product['id'],
                    $new_product['name'],
                    $new_product['category'],
                    $new_product['price'],
                    $new_product['description'],
                    json_encode($new_product['images']),
                    json_encode($new_product['sizes']),
                    $new_product['featured'] ? 1 : 0
                ]);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Product added successfully!'];
            } catch (Exception $e) {
                error_log('Add product error: ' . $e->getMessage());
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Error adding product.'];
            }
        }
        header('Location: ' . BASE_URL . '/admin.php');
        exit;

    case 'edit_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? '';
            
            $updated_product = [
                'id' => $product_id,
                'name' => $_POST['name'] ?? '',
                'category' => $_POST['category'] ?? 'Casual',
                'price' => (int)($_POST['price'] ?? 0),
                'description' => $_POST['description'] ?? '',
                'images' => [$_POST['image_url'] ?? 'https://via.placeholder.com/500'],
                'sizes' => [7, 8, 9, 10, 11],
                'featured' => isset($_POST['featured']) ? true : false
            ];
            
            // Update in database
            try {
                $db = get_db();
                
                // Check if this is already a custom product
                $stmt = $db->prepare('SELECT id FROM custom_products WHERE product_id = ?');
                $stmt->execute([$product_id]);
                $exists = $stmt->fetch();
                
                if ($exists) {
                    // Update existing custom product
                    $stmt = $db->prepare('UPDATE custom_products SET name = ?, category = ?, price = ?, description = ?, images = ?, sizes = ?, featured = ? WHERE product_id = ?');
                    $stmt->execute([
                        $updated_product['name'],
                        $updated_product['category'],
                        $updated_product['price'],
                        $updated_product['description'],
                        json_encode($updated_product['images']),
                        json_encode($updated_product['sizes']),
                        $updated_product['featured'] ? 1 : 0,
                        $product_id
                    ]);
                } else {
                    // Product doesn't exist in custom_products, check if it's a base product being edited for the first time
                    $is_base_product = false;
                    foreach ($products as $p) {
                        if ($p['id'] === $product_id) {
                            $is_base_product = true;
                            break;
                        }
                    }
                    
                    if ($is_base_product) {
                        // Base product being edited - save as custom product for full persistence
                        $stmt = $db->prepare('INSERT INTO custom_products (product_id, name, category, price, description, images, sizes, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                        $stmt->execute([
                            $product_id,
                            $updated_product['name'],
                            $updated_product['category'],
                            $updated_product['price'],
                            $updated_product['description'],
                            json_encode($updated_product['images']),
                            json_encode($updated_product['sizes']),
                            $updated_product['featured'] ? 1 : 0
                        ]);
                    }
                }
                
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Product updated successfully!'];
            } catch (Exception $e) {
                error_log('Edit product error: ' . $e->getMessage());
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Error updating product: ' . $e->getMessage()];
            }
        }
        header('Location: ' . BASE_URL . '/admin.php');
        exit;

    case 'delete_product':
        $product_id = $_POST['product_id'] ?? '';
        try {
            $db = get_db();
            $stmt = $db->prepare('DELETE FROM custom_products WHERE product_id = ?');
            $stmt->execute([$product_id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Product deleted successfully!'];
        } catch (Exception $e) {
            error_log('Delete product error: ' . $e->getMessage());
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Error deleting product.'];
        }
        header('Location: ' . BASE_URL . '/admin.php');
        exit;

    case 'update_product_details':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? '';
            $new_price = (int)($_POST['price'] ?? 0);
            $images_text = $_POST['images'] ?? '';
            $images = array_filter(array_map('trim', explode("\n", $images_text)));
            
            if (empty($images)) {
                $images = ['https://via.placeholder.com/500'];
            }
            
            try {
                $db = get_db();
                
                // Update database with changes
                $stmt = $db->prepare('INSERT INTO product_updates (product_id, price, images) VALUES (?, ?, ?)
                                    ON DUPLICATE KEY UPDATE price = ?, images = ?, updated_at = CURRENT_TIMESTAMP');
                $images_json = json_encode($images);
                $stmt->execute([$product_id, $new_price, $images_json, $new_price, $images_json]);
                
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Product details updated successfully!'];
            } catch (Exception $e) {
                error_log('Product update error: ' . $e->getMessage());
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Error updating product.'];
            }
            
            // Also update custom products in database for consistency
            try {
                $db = get_db();
                $stmt = $db->prepare('UPDATE custom_products SET price = ?, images = ? WHERE product_id = ?');
                $stmt->execute([$new_price, json_encode($images), $product_id]);
            } catch (Exception $e) {
                error_log('Update custom product error: ' . $e->getMessage());
            }
        }
        $redirect = $_POST['redirect'] ?? BASE_URL . '/admin.php';
        if (strpos($redirect, 'product.php?id=') !== false) {
            header('Location: ' . $redirect);
        } else {
            header('Location: ' . BASE_URL . '/product.php?id=' . urlencode($_POST['product_id'] ?? ''));
        }
        exit;

    // user management actions
    case 'toggle_user_admin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $new_role = !empty($_POST['make_admin']);
            if ($email) {
                update_user_admin_status($email, $new_role);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'User role updated.'];
            }
        }
        header('Location: ' . BASE_URL . '/admin_users.php');
        exit;

    case 'delete_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            if ($email) {
                delete_user_by_email($email);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'User deleted.'];
            }
        }
        header('Location: ' . BASE_URL . '/admin_users.php');
        exit;

    default:
        header('Location: ' . BASE_URL . '/admin.php');
        exit;
}
