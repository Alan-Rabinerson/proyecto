<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $customer_id = $_GET['customer_id'];
    $order_date = date('Y-m-d H:i:s'); // Fecha actual
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    $address_id = $_GET['address_id'];
    $method_id = $_GET['method_id'];

    $sql = "INSERT INTO 024_orders_table (customer_id, order_date, product_id, quantity, address_id, method_id) VALUES ($customer_id, '$order_date', $product_id, $quantity, $address_id, $method_id)";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "Pedido insertado correctamente.";
    } else {
        echo "Error al insertar el pedido: " . mysqli_error($conn);
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado
?>  