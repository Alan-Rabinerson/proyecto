<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'] ?? 0;
    
    $query = "UPDATE 024_shopping_cart SET `quantity` = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = mysqli_query($conn, $query);
    if ($result){
        $sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id";
        $result = mysqli_query($conn, $sql);
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($products);
    }    
?>