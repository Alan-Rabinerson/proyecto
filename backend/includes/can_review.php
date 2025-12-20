<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
}
$customer_id_i = isset($_SESSION['customer_id']) ? intval($_SESSION['customer_id']) : 0;
$canReview = false;

// Only allow review when user is logged in and order is Delivered
if (isset($status) && $status === 'DELIVERED') {
    $order_num_i = isset($order_number) ? intval($order_number) : 0;
    $product_id_i = isset($product_id) ? intval($product_id) : 0;

    $query = false;   
    $sql = "SELECT 1 FROM `024_reviews` WHERE order_number = $order_num_i AND product_id = $product_id_i AND customer_id = $customer_id_i LIMIT 1";
    $query = mysqli_query($conn, $sql);


    
    // Admins should not use this review flow
    $role = $_SESSION['role'] ?? '';
    if ($role === 'admin') {
        $canReview = true;
    } else {
        if ($query !== false) {
            if (mysqli_num_rows($query) === 0) {
                $canReview = true;
            }
        } else {
            // Query failed or no DB connection: safer to not allow review to avoid duplicates
            $canReview = false;
        }
    }
}

if ($canReview) {
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/product_review_call.php';
} else {
    echo "<button disabled class='px-4 py-2 bg-gray-600 text-white rounded'>Review</button>";
}