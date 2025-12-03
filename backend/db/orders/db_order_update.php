<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

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
        echo "<p class='text-green-400 font-bold'>Pedido actualizado correctamente.</p>";
        ?>
        <script>
            setTimeout(function(){
                window.location.href = '/student024/shop/backend/views/orders.php';
            }, 5000); // Redirige después de 5 segundos
        </script>
        <?php
    } else {
        echo "<p class='text-red-400 font-bold'>Error al actualizar el pedido: " . mysqli_error($conn) . "</p>";
        ?>
        <script>
            setTimeout(function(){
                window.location.href = '/student024/shop/backend/db/orders/db_order_update.php?order_number=<?php echo $order_number; ?>';
            }, 5000); // Redirige después de 5 segundos
        </script>
        <?php
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado
?>