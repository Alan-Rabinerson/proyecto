<?php require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php'; 
    session_start();
    // get customer_id from session and address_id from POST data
    $customer_id = $_SESSION['customer_id'] ?? null;
    $address_id = $_POST['address_id'];
    $deletate_sql_customer = "DELETE FROM 024_address_customer WHERE address_id = $address_id AND customer_id = $customer_id";
    if (!mysqli_query($conn, $deletate_sql_customer)) {
        header("Location: /student024/Shop/backend/views/my_account.php?error=" . urlencode("Error deleting address association: ". mysqli_error($conn)));
        exit();
    }
    // delete address from database after disassociating it from the customer and show success or error message
    $delete_sql = "DELETE FROM 024_address WHERE address_id = $address_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Address deleted successfully.";
        header("Location: /student024/Shop/backend/views/my_account.php");
        exit();
    } else {
        echo "Error deleting address: " . mysqli_error($conn);
        header("Location: /student024/Shop/backend/views/my_account.php");
        exit();
    }
?>
