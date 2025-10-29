<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
echo "<h2>Shopping Cart</h2>";

include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/shopping_cart/db_shopping_cart_list.php';
?>
