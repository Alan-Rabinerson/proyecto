<?php 
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
    $reviews = [];
    $sql = "SELECT r.review_id, r.rating, r.comment, r.created_at, c.full_name 
            FROM `024_reviews` r
            LEFT JOIN `024_customers` c ON r.customer_id = c.customer_id
            WHERE r.product_id = " . $product_id . " ORDER BY r.created_at DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = [
                'review_id' => intval($row['review_id']),
                'rating' => intval($row['rating']),
                'comment' => $row['comment'],
                'created_at' => $row['created_at'],
                'full_name' => $row['full_name']
            ];
        }
    }

    echo json_encode(['reviews' => $reviews]);
    exit;