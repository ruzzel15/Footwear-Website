<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

// make sure users table exists for auth
ensure_users_table();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add_to_cart':
        $product_id = $_POST['product_id'] ?? '';
        $size = (int)($_POST['size'] ?? 0);
        $product = get_product_by_id($product_id);

        if ($product && $size) {
            $cart_id = $product_id . '-' . $size;
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

            if (isset($_SESSION['cart'][$cart_id])) {
                $_SESSION['cart'][$cart_id]['quantity']++;
            } else {
                $_SESSION['cart'][$cart_id] = [
                    'cart_id'       => $cart_id,
                    'id'            => $product['id'],
                    'name'          => $product['name'],
                    'category'      => $product['category'],
                    'price'         => $product['price'],
                    'image'         => $product['images'][0],
                    'selected_size' => $size,
                    'quantity'      => 1
                ];
            }
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Added ' . htmlspecialchars($product['name']) . ' to cart!'];
        }
        $redirect = $_POST['redirect'] ?? BASE_URL . '/product.php?id=' . $product_id;
        header('Location: ' . $redirect);
        exit;

    case 'remove_from_cart':
        $cart_id = $_POST['cart_id'] ?? '';
        if (isset($_SESSION['cart'][$cart_id])) {
            unset($_SESSION['cart'][$cart_id]);
        }
        header('Location: ' . BASE_URL . '/cart.php');
        exit;

    case 'update_quantity':
        $cart_id = $_POST['cart_id'] ?? '';
        $qty = (int)($_POST['quantity'] ?? 1);
        if ($qty < 1) $qty = 1;
        if (isset($_SESSION['cart'][$cart_id])) {
            $_SESSION['cart'][$cart_id]['quantity'] = $qty;
        }
        header('Location: ' . BASE_URL . '/cart.php');
        exit;

    case 'clear_cart':
        $_SESSION['cart'] = [];
        header('Location: ' . BASE_URL . '/index.php');
        exit;

    case 'login':
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email && $password) {
            $user = get_user_by_email($email);
            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    // valid credentials
                    $_SESSION['user'] = [
                        'name'     => $user['name'],
                        'email'    => $user['email'],
                        'is_admin' => !empty($user['is_admin'])
                    ];
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Welcome back, ' . htmlspecialchars($user['name']) . '!'];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Invalid email or password.'];
                    header('Location: ' . BASE_URL . '/login.php');
                    exit;
                }
            } else {
                // no user yet: behave like registration for convenience
                $nameFallback = explode('@', $email)[0] ?: 'Demo User';
                $is_admin = stripos($email, 'admin') !== false;
                create_user($nameFallback, $email, $password, $is_admin);
                $_SESSION['user'] = [
                    'name'     => $nameFallback,
                    'email'    => $email,
                    'is_admin' => $is_admin
                ];
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Account created automatically. Welcome, ' . htmlspecialchars($nameFallback) . '!'];
            }
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;

    case 'register':
        $email = trim($_POST['email'] ?? '');
        $name  = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email && $password) {
            $existing = get_user_by_email($email);
            if ($existing) {
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'An account with that email already exists.'];
            } else {
                // mark admin if admin substring present for demo
                $is_admin = stripos($email, 'admin') !== false;
                if (create_user($name ?: 'Demo User', $email, $password, $is_admin)) {
                    $_SESSION['user'] = [
                        'name'     => $name ?: 'Demo User',
                        'email'    => $email,
                        'is_admin' => $is_admin
                    ];
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Account created! Welcome, ' . htmlspecialchars($name ?: 'User') . '!'];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Error creating account.'];
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;

    case 'logout':
        $_SESSION['user'] = null;
        unset($_SESSION['user']);
        $_SESSION['flash'] = ['type' => 'info', 'msg' => 'Logged out successfully.'];
        header('Location: ' . BASE_URL . '/index.php');
        exit;

    case 'subscribe':
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Subscribed! Thank you.'];
        $redirect = $_POST['redirect'] ?? BASE_URL . '/index.php';
        header('Location: ' . $redirect);
        exit;

    default:
        header('Location: ' . BASE_URL . '/index.php');
        exit;
}
