<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $sql = "SELECT * FROM 024_products";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach($products as $product){
        $product_id = $product['product_id'];
        // Display product details
        echo "<div class='product-card mt-2'>";
        echo "<h3>" . $product['name']  ."</h3>";
        echo "<p>Price: $" . $product['price'] . "</p>";
        echo "<p>Description: " . $product['description'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_update_call.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_delete.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_insert.php';
        echo "</div><hr>";
    }

?>