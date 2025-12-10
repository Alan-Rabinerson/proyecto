<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';  ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';

    $order_number = $_GET['order_number'];
    $customer_id = $_GET['customer_id'];
    $order_date = date('Y-m-d H:i:s'); // Fecha actual
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    $address_id = $_GET['address_id'];
    $method_id = $_GET['method_id'];
    $status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

    $sql = "UPDATE 024_orders_table SET customer_id = $customer_id, order_date = '$order_date', product_id = $product_id, quantity = $quantity, address_id = $address_id, method_id = $method_id, status = '$status' WHERE order_number = $order_number";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("Location: /student024/Shop/backend/views/orders.php?message=".urlencode("Pedido actualizado correctamente")."&order_number=".$order_number);
    } else {
        header("Location: /student024/Shop/backend/forms/orders/form_order_update.php?error=".urlencode("Error al actualizar el pedido: " . mysqli_error($conn))."&order_number=".$order_number);

    }

?>