<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    session_start();
    // get and sanitize input data
    $method_name = mysqli_real_escape_string($conn, $_POST['method_name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);
    $security_code = mysqli_real_escape_string($conn, $_POST['security_code']);
    $method_id = mysqli_real_escape_string($conn, $_POST['method_id']);
    // update payment method in database
    $update_sql = "UPDATE 024_payment_method 
                   SET method_name='$method_name', number='$number', expiration_date='$expiration_date', security_code='$security_code' 
                   WHERE method_id=$method_id";

    if (mysqli_query($conn, $update_sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Payment method with ID " . $method_id . " updated by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "update" ,"payment method", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Payment method updated successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/forms/payment_methods/form_payment_method_update.php?error=" . urlencode("Error updating payment method ". mysqli_error($conn)));
        exit();
    }
?>