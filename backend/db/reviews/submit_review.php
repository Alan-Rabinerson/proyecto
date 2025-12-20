<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php'; 
    session_start();
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $order_number = $_POST['order_number'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO 024_reviews (customer_id, product_id, order_number, review_content, review_rating) VALUES ($customer_id, $product_id, '$order_number', '$review', $rating)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: /student024/Shop/backend/views/my_orders.php?message=".urlencode("Review submitted successfully"));
        exit();
    } else {
        header("Location: /student024/Shop/backend/views/product_review.php?product_id=$product_id&order_number=$order_number&error=".urlencode("Failed to submit review"));
        exit();
    }
?>
