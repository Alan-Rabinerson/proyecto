<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
    
    // Productos en oferta con descuentos hardcoded
    $offers = [
        ['product_id' => 5, 'discount_percent' => 30],
        ['product_id' => 6, 'discount_percent' => 25],
        ['product_id' => 7, 'discount_percent' => 20],
        ['product_id' => 8, 'discount_percent' => 15]
    ];
    
    $result_offers = [];
    
    foreach ($offers as $offer) {
        $product_id = intval($offer['product_id']);
        $discount = floatval($offer['discount_percent']);
        
        $sql = "SELECT p.product_id, p.name, p.price, p.description, p.available_sizes
                FROM `024_product_view` p
                WHERE p.product_id = $product_id 
                LIMIT 1";
        
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $original_price = floatval($row['price']);
            $discounted_price = $original_price * (1 - $discount / 100);
            
            $result_offers[] = [
                'product_id' => intval($row['product_id']),
                'product_name' => $row['name'],
                'original_price' => number_format($original_price, 2, '.', ''),
                'price' => number_format($discounted_price, 2, '.', ''),
                'discount_percent' => $discount,
                'description' => $row['description'],
                'sizes' => $row['available_sizes']
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result_offers);
    exit;
