<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    session_start();
    // get and sanitize input data
    $method_name = mysqli_real_escape_string($conn, $_POST['method_name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);
    $security_code = mysqli_real_escape_string($conn, $_POST['security_code']);
    // insert payment method into database
    $insert_sql = "INSERT INTO 024_payment_method (method_name, number, expiration_date, security_code) 
                   VALUES ('$method_name', '$number', '$expiration_date', '$security_code')";
    // show success or error message
    if (mysqli_query($conn, $insert_sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("New payment method added for customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'] ." : " . $method_name . " ending in " . substr($number, -4), "insert" ,"payment method", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/my_account.php?message=Payment+method+added+successfully");
        exit();
    } else {
        header("Location: /student024/Shop/backend/forms/payment_methods/form_payment_method_insert.php?error=error+adding+payment+method");
        exit();
    }
?>