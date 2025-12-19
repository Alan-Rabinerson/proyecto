<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
    
    $products = [];
    $sql = "SELECT DISTINCT product_id, name, price, description, available_sizes FROM `024_product_view` LIMIT 4";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        foreach ($result as $row) {
            $products[] = [
                'product_id' => intval($row['product_id']),
                'product_name' => $row['name'],
                'price' => floatval($row['price']),
                'description' => $row['description'],
                'sizes' => $row['available_sizes']
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
