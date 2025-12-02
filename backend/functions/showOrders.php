<?php
    function showOrders($order_group){
        // nothing to show
        if (empty($order_group)) return;

        // Normalize input: accept either a grouped array (list of rows)
        // or a single associative array representing one row.
        if (is_array($order_group) && count($order_group) > 0 && is_array(reset($order_group))) {
            // $order_group is a group of rows (even if keys are 1,2,3 or random)
            $items = array_values($order_group);
            $first = $items[0];
        } else {
            // single-row associative array
            $items = [$order_group];
            $first = $order_group;
        }

        // Use safe defaults and escape output to avoid warnings and XSS
        $order_id = $first['order_id'] ;
        $first_name = $first['first_name'] ;
        $last_name = $first['last_name'] ;
        $order_date = $first['order_date'] ;
        $status = $first['status'] ;
        $method_name = $first['payment_method'];
        echo "<div class='order-card'>";
        echo "<h3>Order ID: " . $order_id . "</h3>";
        echo "<p>Customer Name: " . $first_name . " " . $last_name . "</p>";
        echo "<p>Order Date: " . $order_date . "</p>";
        echo "<p>Status: " . $status . "</p>";
        echo "<p>Method: " . $method_name . "</p>";
        foreach($items as $product){
            $order_number = $product['order_number'];
            echo "<div class='order-product'>";
            echo "<h4>Product Name: " . $product['product_name']  . "</h4>";
            echo "<p>Quantity: " . $product['quantity'] . "</p>";
            echo "<p>Address: " . $product['delivery_address'] . "</p>";
            
            if (!empty($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_update_call.php';
                include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/orders/form_order_delete.php';
            }
            echo "</div>";
        }
        echo "</div>";
    }
?>