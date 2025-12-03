<?php
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
if (isset($_POST['status']) && isset($_POST['product_id']) && isset($_POST['customer_id']) && isset($_POST['order_number'])) {
    $status = $_POST['status'];
    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $order_number = $_POST['order_number'];

    $sql = "UPDATE 024_reviews SET status = '$status' WHERE product_id = $product_id AND customer_id = $customer_id AND order_number = '$order_number'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: /student024/shop/backend/views/reviews.php");
        exit();
    } else {
        header("Location: /student024/shop/backend/views/reviews.php?error=Failed+to+update+review+status");
    }

} else if (isset($_POST['status']) && !isset($_POST['product_id']) && !isset($_POST['customer_id']) && !isset($_POST['order_number'])) {
    $status = $_POST['status'];
    $sql = "UPDATE 024_reviews SET status = '$status'";
    $query = mysqli_query($conn, $sql);
}