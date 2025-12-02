<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';


$customer_id = 0;
if (isset($_SESSION['customer_id'])) {
    $customer_id = intval($_SESSION['customer_id']);
} elseif (isset($_GET['customer_id'])) {
    $customer_id = intval($_GET['customer_id']);
} elseif (isset($_COOKIE['username'])) {
    // Try to resolve customer_id from username cookie
    $username = mysqli_real_escape_string($conn, $_COOKIE['username']);
    $q = "SELECT customer_id FROM `024_customers` WHERE username = '" . $username . "' LIMIT 1";
    $r = mysqli_query($conn, $q);
    if ($r && mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_assoc($r);
        $customer_id = intval($row['customer_id']);
    }
}

if ($customer_id <= 0) {
    echo json_encode(['success' => true, 'items' => [], 'total' => 0]);
    exit;
}

$sql = "SELECT sc.product_id, sc.quantity, sc.size, p.name, p.price
        FROM `024_shopping_cart` sc
        LEFT JOIN `024_products` p ON sc.product_id = p.product_id
        WHERE sc.customer_id = " . $customer_id . " ORDER BY sc.shopping_cart_id ASC";

$result = mysqli_query($conn, $sql);
$items = [];
$total = 0;
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = intval($row['product_id']);
        $quantity = intval($row['quantity']);
        $price = floatval($row['price']);
        $subtotal = $price * $quantity;
        $total += $subtotal;

        $items[] = [
            'product_id' => $product_id,
            'name' => $row['name'],
            'price' => $price,
            'quantity' => $quantity,
            'size' => $row['size'],
            'subtotal' => $subtotal,
            'image' => '/student024/shop/assets/imagenes/foto' . $product_id . '.jpg'
        ];
    }
}

echo json_encode(['success' => true, 'items' => $items, 'total' => $total]);
exit;

?>
