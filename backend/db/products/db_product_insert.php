<?php 
    // get data
    session_start();
    $product_name = $_GET['product_name'];
    $product_price = $_GET['price'];
    $product_description = $_GET['description'];
    $long_description = $_GET['long-description'];
    $product_stock = isset($_GET['stock']) ? (int) $_GET['stock'] : 0;
    $product_supplier = $_GET['supplier'];
    $product_category = $_GET['categories']; 
    $tallas = isset($_GET['tallas']) ? $_GET['tallas'] : []; // array of sizes
    $tallas_stock = isset($_GET['tallas_stock']) ? $_GET['tallas_stock'] : []; // associative array size=>stock

    //print_r($_GET); // debug
    // put data into database
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
    // prepare available_sizes as CSV for the SET column
    $available_sizes = '';
    if (!empty($tallas) && is_array($tallas)) {
        $available_sizes = implode(',', array_map(function($s){ return $s; }, $tallas));
    }
    // insert product into 024_products
    $sql = "INSERT INTO 024_products (name, description, long_description, price, supplier, available_sizes) VALUES ('$product_name', '$product_description', '$long_description', $product_price, '$product_supplier', '$available_sizes')";





    // send confirmation or error message
    if ($conn->query($sql) === TRUE) {
        // get new product id
        $new_product_id = $conn->insert_id;
        // insert sizes into 024_product_sizes with given stock per size
        if (!empty($tallas) && is_array($tallas)) {
            foreach ($tallas as $size) {
                $size_clean = $conn->real_escape_string($size);
                $stock_val = isset($tallas_stock[$size]) ? (int)$tallas_stock[$size] : $product_stock;
                $insert_size_sql = "INSERT INTO 024_product_sizes (product_id, size, stock) VALUES ($new_product_id, '$size_clean', $stock_val)";
                $conn->query($insert_size_sql);
            }
        }

        if ($_SESSION['role'] == 'admin') {
            write_logJSON("New product added with ID " . $new_product_id . " by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'] ." : " . $product_name, "insert" ,"product", "changes_log.json");
        }
        header("Location: /student024/Shop/backend/views/products.php?success=Product+added+successfully");
    } else {
        header("Location: /student024/Shop/backend/views/products.php?error=Error+adding+product:+".$conn->error);
    }


?>