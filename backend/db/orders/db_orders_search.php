<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/showOrders.php';
    $searchTerm = $_GET['searchTerm'] ?? '';

    $query = "SELECT * FROM `024_order_view` WHERE product_name LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
    if (!$result) { // if query fails show error
        header("location: /student024/Shop/backend/views/orders.php?error=".urlencode("Error searching orders: " . mysqli_error($conn)));
        exit;
    }
    $orders =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($orders as $order) {
        showOrders($order);
    }  
 
?>