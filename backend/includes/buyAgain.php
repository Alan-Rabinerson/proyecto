<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    if (isset($_GET['product_id']) && isset($_GET['size'])) {
        $product_id = $_GET['product_id'];
        $size = $_GET['size'];
        $customer_id = $_SESSION['customer_id'];

        // Get product details
        $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            

            // Insert into shopping cart
            $insert_sql = "INSERT INTO 024_shopping_cart (customer_id, product_id, quantity, size) VALUES ($customer_id, $product_id, 1, '$size')";
            if (mysqli_query($conn, $insert_sql)) {
                header("Location: /student024/Shop/backend/views/shopping_cart.php?message=".urlencode("Product added to cart successfully"));
                exit();
            } else {
                header("Location: /student024/Shop/backend/views/shopping_cart.php?error=".urlencode("Failed to add product to cart"));
                exit();
            }
        } else {
            header("Location: /student024/Shop/backend/views/shopping_cart.php?error=".urlencode("Product not found"));
            exit();
        }
    } else if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $customer_id = $_SESSION['customer_id'];

        // Get products from the order
        $sql = "SELECT * FROM 024_orders_table WHERE order_id = '$order_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $item) {
                $product_id = $item['product_id'];
                $size = $item['size'];
                $quantity = $item['quantity'];

                // Insert each product into shopping cart
                $insert_sql = "INSERT INTO 024_shopping_cart (customer_id, product_id, quantity, size) VALUES ($customer_id, $product_id, 1, '$size')";
                mysqli_query($conn, $insert_sql);
            }
            header("Location: /student024/Shop/backend/views/shopping_cart.php?message=".urlencode("Order products added to cart successfully"));
            exit();
        } else {
            header("Location: /student024/Shop/backend/views/shopping_cart.php?error=".urlencode("No products found in the order"));
            exit();
        }
    }
    else {
        header("Location: /student024/Shop/backend/views/shopping_cart.php?error=".urlencode("Invalid request"));
        exit();
    }
    