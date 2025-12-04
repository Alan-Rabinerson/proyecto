<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $method_name = $_POST['method_name'];
    $number = $_POST['number'];
    $expiration_date = $_POST['expiration_date'];
    $security_code = $_POST['security_code'];
    $method_id = $_POST['method_id'];

    $update_sql = "UPDATE 024_payment_method 
                   SET method_name='$method_name', number='$number', expiration_date='$expiration_date', security_code='$security_code' 
                   WHERE method_id=$method_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: /student024/shop/backend/views/my_account.php?message=" . urlencode("Payment method updated successfully"));
        exit();
    } else {
        header("Location: /student024/shop/backend/forms/payment_methods/form_payment_method_update.php?error=" . urlencode("Error updating payment method ". mysqli_error($conn)));
        exit();
    }
?>