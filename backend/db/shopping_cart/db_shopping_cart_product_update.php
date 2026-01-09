<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    $sql = "UPDATE 024_shopping_cart SET quantity = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
    if(mysqli_query($conn, $sql)){
        if ($_SESSION['role'] == 'admin'){
            write_logJSON("Product " . $product_id . " updated in the shopping cart of customer " . $customer_id . " by admin " . $_SESSION['username'], "update" ,"shopping_cart", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/shopping_cart.php");
        exit();
    } else {
        echo "Error updating cart: " . mysqli_error($conn);
        exit();
    }
?>
