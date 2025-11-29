<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<main>
    <h1> Mis Pedidos</h1>
        <div class="orders-container mt-4 h-fit w-fit flex flex-wrap items-center justify-center gap-4">
        <?php 
            $customer_id = $_SESSION['customer_id'];
            require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
            $sql = "SELECT * FROM 024_order_view WHERE customer_id = $customer_id ORDER BY order_number DESC";
            $result = mysqli_query($conn, $sql);
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (count($orders) === 0) {
                echo "<p>You have no orders yet.</p>";
            }
            foreach($orders as $order){
                $order_number = $order['order_number'];
                echo "<div class='order-card'>";
                echo "<h3>Order Number: " . $order['order_number'] . "</h3>";
                echo "<p>Customer Name: " . $order['first_name'] . " " . $order['last_name'] . "</p>";
                echo "<p>Order Date: " . $order['order_date'] . "</p>";
                echo "<p>Product Name: " . $order['name'] . "</p>";
                echo "<p>Size: " . $order['size'] . "</p>";
                echo "<p>Quantity: " . $order['quantity'] . "</p>";
                echo "<p>Address: " . $order['delivery_address'] . "</p>";
                echo "<p>Method: " . $order['method_name'] . "</p>";
                if ($_SESSION['role'] === 'admin') {
                    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_update_call.php';
                    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_delete.php';
                }
                echo "</div>";
            }
        ?>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>