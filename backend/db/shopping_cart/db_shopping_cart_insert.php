<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = 1;

    $sql = "INSERT INTO 024_shopping_cart (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)";
    $query = mysqli_query($conn, $sql);
    $cart = mysqli_fetch_assoc($query);

    if($cart){
        header("Location: /student024/Shop/backend/shopping_cart.php");
        exit();
    } else {
        echo "Error al agregar al carrito: " . mysqli_error($conn);
    }
?>