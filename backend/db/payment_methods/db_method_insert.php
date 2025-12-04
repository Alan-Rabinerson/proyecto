<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $method_name = mysqli_real_escape_string($conn, $_POST['method_name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);
    $security_code = mysqli_real_escape_string($conn, $_POST['security_code']);

    $insert_sql = "INSERT INTO 024_payment_method (method_name, number, expiration_date, security_code) 
                   VALUES ('$method_name', '$number', '$expiration_date', '$security_code')";

    if (mysqli_query($conn, $insert_sql)) {
        header("Location: /student024/shop/backend/views/my_account.php?message=Payment+method+added+successfully");
        exit();
    } else {
        header("Location: /student024/shop/backend/forms/payment_methods/form_payment_method_insert.php?error=error+adding+payment+method");
        exit();
    }
?>