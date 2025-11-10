<?php
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id";
$result = mysqli_query($conn, $sql);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total_items = count($cart_items);
$cart_details = [];
$cart_total = 0;

if ($total_items > 0) {
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
        $product_result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($product_result);
        $item['name'] = $product['name'];
        $item['price'] = $product['price'];
        $cart_details[] = $item;

        $item_total = $item['price'] * $item['quantity'];
        $cart_total += $item_total;

        echo "<div class='product-card w-fit'>";
        echo "<h3>" . $item['name']  ."</h3>";
        echo "<p>Price: $" . $item['price'] . "</p>";
        echo "<span class='flex items-center gap-2'>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_update_remove_qty.php';
        echo "<p>Quantity: " . $item['quantity'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_update_add_qty.php';
        echo "</span>";
        echo "</div><hr>";
    }
}else {
    echo "<p>Your shopping cart is empty.</p>";
}





?>