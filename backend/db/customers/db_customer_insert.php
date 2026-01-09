<?php 
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';// Llama al script para obtener los productos
require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    // capturar datos del producto a actualizar
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birth_date'];
    // insert product data in database
    $sql = "INSERT INTO 024_customers (`first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birth_date`, `type`) VALUES ('$first_name', '$last_name', '$email', '$username', '$password', '$phone', '$birthdate', 'customer')";
    if (mysqli_query($conn, $sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Customer '$first_name $last_name' inserted by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "insert" ,"customer", "changes_log.json");
        }
        $message = "Customer '$first_name $last_name' inserted successfully.";
        header("Location: /student024/Shop/backend/views/customers.php?message=" . urlencode($message));
    } else {
       header("Location: /student024/Shop/backend/views/customers.php?error=" . urlencode("Error inserting customer: " . mysqli_error($conn)));
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php'; 