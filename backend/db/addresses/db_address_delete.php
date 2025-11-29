<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    $address_id = $_POST['address_id'];
    $delete_sql = "DELETE FROM 024_addresses WHERE address_id = $address_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Address deleted successfully.";
        header("Location: /student024/shop/backend/views/my_account.php");
        exit();
    } else {
        echo "Error deleting address: " . mysqli_error($conn);
        header("Location: /student024/shop/backend/views/my_account.php");
        exit();
    }
?>
