<?php
    function showOrders($order){
        
        
        echo "<div class='order-card'>";
        echo "<h3>Order ID: " . $order['order_id'] . "</h3>";
        echo "<p>Customer Name: " . $order['first_name'] . " " . $order['last_name'] . "</p>";
        echo "<p>Order Date: " . $order['order_date'] . "</p>";
        echo "<p>Product Name: " . $order['name'] . "</p>";
        echo "<p>Quantity: " . $order['quantity'] . "</p>";
        echo "<p>Address: " . $order['delivery_address'] . "</p>";
        echo "<p>Method: " . $order['method_name'] . "</p>";
        if ($_SESSION['role'] == 'admin') {
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_update_call.php';
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_delete.php';
        }
        echo "</div>";
    }
?>