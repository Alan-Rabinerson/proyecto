<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    // capture data for the product to delete
    $customer_id = $_GET['id'];
    // delete product data in database
    $sql = "DELETE FROM 024_customers WHERE customer_id = $customer_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: /student024/shop/backend/views/customers.php?message=" . urlencode("Customer $customer_id deleted successfully."));
    } else {
        header("Location: /student024/shop/backend/views/customers.php?error=" . urlencode("Error deleting customer: " . mysqli_error($conn)));
    }

?>