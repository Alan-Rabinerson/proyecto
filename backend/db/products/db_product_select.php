<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/header.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';// Llama al script para obtener los productos

    // verify if product_id is set and is numeric
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
        $product_id = intval($_GET['product_id']);

        // query to obtain product data
        $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);

        print_r($product); // Muestra los datos del producto para verificar

    } else if (empty($_GET['product_id'])) { // if product_id is not set, show all products
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($products as $product) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>".$product['name']."</h5>";
            echo "<p class='card-text'>Description: ".$product['description']."</p>";
            echo "<p class='card-text'>Price: $".$product['price']."</p>";
            echo "<p class='card-text'>Stock: ".$product['stock']."</p>";
            echo "<p class='card-text'>Supplier: ".$product['supplier']."</p>";
            echo "</div>";
            echo "</div>";
        }
        
    }else { // if product_id is not numeric, show error
        echo "<div class='alert alert-danger mt-4'>Invalid product ID.</div>";
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/footer.php'; 
?>
