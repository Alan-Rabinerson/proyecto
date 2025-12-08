<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/functions/showProduct.php';
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