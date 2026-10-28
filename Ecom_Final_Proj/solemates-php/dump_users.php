<?php
require_once __DIR__ . '/includes/config.php';
$db = get_db();
$stmt = $db->query('SHOW CREATE TABLE users');
var_dump($stmt->fetch());

$stmtOrders = $db->query('SHOW CREATE TABLE orders');
var_dump($stmtOrders->fetch());
$stmt2 = $db->query('SELECT * FROM users');
while ($r = $stmt2->fetch()) {
    var_dump($r);
}

// now call get_all_users helper
require_once __DIR__ . '/includes/data.php';
$all = get_all_users();
echo "get_all_users returned " . count($all) . " rows\n";
var_dump($all);
