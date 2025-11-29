<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    $address_id = $_POST['address_id'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $province = $_POST['province'];
    $update_sql = "UPDATE 024_addresses SET street='$street', city='$city', zip_code='$zip_code', province='$province' WHERE address_id=$address_id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Address updated successfully.";
        header("Location: /student024/shop/backend/views/my_account.php");
        exit();
    } else {
        echo "Error updating address: " . mysqli_error($conn);
        header("Location: /student024/shop/backend/forms/addresses/form_address_update.php?address_id=$address_id");
        exit();
    }
?>