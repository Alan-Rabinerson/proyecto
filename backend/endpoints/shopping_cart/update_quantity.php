<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';

$customer_id = 0;
if (isset($_SESSION['customer_id'])) {
    $customer_id = intval($_SESSION['customer_id']);
} elseif (isset($_POST['customer_id'])) {
    $customer_id = intval($_POST['customer_id']);
} elseif (isset($_COOKIE['username'])) {
    // Resolve customer_id from username cookie when session not present
    $username = mysqli_real_escape_string($conn, $_COOKIE['username']);
    $q = "SELECT customer_id FROM `024_customers` WHERE username = '" . $username . "' LIMIT 1";
    $r = mysqli_query($conn, $q);
    if ($r && mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_assoc($r);
        $customer_id = intval($row['customer_id']);
    }
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : '';
$delta = isset($_POST['delta']) ? intval($_POST['delta']) : 0;

if ($customer_id <= 0 || $product_id <= 0 || $delta == 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Update quantity
$sql = "SELECT quantity FROM `024_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "' LIMIT 1";
$res = mysqli_query($conn, $sql);
if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $new_q = intval($row['quantity']) + $delta;
    if ($new_q <= 0) {
        $del = "DELETE FROM `024_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "'";
        mysqli_query($conn, $del);
    } else {
        $upd = "UPDATE `024_shopping_cart` SET quantity = $new_q WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "'";
        mysqli_query($conn, $upd);
    }
    // Return refreshed cart
    include __DIR__ . '/get_cart.php';
    exit;
} else {
    // If no existing row and delta positive, insert
    if ($delta > 0) {
        $ins = "INSERT INTO `024_shopping_cart` (customer_id, product_id, quantity, size) VALUES ($customer_id, $product_id, $delta, '" . $size . "')";
        mysqli_query($conn, $ins);
        include __DIR__ . '/get_cart.php';
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Item not found']);
exit;

?>
