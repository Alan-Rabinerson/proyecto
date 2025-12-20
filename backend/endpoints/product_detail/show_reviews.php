<?php 
    try {
        session_start();
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
        
        if (!$conn) {
            throw new Exception('Conexión a la base de datos rechazada: ' . mysqli_connect_error());
        }
        
        $product_id = isset($_GET['productId']) ? intval($_GET['productId']) : 0;
        if ($product_id <= 0) {
            throw new Exception('ID de producto inválido: ' . $_GET['productId']);
        }
        
        $reviews = [];
        $sql = "SELECT r.review_rating, r.review_content, r.created_at, (CONCAT(c.first_name, ' ', c.last_name)) AS full_name
                FROM `024_reviews` r
                LEFT JOIN `024_customers` c ON r.customer_id = c.customer_id
                WHERE r.product_id = " . $product_id . " AND r.status = 'APPROVED' ORDER BY r.created_at DESC" ;
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception('Error consultando reseñas (Product ID: ' . $product_id . '): ' . mysqli_error($conn));
        }
        
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = [
                'review_rating' => intval($row['review_rating']),
                'review_content' => $row['review_content'],
                'created_at' => $row['created_at'],
                'full_name' => $row['full_name'],
                'product_id' => $product_id
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($reviews);
    } catch (Exception $e) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Error al cargar reseñas: ' . $e->getMessage()]);
        exit;
    }
?>
    exit;