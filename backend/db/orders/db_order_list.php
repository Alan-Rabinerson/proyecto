<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $sql = "SELECT * FROM 024_order_view";
    $result = mysqli_query($conn, $sql);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach($orders as $order){
        $order_number = $order['order_number'];
        echo "<div>";
        echo "<h3>Order Number: " . $order['order_number'] . "</h3>";
        echo "<p>Customer Name: " . $order['first_name'] . " " . $order['last_name'] . "</p>";
        echo "<p>Order Date: " . $order['order_date'] . "</p>";
        echo "<p>Product Name: " . $order['name'] . "</p>";
        echo "<p>Quantity: " . $order['quantity'] . "</p>";
        echo "<p>Address: " . $order['delivery_address'] . "</p>";
        echo "<p>Method: " . $order['method_name'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_update_call.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_delete.php';
        echo "</div><hr>";
    }