<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/showProduct.php';
    // get search term from query parameter
    $searchTerm = $_GET['searchTerm'] ?? '';
    // prevent SQL injection
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
    // search products by name
    $query = "SELECT * FROM `024_products` WHERE `name` LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
    $products =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($products as $product) {
         showProduct($product);
    }  
 
?>