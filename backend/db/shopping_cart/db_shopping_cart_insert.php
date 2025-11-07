<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = 1;

    $sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $new_quantity = $row['quantity'] + 1;
        $update_sql = "UPDATE 024_shopping_cart SET quantity = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
        if(mysqli_query($conn, $update_sql)){
            header("Location: /student024/Shop/backend/products.php");
            exit();
        } else {
            echo "Error updating cart: " . mysqli_error($conn);
            exit();
        }
    }
    $sql = "INSERT INTO 024_shopping_cart (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)";
    $query = mysqli_query($conn, $sql);
   

    if($query){
        header("Location: /student024/Shop/backend/products.php");
        exit();
    } else {
        echo "Error al agregar al carrito: " . mysqli_error($conn);
    }
?>