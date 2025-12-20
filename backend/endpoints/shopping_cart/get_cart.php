<?php
try {
    header('Content-Type: application/json; charset=utf-8');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';

    if (!$conn) {
        throw new Exception('Conexión a la base de datos rechazada: ' . mysqli_connect_error());
    }

    $customer_id = 0;
    // 1) Prioridad: sesión
    if (isset($_SESSION['customer_id'])) {
        $customer_id = intval($_SESSION['customer_id']);
    // 2) Parámetro explícito en la petición
    } elseif (isset($_GET['customer_id'])) {
        $customer_id = intval($_GET['customer_id']);
    // 3) Cookies directas de identificación
    } elseif (isset($_COOKIE['customer_id'])) {
        $customer_id = intval($_COOKIE['customer_id']);
    } elseif (isset($_COOKIE['guest_id'])) {
        $customer_id = intval($_COOKIE['guest_id']);
    // 4) Resolver desde username si existe
    } elseif (isset($_COOKIE['username'])) {
        $username = mysqli_real_escape_string($conn, $_COOKIE['username']);
        $q = "SELECT customer_id FROM `024_customers` WHERE username = '" . $username . "' LIMIT 1";
        $r = mysqli_query($conn, $q);
        if (!$r) {
            throw new Exception('Error consultando usuario: ' . mysqli_error($conn));
        }
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $customer_id = intval($row['customer_id']);
        }
    }

    if ($customer_id <= 0) {
        echo json_encode(['success' => true, 'items' => [], 'total' => 0]);
        exit;
    }

    $sql = "SELECT sc.product_id, sc.quantity, sc.size, p.name, p.price
            FROM `024_shopping_cart` sc
            LEFT JOIN `024_products` p ON sc.product_id = p.product_id
            WHERE sc.customer_id = " . $customer_id . " ORDER BY sc.shopping_cart_id ASC";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception('Error al obtener carrito (Customer ID: ' . $customer_id . '): ' . mysqli_error($conn));
    }
    
    $items = [];
    $total = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = intval($row['product_id']);
        $quantity = intval($row['quantity']);
        $price = floatval($row['price']);
        $subtotal = $price * $quantity;
        $total += $subtotal;

        $items[] = [
            'product_id' => $product_id,
            'name' => $row['name'],
            'price' => $price,
            'quantity' => $quantity,
            'size' => $row['size'],
            'subtotal' => $subtotal,
            'image' => '/student024/Shop/assets/imagenes/foto' . $product_id . '.jpg'
        ];
    }

    echo json_encode(['success' => true, 'items' => $items, 'total' => $total]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al cargar carrito: ' . $e->getMessage()]);
    exit;
}
?>
