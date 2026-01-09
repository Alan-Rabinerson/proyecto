<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php'; 
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    session_start();
    // get address_id and updated data from POST
    $address_id = $_POST['address_id'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];
    $province = $_POST['province'];
    $address_name = $_POST['address_name'];
    $update_sql = "UPDATE 024_address SET street='$street', city='$city', zip_code='$zip_code', province='$province', address_name='$address_name' WHERE address_id=$address_id";
    if (mysqli_query($conn, $update_sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Address with ID " . $address_id . " updated by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "update" ,"address", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Address updated successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/forms/addresses/form_address_update.php?address_id=$address_id&error=" . urlencode("Error updating address: " . mysqli_error($conn)));
        exit();
    }
?>