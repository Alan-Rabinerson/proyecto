<?php
    function showProduct($product) {
        $product_id = $product['product_id'];
        // fetch size availability
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
        $sizes = [];
        $psql = "SELECT size, stock FROM 024_product_sizes WHERE product_id = $product_id ORDER BY FIELD(size,'XS','S','M','L','XL','XXL')";
        $pres = mysqli_query($conn, $psql);
        if ($pres) {
            while ($prow = mysqli_fetch_assoc($pres)) {
                $sizes[$prow['size']] = (int)$prow['stock'];
            }
        }
        // Display product information
        echo  "<div class='product-card'>" .
        "<img src='/student024/Shop/assets/imagenes/foto" . $product_id . ".jpg' alt='" . $product['name'] . "' class='w-48 h-48 object-cover mb-2 rounded-lg shadow-md'>".
        "<h3>" . htmlspecialchars($product['name'])  ."</h3>".
        "<p>Price: $" . htmlspecialchars($product['price']) . "</p>".
        "<p>Description: " . htmlspecialchars($product['description']) . "</p>";
        if ($_SESSION['role'] === 'admin') {
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_update_call.php';
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/products/form_product_delete.php';
        }
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/shopping_cart/form_shopping_cart_insert.php';
        echo "</div> <hr>";
    }
?>