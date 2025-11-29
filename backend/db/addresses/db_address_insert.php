<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $province = $_POST['province'];
    $update_sql = "INSERT INTO 024_address (`street`, `city`, `zip_code`, `province`) VALUES ('$street', '$city', '$zip_code', '$province')";
    $customer_id = $_SESSION['customer_id'];
    $address_id = mysqli_insert_id($conn);
    $customer_address_sql = "INSERT INTO 024_address_customer(`customer_id`, `address_id`) VALUES ($customer_id, $address_id)";
    if (mysqli_query($conn, $update_sql) && mysqli_query($conn, $customer_address_sql)) {
        echo "Address updated successfully.";
        header("Location: /student024/shop/backend/views/my_account.php");
        exit();
    } else {
        echo "Error updating address: " . mysqli_error($conn);
        //header("Location: /student024/shop/backend/forms/addresses/form_address_update.php?address_id=$address_id");
        exit();
    }
?>