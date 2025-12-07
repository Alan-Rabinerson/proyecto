<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    
    $products = [];
    $sql = "SELECT p.product_id, p.name, p.price, p.description
            FROM `024_products` p
            ORDER BY p.product_id ASC
            LIMIT 4";
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = [
                'product_id' => intval($row['product_id']),
                'product_name' => $row['name'],
                'price' => floatval($row['price']),
                'description' => $row['description'],
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
