<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';  
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';

    $order_number = $_GET['order_number'];

    $sql = "DELETE FROM 024_orders_table WHERE order_number = $order_number";
    $result = mysqli_query($conn, $sql);
    if($result){
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Order with number " . $order_number . " deleted by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "delete" ,"order", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/my_orders.php?message=Order+deleted+successfully");
        exit();
    } else {
        header("Location: /student024/Shop/backend/views/my_orders.php?error=Failed+to+delete+order");
        exit();
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php'; 
?>