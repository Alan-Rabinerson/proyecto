<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
    // get method_id from POST data
    $method_id = $_POST['method_id'];
    // delete payment method from database
    $delete_sql = "DELETE FROM 024_payment_method WHERE method_id=$method_id";
    if (mysqli_query($conn, $delete_sql)) { // show success or error message
        header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Payment method deleted successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/views/my_account.php?error=" . urlencode("Error deleting payment method ". mysqli_error($conn)));
        exit();
    }