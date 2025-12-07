<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $sql = "SELECT * FROM 024_products";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach($products as $product){
        $product_id = $product['product_id'];
        // Display product details
        echo "<div class='product-card mt-2'>";
        echo "<img src='/student024/Shop/assets/imagenes/foto" . $product_id . ".jpg' alt='" . $product['name'] . "' class='w-48 h-48 object-cover mb-2 rounded-lg shadow-md'>";
        echo "<h3>" . $product['name']  ."</h3>";
        echo "<p>Price: $" . $product['price'] . "</p>";
        echo "<p>Description: " . $product['description'] . "</p>";
        if ($_SESSION['role'] === 'admin') {
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_update_call.php';
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_delete.php';
        }
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_insert.php';
        echo "</div><hr>";
    }

?>