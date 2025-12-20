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
    // 1) Sesión
    if (isset($_SESSION['customer_id'])) {
        $customer_id = intval($_SESSION['customer_id']);
    // 2) Parámetro explícito
    } elseif (isset($_POST['customer_id'])) {
        $customer_id = intval($_POST['customer_id']);
    // 3) Cookies directas
    } elseif (isset($_COOKIE['customer_id'])) {
        $customer_id = intval($_COOKIE['customer_id']);
    } elseif (isset($_COOKIE['guest_id'])) {
        $customer_id = intval($_COOKIE['guest_id']);
    // 4) Resolver desde username
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

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : '';
    $delta = isset($_POST['delta']) ? intval($_POST['delta']) : 0;

    if ($customer_id <= 0 || $product_id <= 0 || $delta == 0) {
        throw new Exception('Parámetros inválidos: customer_id=' . $customer_id . ', product_id=' . $product_id . ', delta=' . $delta);
    }

    // Update quantity
    $sql = "SELECT quantity FROM `024_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "' LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        throw new Exception('Error consultando carrito: ' . mysqli_error($conn));
    }
    
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $new_q = intval($row['quantity']) + $delta;
        if ($new_q <= 0) {
            $del = "DELETE FROM `024_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "'";
            $del_result = mysqli_query($conn, $del);
            if (!$del_result) {
                throw new Exception('Error eliminando del carrito: ' . mysqli_error($conn));
            }
        } else {
            $upd = "UPDATE `024_shopping_cart` SET quantity = $new_q WHERE customer_id = $customer_id AND product_id = $product_id AND size = '" . $size . "'";
            $upd_result = mysqli_query($conn, $upd);
            if (!$upd_result) {
                throw new Exception('Error actualizando cantidad: ' . mysqli_error($conn));
            }
        }
        // Return refreshed cart
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/endpoints/shopping_cart/get_cart.php';
        exit;
    } else {
        // If no existing row and delta positive, insert
        if ($delta > 0) {
            $ins = "INSERT INTO `024_shopping_cart` (customer_id, product_id, quantity, size) VALUES ($customer_id, $product_id, $delta, '" . $size . "')";
            $ins_result = mysqli_query($conn, $ins);
            if (!$ins_result) {
                throw new Exception('Error insertando en carrito: ' . mysqli_error($conn));
            }
            include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/endpoints/shopping_cart/get_cart.php';
            exit;
        } else {
            throw new Exception('Producto no encontrado en carrito');
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error actualizando carrito: ' . $e->getMessage()]);
    exit;
}
?>

echo json_encode(['success' => false, 'message' => 'Item not found']);
exit;

?>
