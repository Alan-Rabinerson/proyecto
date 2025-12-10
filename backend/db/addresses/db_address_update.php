<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php'; 
    // get address_id and updated data from POST
    $address_id = $_POST['address_id'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $province = $_POST['province'];
    $update_sql = "UPDATE 024_address SET street='$street', city='$city', zip_code='$zip_code', province='$province' WHERE address_id=$address_id";
    if (mysqli_query($conn, $update_sql)) {
        header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Address updated successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/forms/addresses/form_address_update.php?address_id=$address_id&error=" . urlencode("Error updating address: " . mysqli_error($conn)));
        exit();
    }
?>