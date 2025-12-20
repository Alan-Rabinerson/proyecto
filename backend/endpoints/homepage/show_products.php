<?php 
    try {
        session_start();
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
        
        // Verificar conexión
        if (!$conn) {
            throw new Exception('Conexión a la base de datos rechazada: ' . mysqli_connect_error());
        }
        
        $products = [];
        $sql = "SELECT product_id, name, price, description, available_sizes FROM `024_products` LIMIT 4";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            throw new Exception('Error en la consulta de productos: ' . mysqli_error($conn));
        }
        
        if (mysqli_num_rows($result) > 0) {
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
    } catch (Exception $e) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Error al cargar productos destacados: ' . $e->getMessage()]);
        exit;
    }
?>
