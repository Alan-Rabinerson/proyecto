<?php 
    header('Content-Type: application/json; charset=UTF-8');
    require $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/config/db_connect_switch.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/endpoints/guests/create_guest.php';
    $api_key = 'e888b918-330e-43c5-a103-111d57a4a28f'; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['api_key'] === $api_key) {
        correctKey();
    } else {
        wrongKey();
    }
    
    function create_guest_and_get_customer_id() {
        global $conn;
        
        // Generar un guest_id único
        $guest_id = uniqid('guest_', true);
        $guest_id = str_replace('.', '_', $guest_id); // Reemplazar puntos para que sea válido
        
        // Crear datos del cliente guest
        $first_name = $conn->real_escape_string('guest');
        $last_name = $conn->real_escape_string($guest_id);
        $email = $conn->real_escape_string($guest_id . '@guest.com');
        $username = $conn->real_escape_string($guest_id);
        $password = $conn->real_escape_string('');
        $phone = $conn->real_escape_string('123456789');
        $type = $conn->real_escape_string('customer');
        
        // Insertar el cliente guest en la base de datos
        $sql = "INSERT INTO `024_customers` (`first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birth_date`, `type`) VALUES (".
                "'" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $username . "', '" . $password . "', '" . $phone . "', CURDATE(), '" . $type . "')";
        
        if ($conn->query($sql) === TRUE) {
            return $conn->insert_id; // Retornar el customer_id generado
        } else {
            throw new Exception('Error creando guest: ' . $conn->error);
        }
    }
    
    function correctKey() {
        global $conn;
        $order = json_decode($_POST['order'], true);
        $order_date = date('Y-m-d H:i:s');
        
        // Crear el guest y obtener su customer_id
        $customer_id = create_guest_and_get_customer_id();

        foreach ($order as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $supplier_id = $item['supplier_id'];
            $order_date = date('Y-m-d H:i:s');

            $sql = "INSERT INTO 024_orders (product_id, quantity, order_date, supplier_id, customer_id) VALUES (" .
                   intval($product_id) . ", " .
                   intval($quantity) . ", '" .
                   mysqli_real_escape_string($conn, $order_date) . "', " .
                   intval($supplier_id) . ", " .
                   intval($customer_id) . ")";
            
            if (!mysqli_query($conn, $sql)) {
                throw new Exception('Error insertando orden: ' . mysqli_error($conn));
            }
        }
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Ordenes insertadas exitosamente',
            'customer_id' => $customer_id
        ]);
    }
    
    function wrongKey() {
        http_response_code(403);
        echo json_encode(array("message" => "Forbidden: Invalid or missing API Key"));
    }