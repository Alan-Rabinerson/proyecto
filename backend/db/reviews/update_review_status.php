<?php
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
session_start();
if (isset($_POST['status']) && isset($_POST['product_id']) && isset($_POST['customer_id']) && isset($_POST['order_number'])) {
    $status = $_POST['status'];
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $order_number = $_POST['order_number'];

    $sql = "UPDATE 024_reviews SET status = '$status' WHERE product_id = $product_id AND customer_id = $customer_id AND order_number = '$order_number'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        if ($_SESSION['role'] == 'admin'){
            write_logJSON("Review for product ID " . $product_id . ", customer ID " . $customer_id . ", order number " . $order_number . " updated to status '" . $status . "' by admin " . $_SESSION['username'], "update" ,"review", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/reviews.php?message=Review+status+updated+successfully");
        exit();
    } else {
        header("Location: /student024/Shop/backend/views/reviews.php?error=Failed+to+update+review+status");
    }

} else if (isset($_POST['status']) && !isset($_POST['product_id']) && !isset($_POST['customer_id']) && !isset($_POST['order_number'])) {
    $status = $_POST['status'];
    $sql = "UPDATE 024_reviews SET status = '$status'";
    $query = mysqli_query($conn, $sql);
}