<?php
require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
session_start();
// Sanitize and validate input
$street = isset($_POST['street']) ? mysqli_real_escape_string($conn, trim($_POST['street'])) : '';
$city = isset($_POST['city']) ? mysqli_real_escape_string($conn, trim($_POST['city'])) : '';
$zip_code = isset($_POST['zip_code']) ? mysqli_real_escape_string($conn, trim($_POST['zip_code'])) : '';
$province = isset($_POST['province']) ? mysqli_real_escape_string($conn, trim($_POST['province'])) : '';

$customer_id = $_SESSION['customer_id'] ?? null;
if (empty($customer_id)) {
    echo "No customer session found.";
    exit();
}

// Insert address first
$insert_address_sql = "INSERT INTO `024_address` (`street`, `city`, `zip_code`, `province`) VALUES ('$street', '$city', '$zip_code', '$province')";
if (!mysqli_query($conn, $insert_address_sql)) {
    echo "Error inserting address: " . mysqli_error($conn);
    exit();
}

// Get the newly created address id
$address_id = mysqli_insert_id($conn);
if (empty($address_id)) {
    echo "Could not get new address id.";
    exit();
}

// Note: the schema uses the table `024_address_customer` with column `address_id` (legacy spelling)
$customer_address_sql = "INSERT INTO `024_address_customer` (`address_id`, `customer_id`) VALUES ($address_id, $customer_id)";
if (!mysqli_query($conn, $customer_address_sql)) {
    // If this fails, remove the previously inserted address to avoid orphan rows
    $del_sql = "DELETE FROM `024_address` WHERE `address_id` = $address_id";
    mysqli_query($conn, $del_sql);
    echo "Error linking address to customer: " . mysqli_error($conn);
    exit();
}

// Success: redirect back to account page
header("Location: /student024/shop/backend/views/my_account.php");
exit();
?>