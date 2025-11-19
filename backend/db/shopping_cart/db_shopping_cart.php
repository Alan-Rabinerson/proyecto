<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'] ?? 0;
    $product_id = $_GET['product_id'] ?? 0;
    $action = $_GET['action'] ?? '';
    $quantity = $_GET['quantity'] ?? 0;
    $new_quantity = 0;

    if ($action == 'add'){
        $new_quantity = $quantity + 1;
    } elseif ($action == 'remove' && $quantity > 1){
        $new_quantity = $quantity - 1;
    }
    
    if ($new_quantity == 0){
        $query = "DELETE FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id";
        $result = mysqli_query($conn, $query);
    } else {
        $query = "UPDATE 024_shopping_cart SET `quantity` = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
        $result = mysqli_query($conn, $query);
    }

    if ($result){
        $sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id";
        $result = mysqli_query($conn, $sql);
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($products);
    }    
?>