<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; 
    session_start();
    $customer_id = $_SESSION['customer_id'] ?? null;
    $address_id = $_POST['address_id'];
    $deletate_sql_customer = "DELETE FROM 024_address_customer WHERE address_id = $address_id AND customer_id = $customer_id";
    if (!mysqli_query($conn, $deletate_sql_customer)) {
        echo "Error unlinking address from customer: " . mysqli_error($conn);
        header("Location: /student024/shop/backend/views/my_account.php");
        exit();
    }

    $delete_sql = "DELETE FROM 024_address WHERE address_id = $address_id";
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
