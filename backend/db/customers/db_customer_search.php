<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/showCustomers.php';
    $searchTerm = $_GET['searchTerm'] ?? '';

    $query = "SELECT * FROM `024_customers` WHERE `first_name` LIKE '%$searchTerm%' OR `last_name` LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
    if (!$result) { // if query fails show error
        header("Location: /student024/Shop/backend/views/customers.php?error=" . urlencode("Error searching customer: " . mysqli_error($conn)));
        exit;
    }
    $customers =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($customers as $customer) {
        showCustomer($customer);
    }  
 
?>