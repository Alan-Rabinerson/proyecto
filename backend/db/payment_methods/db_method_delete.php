<?php
    require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    session_start();
    // get method_id from POST data
    $method_id = mysqli_real_escape_string($conn, $_POST['method_id']);
    // delete payment method from database
    $delete_sql = "DELETE FROM 024_payment_method WHERE method_id=$method_id";
    if (mysqli_query($conn, $delete_sql)) { // show success or error message
        if ($_SESSION['role'] == 'admin') {
            write_logJSON("Payment method with ID " . $method_id . " deleted by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "delete" ,"payment method", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Payment method deleted successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/views/my_account.php?error=" . urlencode("Error deleting payment method ". mysqli_error($conn)));
        exit();
    }
?>