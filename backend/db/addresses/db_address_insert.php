<?php
require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
session_start();
// Sanitize and validate input
$street = isset($_POST['street']) ? mysqli_real_escape_string($conn, trim($_POST['street'])) : '';
$city = isset($_POST['city']) ? mysqli_real_escape_string($conn, trim($_POST['city'])) : '';
$zip_code = isset($_POST['zip_code']) ? mysqli_real_escape_string($conn, trim($_POST['zip_code'])) : '';
$province = isset($_POST['province']) ? mysqli_real_escape_string($conn, trim($_POST['province'])) : '';
$address_name = isset($_POST['address_name']) ? mysqli_real_escape_string($conn, trim($_POST['address_name'])) : '';

$customer_id = $_SESSION['customer_id'] ;


// Insert address first
$insert_address_sql = "INSERT INTO `024_address` (`address_name`, `street`, `city`, `zip_code`, `province`) VALUES ('$address_name', '$street', '$city', '$zip_code', '$province')";
if (!mysqli_query($conn, $insert_address_sql)) {
    header("Location: /student024/Shop/backend/forms/addresses/form_address_insert.php?error=" . urlencode(mysqli_error($conn)));
    exit();
}

// Get the newly created address id
$address_id = mysqli_insert_id($conn);
if (empty($address_id)) {
    header("Location: /student024/Shop/backend/forms/addresses/form_address_insert.php?error=" . urlencode("Failed to retrieve new address ID"));
    exit();
}

// Note: the schema uses the table `024_address_customer` with column `address_id` (legacy spelling)
$customer_address_sql = "INSERT INTO `024_address_customer` (`address_id`, `customer_id`) VALUES ($address_id, $customer_id)";
if (!mysqli_query($conn, $customer_address_sql)) {
    // If this fails, remove the previously inserted address to avoid orphan rows
    $del_sql = "DELETE FROM `024_address` WHERE `address_id` = $address_id";
    mysqli_query($conn, $del_sql);
    header("Location: /student024/Shop/backend/forms/addresses/form_address_insert.php?error=" . urlencode(mysqli_error($conn)));
    exit();
}
if ($_SESSION['role'] == 'admin') {
    write_logJSON("Address added: address_id=$address_id, customer_id=$customer_id", "insert" ,"address", "changes_log.json");
}
// Success: redirect back to account page
header("Location: /student024/Shop/backend/views/my_account.php?message=" . urlencode("Address added successfully"));
exit();
?>