<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/functions/showOrders.php';
?>
<main>
    <h1> Mis Pedidos</h1>
    <form  method="GET">
        <input type="text" name="order_id" placeholder="ID del pedido" class="border-azul-claro border" onkeyup="showMyOrders(this.value)" required>
    </form>
    <div class="orders-container mt-4 h-fit w-fit flex flex-wrap items-center justify-center gap-4" id="orders-container">
        <?php 
            $orders_id_list = [];
            $customer_id = $_SESSION['customer_id'];
            require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
            $sql = "SELECT * FROM 024_order_view WHERE customer_id = $customer_id ORDER BY order_number DESC";
            $result = mysqli_query($conn, $sql);
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (count($orders) === 0) {
                echo "<p>You have no orders yet.</p>";
            }
            foreach($orders as $order){
                $order_id = $order['order_id'];
                $order_id_list[$order_id][$order['product_id']] = $order;
                $order_number = $order['order_number'];
            }
            foreach($order_id_list as $order_id => $products){
                showOrders($products, $order_number);
            }

            
        ?>
    </div>
</main>
<script src="/student024/shop/JavaScript/showorders.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>