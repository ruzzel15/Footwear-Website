<?php

require_once __DIR__ . '/config.php';

$products = [
    [
        'id' => '1',
        'name' => 'Air Jordan Legacy 312',
        'category' => 'Sneakers',
        'price' => 9599,
        'description' => "The Air Jordan Legacy 312 celebrates Michael Jordan's legacy with this shout-out to Chicago's 312 area code. The design creates a modern mash-up of iconic Jordan elements.",
        'images' => [
            'https://images.unsplash.com/photo-1665517464780-ab4f42d8af95?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1600269452121-4f2416e55c28?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11, 12],
        'featured' => true
    ],
    [
        'id' => '2',
        'name' => 'Ultraboost Light',
        'category' => 'Running',
        'price' => 11399,
        'description' => 'Experience epic energy with the new Ultraboost Light, our lightest Ultraboost ever. The magic lies in the Light BOOST midsole, a new generation of adidas BOOST.',
        'images' => [
            'https://images.unsplash.com/photo-1719759674376-a001dc166cb6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10],
        'featured' => true
    ],
    [
        'id' => '3',
        'name' => 'Chuck 70 Vintage Canvas',
        'category' => 'Casual',
        'price' => 5099,
        'description' => 'The Chuck 70 is built off of the original 1970s design, with premium materials and an extraordinary attention to detail. A shoe so rooted in tradition that it has its own instant history.',
        'images' => [
            'https://images.unsplash.com/photo-1605973828881-d32d26aaf2ae?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1491553895911-0055eca6402d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '4',
        'name' => 'Heritage Moc Toe Boot',
        'category' => 'Boots',
        'price' => 17999,
        'description' => 'Modeled after the original work boot styles that made Red Wing famous, the 6-inch Moc Toe is a classic piece of footwear that\'s as stylish as it is durable.',
        'images' => [
            'https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1620857367352-7b6401083979?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [8, 9, 10, 11, 12, 13],
        'featured' => false
    ],
    [
        'id' => '5',
        'name' => 'Air Max 90',
        'category' => 'Sneakers',
        'price' => 7799,
        'description' => 'Nothing as fly, nothing as comfortable, nothing as proven. The Nike Air Max 90 stays true to its OG running roots with the iconic Waffle sole, stitched overlays and classic TPU accents.',
        'images' => [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1549298881-ceb66bb51e3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11, 12],
        'featured' => true
    ],
    [
        'id' => '6',
        'name' => 'Timberland 6-Inch Premium',
        'category' => 'Boots',
        'price' => 11899,
        'description' => 'When you think of Timberland boots, you\'re thinking of these. Our original waterproof boot was designed more than 40 years ago and remains a best-seller today.',
        'images' => [
            'https://images.unsplash.com/photo-1520639888713-78db11c0dd26?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1617691763432-8b45e6748b71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [8, 9, 10, 11, 12],
        'featured' => false
    ],
    [
        'id' => '7',
        'name' => 'Vans Old Skool',
        'category' => 'Casual',
        'price' => 4199,
        'description' => 'The Old Skool, the Vans classic skate shoe and first to bare the iconic sidestripe, is a low top lace-up featuring sturdy canvas and suede uppers.',
        'images' => [
            'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1563124803-7b567d710f76?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '8',
        'name' => 'Zoom Fly 5',
        'category' => 'Running',
        'price' => 9599,
        'description' => 'Bridge the gap between your weekend training run and race day in a durable design that can be deployed not just at the starting line of your favorite race, but in the days and months after your conquest.',
        'images' => [
            'https://images.unsplash.com/photo-1584735175315-9d5df23860e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1539185441755-769473a23570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11],
        'featured' => true
    ],
    [
        'id' => '9',
        'name' => 'New Balance 574',
        'category' => 'Running',
        'price' => 6499,
        'description' => "The most important sneaker model of the '80s is back. The New Balance 574 is both a running classic and a lifestyle staple.",
        'images' => [
            'https://images.unsplash.com/photo-1532989187890-e3dd20df2149?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1600181828372-e0c8d4f0a9b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '10',
        'name' => 'Puma RS-X Sneaker',
        'category' => 'Sneakers',
        'price' => 5799,
        'description' => 'The Puma RS-X is a chunky retro sneaker with 90s-inspired silhouette and contemporary cushioning technology.',
        'images' => [
            'https://images.unsplash.com/photo-1571902043202-36bb3e6e89f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1597045866519-bf8a3f3d0efb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '11',
        'name' => 'Adidas Stan Smith',
        'category' => 'Casual',
        'price' => 4899,
        'description' => 'The iconic Adidas Stan Smith is a timeless classic with clean minimalist design and all-day comfort.',
        'images' => [
            'https://images.unsplash.com/photo-1605973828881-d32d26aaf2ae?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10],
        'featured' => false
    ],
    [
        'id' => '12',
        'name' => 'Salomon Trail Runner',
        'category' => 'Running',
        'price' => 8999,
        'description' => 'Advanced trail running shoe with aggressive tread and lightweight responsive cushioning for off-road adventures.',
        'images' => [
            'https://images.unsplash.com/photo-1584735175315-9d5df23860e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '13',
        'name' => 'Dr. Martens 1460 Boot',
        'category' => 'Boots',
        'price' => 14999,
        'description' => 'The iconic Dr. Martens 1460 is an all-purpose, unisex boot known for its durability and distinctive yellow stitching.',
        'images' => [
            'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        'sizes' => [7, 8, 9, 10, 11, 12, 13],
        'featured' => false
    ],
    [
        'id' => '14',
        'name' => 'Nike Cortez',
        'category' => 'Casual',
        'price' => 6999,
        'description' => 'A Nike classic, the Cortez is a timeless icon with a bold retro silhouette and lightweight comfort for everyday wear.',
        'images' => [
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1448374312543-e280ac888acc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '15',
        'name' => 'Asics Gel-Lyte III',
        'category' => 'Running',
        'price' => 8299,
        'description' => 'The Asics Gel-Lyte III combines heritage running design with modern comfort technology and sleek aesthetics.',
        'images' => [
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1584735175315-9d5df23860e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '16',
        'name' => 'Converse Platform Chuck',
        'category' => 'Casual',
        'price' => 4599,
        'description' => 'The platform version of the iconic Chuck Taylor All Star with added height and retro style.',
        'images' => [
            'https://images.unsplash.com/photo-1605973828881-d32d26aaf2ae?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1491553895911-0055eca6402d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '17',
        'name' => 'Nike Revolution 7',
        'category' => 'Running',
        'price' => 4299,
        'description' => 'A lightweight and responsive running shoe with breathable mesh upper and cushioned midsole for everyday comfort.',
        'images' => [
            'https://images.unsplash.com/photo-1520693591840-c3400ca199e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11, 12],
        'featured' => false
    ],
    [
        'id' => '18',
        'name' => 'Levi\'s Canvas Sneaker',
        'category' => 'Casual',
        'price' => 3899,
        'description' => 'Casual canvas sneaker with durable construction and vintage aesthetic perfect for everyday wear.',
        'images' => [
            'https://images.unsplash.com/photo-1597045866519-bf8a3f3d0efb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1511884642898-4c92249e20b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '19',
        'name' => 'Columbia Trail Hiker',
        'category' => 'Boots',
        'price' => 9899,
        'description' => 'Rugged outdoor hiking boots with waterproof membrane and aggressive traction for trail adventures.',
        'images' => [
            'https://images.unsplash.com/photo-1559254269-2a1c9afc811b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1604552351864-297953f894c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [8, 9, 10, 11, 12, 13],
        'featured' => false
    ],
    [
        'id' => '20',
        'name' => 'Skechers Memory Foam',
        'category' => 'Casual',
        'price' => 4799,
        'description' => 'Comfort-focused casual shoe with memory foam insole for all-day support and relaxation.',
        'images' => [
            'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [5, 6, 7, 8, 9, 10, 11, 12],
        'featured' => false
    ],
    [
        'id' => '21',
        'name' => 'Saucony Endorphin Pro',
        'category' => 'Running',
        'price' => 16999,
        'description' => 'High-performance racing shoe with PWRRUN PB cushioning and carbon plate for competitive speed.',
        'images' => [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11],
        'featured' => true
    ],
    [
        'id' => '22',
        'name' => 'Palladium Pampa Hi',
        'category' => 'Boots',
        'price' => 6999,
        'description' => 'Iconic high-top canvas boot with ankle support and military heritage styling.',
        'images' => [
            'https://images.unsplash.com/photo-1568667256019-566f4a6bba38?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1529810313309-d58d0b3e20c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11, 12],
        'featured' => false
    ],
    [
        'id' => '23',
        'name' => 'HOKA ONE ONE Clifton',
        'category' => 'Running',
        'price' => 13499,
        'description' => 'Ultra-plush cushioning with lightweight design for maximum comfort on long-distance runs.',
        'images' => [
            'https://images.unsplash.com/photo-1542291906-e010c1d59f38?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [6, 7, 8, 9, 10, 11, 12],
        'featured' => true
    ],
    [
        'id' => '24',
        'name' => 'Ecco Golf PRO SL',
        'category' => 'Casual',
        'price' => 11299,
        'description' => 'Premium golf shoe with waterproof technology and superior traction on the greens.',
        'images' => [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11],
        'featured' => false
    ],
    [
        'id' => '25',
        'name' => 'Merrell Moab 2 Vent',
        'category' => 'Running',
        'price' => 7499,
        'description' => 'Hiking shoe with Vibram outsole and ventilated design for breathable trail performance.',
        'images' => [
            'https://images.unsplash.com/photo-1604552351864-297953f894c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1559254269-2a1c9afc811b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
        ],
        'sizes' => [7, 8, 9, 10, 11, 12],
        'featured' => false
    ]
];

$categories = ['All', 'Sneakers', 'Running', 'Casual', 'Boots'];

function get_product_by_id($id) {
    global $products;
    
    // Check custom products from database first
    try {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM custom_products WHERE product_id = ?');
        $stmt->execute([$id]);
        $custom = $stmt->fetch();
        
        if ($custom) {
            return [
                'id' => $custom['product_id'],
                'name' => $custom['name'],
                'category' => $custom['category'],
                'price' => (int)$custom['price'],
                'description' => $custom['description'],
                'images' => json_decode($custom['images'], true),
                'sizes' => json_decode($custom['sizes'], true),
                'featured' => (bool)$custom['featured']
            ];
        }
    } catch (Exception $e) {
        error_log('Check custom product error: ' . $e->getMessage());
    }
    
    // Find base product
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] === $id) {
            $product = $p;
            break;
        }
    }
    
    if ($product === null) {
        return null;
    }
    
    // Check database for updates
    try {
        $db = get_db();
        $stmt = $db->prepare('SELECT price, images FROM product_updates WHERE product_id = ?');
        $stmt->execute([$id]);
        $update = $stmt->fetch();
        
        if ($update) {
            if ($update['price'] !== null) {
                $product['price'] = (int)$update['price'];
            }
            if ($update['images'] !== null) {
                $decoded_images = json_decode($update['images'], true);
                if (is_array($decoded_images)) {
                    $product['images'] = $decoded_images;
                }
            }
        }
    } catch (Exception $e) {
        // Database query failed, continue with product as-is
        error_log('Get product error: ' . $e->getMessage());
    }
    
    return $product;
}

function get_all_products_with_updates() {
    global $products;
    
    $all_products = $products;
    
    // Add custom products from database
    try {
        $db = get_db();
        $stmt = $db->query('SELECT * FROM custom_products');
        $custom_products = $stmt->fetchAll();
        
        foreach ($custom_products as $custom) {
            $all_products[] = [
                'id' => $custom['product_id'],
                'name' => $custom['name'],
                'category' => $custom['category'],
                'price' => (int)$custom['price'],
                'description' => $custom['description'],
                'images' => json_decode($custom['images'], true),
                'sizes' => json_decode($custom['sizes'], true),
                'featured' => (bool)$custom['featured']
            ];
        }
    } catch (Exception $e) {
        error_log('Get custom products error: ' . $e->getMessage());
    }
    
    // Apply database updates to all products
    try {
        $db = get_db();
        $stmt = $db->query('SELECT product_id, price, images FROM product_updates');
        $updates = $stmt->fetchAll();
        
        if ($updates) {
            $update_map = [];
            foreach ($updates as $update) {
                $update_map[$update['product_id']] = $update;
            }
            
            foreach ($all_products as &$product) {
                if (!empty($update_map[$product['id']])) {
                    $update = $update_map[$product['id']];
                    if ($update['price'] !== null) {
                        $product['price'] = (int)$update['price'];
                    }
                    if ($update['images'] !== null) {
                        $decoded_images = json_decode($update['images'], true);
                        if (is_array($decoded_images)) {
                            $product['images'] = $decoded_images;
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        error_log('Get all products error: ' . $e->getMessage());
    }
    
    return $all_products;
}

function get_cart_total() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

function get_cart_count() {
    $count = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

// ensure orders table exists and attempt to migrate older schemas
function ensure_orders_table() {
    try {
        $db = get_db();
        // create base table if missing
        $db->exec('CREATE TABLE IF NOT EXISTS orders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            order_number VARCHAR(50) NOT NULL UNIQUE,
            customer_email VARCHAR(255),
            customer_name VARCHAR(255),
            address TEXT,
            city VARCHAR(100),
            zip VARCHAR(20),
            items JSON,
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

        // attempt simple migrations for existing tables
        $colsStmt = $db->query('SHOW COLUMNS FROM orders');
        $cols = array_column($colsStmt->fetchAll(), 'Field');

        if (!in_array('customer_email', $cols) && in_array('email', $cols)) {
            $db->exec('ALTER TABLE orders ADD COLUMN customer_email VARCHAR(255)');
            $db->exec('UPDATE orders SET customer_email = email');
        }
        if (!in_array('customer_name', $cols) && in_array('first_name', $cols) && in_array('last_name', $cols)) {
            $db->exec('ALTER TABLE orders ADD COLUMN customer_name VARCHAR(255)');
            $db->exec("UPDATE orders SET customer_name = CONCAT(first_name,' ',last_name)");
        }
        if (!in_array('items', $cols)) {
            $db->exec('ALTER TABLE orders ADD COLUMN items JSON');
        }
        if (!in_array('ordered_at', $cols) && in_array('created_at', $cols)) {
            $db->exec('ALTER TABLE orders ADD COLUMN ordered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
            $db->exec('UPDATE orders SET ordered_at = created_at');
        }
    } catch (Exception $e) {
        error_log('Ensure orders table error: ' . $e->getMessage());
    }
}

function save_order($order_number, $customer_email, $customer_name, $address, $city, $zip, $cart, $subtotal, $shipping_cost, $total, $payment_method, $shipping_method) {
    try {
        $db = get_db();
        
        // Ensure orders table exists (may already have been created by other parts of code)
        ensure_orders_table();

        // figure out which columns are available so we can insert compatibly
        $colsStmt = $db->query('SHOW COLUMNS FROM orders');
        $columns = array_column($colsStmt->fetchAll(), 'Field');

        $insertCols = ['order_number'];
        $placeholders = ['?'];
        $values = [$order_number];

        // email/customer_email compatibility
        if (in_array('customer_email', $columns)) {
            $insertCols[] = 'customer_email';
            $placeholders[] = '?';
            $values[] = $customer_email;
        }
        if (in_array('email', $columns)) {
            $insertCols[] = 'email';
            $placeholders[] = '?';
            $values[] = $customer_email;
        }

        // name compatibility
        if (in_array('customer_name', $columns)) {
            $insertCols[] = 'customer_name';
            $placeholders[] = '?';
            $values[] = $customer_name;
        } else {
            // split into first/last if possible
            if (in_array('first_name', $columns) && in_array('last_name', $columns)) {
                $parts = explode(' ', $customer_name, 2);
                $insertCols[] = 'first_name';
                $placeholders[] = '?';
                $values[] = $parts[0] ?: '';
                $insertCols[] = 'last_name';
                $placeholders[] = '?';
                $values[] = $parts[1] ?? '';
            }
        }

        // address, city, zip always exist in our schema and current DB
        if (in_array('address', $columns)) { $insertCols[]='address'; $placeholders[]='?'; $values[]=$address; }
        if (in_array('city', $columns))    { $insertCols[]='city';    $placeholders[]='?'; $values[]=$city; }
        if (in_array('zip', $columns))     { $insertCols[]='zip';     $placeholders[]='?'; $values[]=$zip; }

        // items may not exist
        $items_json = json_encode($cart);
        if (in_array('items', $columns)) {
            $insertCols[] = 'items';
            $placeholders[] = '?';
            $values[] = $items_json;
        }

        // numeric fields
        if (in_array('subtotal', $columns)) { $insertCols[]='subtotal'; $placeholders[]='?'; $values[]=$subtotal; }
        if (in_array('shipping_cost', $columns)) { $insertCols[]='shipping_cost'; $placeholders[]='?'; $values[]=$shipping_cost; }
        if (in_array('total', $columns)) { $insertCols[]='total'; $placeholders[]='?'; $values[]=$total; }
        if (in_array('payment_method', $columns)) { $insertCols[]='payment_method'; $placeholders[]='?'; $values[]=$payment_method; }
        if (in_array('shipping_method', $columns)) { $insertCols[]='shipping_method'; $placeholders[]='?'; $values[]=$shipping_method; }

        $sql = 'INSERT INTO orders (' . implode(', ', $insertCols) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        return true;
    } catch (Exception $e) {
        error_log('Save order error: ' . $e->getMessage());
        return false;
    }
}


// USER MANAGEMENT HELPERS
function ensure_users_table() {
    try {
        $db = get_db();
        // create base structure if missing
        $db->exec('CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            is_admin TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');

        // perform migrations for older schema
        $colsStmt = $db->query('SHOW COLUMNS FROM users');
        $cols = array_column($colsStmt->fetchAll(), 'Field');

        if (in_array('password', $cols) && !in_array('password_hash', $cols)) {
            // rename existing password column to password_hash
            $db->exec('ALTER TABLE users CHANGE password password_hash VARCHAR(255) NOT NULL');
        }
    } catch (Exception $e) {
        error_log('Users table creation error: ' . $e->getMessage());
    }
}

function get_user_by_email(string $email) {
    try {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        if ($row && isset($row['password']) && !isset($row['password_hash'])) {
            // old schema, alias password to password_hash
            $row['password_hash'] = $row['password'];
        }
        return $row;
    } catch (Exception $e) {
        error_log('Get user error: ' . $e->getMessage());
        return false;
    }
}

function create_user(string $name, string $email, string $password, bool $is_admin = false) {
    try {
        ensure_users_table();
        $db = get_db();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // check column names to build insert statement
        $colsStmt = $db->query('SHOW COLUMNS FROM users');
        $cols = array_column($colsStmt->fetchAll(), 'Field');
        $passCol = in_array('password_hash', $cols) ? 'password_hash' : 'password';

        $stmt = $db->prepare("INSERT INTO users (name, email, $passCol, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hash, $is_admin ? 1 : 0]);
        return true;
    } catch (Exception $e) {
        error_log('Create user error: ' . $e->getMessage());
        return false;
    }
}

function update_user_admin_status(string $email, bool $is_admin) {
    try {
        $db = get_db();
        $stmt = $db->prepare('UPDATE users SET is_admin = ? WHERE email = ?');
        $stmt->execute([$is_admin ? 1 : 0, $email]);
        return true;
    } catch (Exception $e) {
        error_log('Update user admin status error: ' . $e->getMessage());
        return false;
    }
}

function delete_user_by_email(string $email) {
    try {
        $db = get_db();
        $stmt = $db->prepare('DELETE FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return true;
    } catch (Exception $e) {
        error_log('Delete user error: ' . $e->getMessage());
        return false;
    }
}

function get_all_users() {
    try {
        ensure_users_table();
        $db = get_db();
        // if orders table uses email column instead of customer_email, switch accordingly
        $stmt = $db->query('SELECT u.*, (SELECT COUNT(*) FROM orders o WHERE o.email = u.email) AS order_count FROM users u ORDER BY created_at DESC');
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('Get all users error: ' . $e->getMessage());
        return [];
    }
}
