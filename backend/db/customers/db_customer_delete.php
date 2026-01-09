<?php 
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_log.php';
session_start();

    // capture data for the product to delete
    $customer_id = $_GET['id'];
    // delete product data in database
    $sql = "DELETE FROM 024_customers WHERE customer_id = $customer_id";
    if (mysqli_query($conn, $sql)) {
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Customer with ID " . $customer_id . " deleted by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "delete" ,"customer", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/customers.php?message=" . urlencode("Customer $customer_id deleted successfully."));
    } else {
        header("Location: /student024/Shop/backend/views/customers.php?error=" . urlencode("Error deleting customer: " . mysqli_error($conn)));
    }

?>