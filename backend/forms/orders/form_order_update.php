<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $order_number = $_GET['order_number'];
    $sql = "SELECT * FROM 024_orders_table WHERE order_number = $order_number";
    $result = mysqli_query($conn, $sql);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<main> 
    <form action="/student024/shop/backend/db/db_order_update.php" method="get">
        <h2>Actualizar Pedido</h2>
        <label for="order_number">Número de Pedido (no editable):</label>
        <input type="number" name="order_number" id="order_number" value="<?php echo $orders[0]['order_number']; ?>" readonly><br><br>
        <label for="customer_id">ID del Cliente:</label>
        <input type="number" id="customer_id" name="customer_id" value="<?php echo $orders[0]['customer_id']; ?>" required><br><br>
        <label for="product_id">ID del Producto:</label>
        <input type="number" id="product_id" name="product_id" value="<?php echo $orders[0]['product_id']; ?>" required><br><br>
        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $orders[0]['quantity']; ?>" required><br><br>
        <label for="address_id">ID de la Dirección:</label>
        <input type="number" id="address_id" name="address_id" value="<?php echo $orders[0]['address_id']; ?>" required><br><br>
        <label for="method_id">ID del Método de Pago:</label>
        <input type="number" id="method_id" name="method_id" value="<?php echo $orders[0]['method_id']; ?>" required><br><br>
        <br><br>
        <button type="submit">Actualizar Pedido</button>
    </form>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado ?>