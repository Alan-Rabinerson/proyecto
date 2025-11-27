<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

$customer_id = (int) $_SESSION['customer_id'];
$product_id = (int) $_POST['product_id'];
$size = $_POST['size'];
$quantity = 1;

// Check if product already in cart
$sql = "SELECT quantity FROM `024_shopping_cart` WHERE `customer_id` = $customer_id AND `product_id` = $product_id AND `size` = '$size'";
$result = mysqli_query($conn, $sql);

// server-side check stock for selected size
$stock_check_sql = "SELECT stock FROM 024_product_sizes WHERE product_id = $product_id AND size = '$size' LIMIT 1";
$stock_res = mysqli_query($conn, $stock_check_sql);
$stock_row = $stock_res ? mysqli_fetch_assoc($stock_res) : null;
$available_stock = $stock_row ? $stock_row['stock'] : 0;
if ($available_stock <= 0) {
    echo json_encode(['status'=>'error','message'=>'Selected size is out of stock']);
    exit;
}

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $current_qty = isset($row['quantity']) ? (int) $row['quantity'] : 0;
    $new_quantity = $current_qty + 1;

    $update_sql = "UPDATE `024_shopping_cart` SET quantity = $new_quantity WHERE `customer_id` = $customer_id AND product_id = $product_id AND `size` = '$size'";
    if (mysqli_query($conn, $update_sql)) {
        echo json_encode(['status' => 'ok', 'message' => 'Cantidad del producto '.$product_id.' actualizada a '.$new_quantity, 'product_id' => $product_id, 'quantity' => $new_quantity]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating cart: ' . mysqli_error($conn)]);
    }

} else {
    $insert_sql = "INSERT INTO `024_shopping_cart` (customer_id, product_id, quantity, size) VALUES ($customer_id, $product_id, $quantity, '$size')";
    $query = mysqli_query($conn, $insert_sql);
    if (!$query) {
        echo json_encode(['status' => 'error', 'message' => 'Error al agregar al carrito: ' . mysqli_error($conn)]);
    } else {
        echo json_encode(['status' => 'ok', 'message' => 'Producto '.$product_id.' añadido al carrito', 'product_id' => $product_id]);
    }
}
?>

