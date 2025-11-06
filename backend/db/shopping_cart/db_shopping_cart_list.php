<?php
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/db_connect.php';
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id";
$result = mysqli_query($conn, $sql);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total_items = count($cart_items);
$cart_details = [];
$cart_total = 0;


foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
    $product_result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($product_result);
    $item['product_name'] = $product['product_name'];
    $item['price'] = $product['price'];
    $cart_details[] = $item;

    echo "<div class='product-card'>";
    echo "<h3>" . $item['product_name']  ."</h3>";
    echo "<p>Price: $" . $item['price'] . "</p>";
    echo "<p>Quantity: " . $item['quantity'] . "</p>";
    echo "</div><hr>";
}

echo "<h3>Total Items: " . $total_items . "</h3>";
echo "<h3>Cart Total:" . $cart_total . "€ </h3>";

?>