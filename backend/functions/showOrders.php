<?php
    function showOrders($product) {
        $product_id = $product['product_id'];
        echo  "<div class='order-card'>" .
        "<h3>" . $product['name']  ."</h3>".
        "<p>Price: $" . $product['price'] . "</p>".
        "<p>Description: " . $product['description'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_update_call.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_delete.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_insert.php';
        echo "</div> <hr>";
    }
?>