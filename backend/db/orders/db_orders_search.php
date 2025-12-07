<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/sandbox/showOrders.php';
    $searchTerm = $_GET['searchTerm'] ?? '';

    $query = "SELECT * FROM `024_order_view` WHERE `name` LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
    if (!$result) { // if query fails show error
        header("location: /student024/shop/backend/views/orders.php?error=".urlencode("Error searching orders: " . mysqli_error($conn)));
        exit;
    }
    $orders =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($orders as $order) {
        showOrders($order);
    }  
 
?>