<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/header.php';  ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos delL pedido seleccionado
    if (isset($_GET['order_number']) && is_numeric($_GET['order_number'])) {
        $order_number = intval($_GET['order_number']);
        $sql = "SELECT * FROM 024_orders_table WHERE order_number = $order_number";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $order = mysqli_fetch_assoc($result);
            echo "<h2>Detalles del Pedido " . htmlspecialchars($order['order_number']) . "</h2>";
            echo "<p>Cliente: " . htmlspecialchars($order['customer_id']) . "</p>";
            echo "<p>Fecha: " . htmlspecialchars($order['order_date']) . "</p>";
            echo "<p>Producto: " . htmlspecialchars($order['product_id']) . "</p>";
            echo "<p>Cantidad: " . htmlspecialchars($order['quantity']) . "</p>";
            echo "<p>Dirección de Envío: " . htmlspecialchars($order['address_id']) . "</p>";
            echo "<p>Método de Pago: " . htmlspecialchars($order['method_id']) . "</p>";
        } else {
            echo "<p>Error al obtener los detalles del pedido.</p>";
        }
    } else {
        $sql = "SELECT * FROM 024_orders_table";
        $results = mysqli_query($conn, $sql);
        $orders = mysqli_fetch_all($results, MYSQLI_ASSOC);
        foreach ($orders as $order) {
            echo "<h2>Detalles del Pedido " . htmlspecialchars($order['order_number']) . "</h2>";
            echo "<p>Cliente: " . htmlspecialchars($order['customer_id']) . "</p>";
            echo "<p>Fecha: " . htmlspecialchars($order['order_date']) . "</p>";
            echo "<p>Producto: " . htmlspecialchars($order['product_id']) . "</p>";
            echo "<p>Cantidad: " . htmlspecialchars($order['quantity']) . "</p>";
            echo "<p>Dirección de Envío: " . htmlspecialchars($order['address_id']) . "</p>";
            echo "<p>Método de Pago: " . htmlspecialchars($order['method_id']) . "</p>";
        }
    }


    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/footer.php'; 
