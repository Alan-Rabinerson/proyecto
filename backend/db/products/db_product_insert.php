<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';

    // get data
    $product_name = $_GET['product_name'];
    $product_price = $_GET['price'];
    $product_description = $_GET['description'];
    $product_stock = $_GET['stock'];
    $product_supplier = $_GET['supplier'];
    $product_category = $_GET['category'];

    print_r($_GET); // debug
    // put data into database
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $sql = "INSERT INTO 024_products (name, description, price, stock, supplier) VALUES ('$product_name', '$product_description', $product_price, $product_stock, '$product_supplier')";





    // send confirmation or error message
    if ($conn->query($sql) === TRUE) {
        echo "<main><h2 class='mt-4'>New product created successfully</h2>";
        echo "<p>Product Name: $product_name</p>";
        echo "<p>Description: $product_description</p>";
        echo "<p>Price: $product_price</p>";
        echo "<p>Stock: $product_stock</p>";
        echo "<p>Supplier: $product_supplier</p>";
        echo "<p>Category: $product_category</p></main>";
    } else {
        echo "<main><h2 class='mt-4'>Error: " . $sql . "<br>" . $conn->error . "</h2></main>";
    }


    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';
?>