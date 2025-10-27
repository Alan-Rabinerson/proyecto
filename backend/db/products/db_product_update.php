<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos del producto a actualizar
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];
    $description = $_GET['description'];
    $price = $_GET['price'];
    $stock = $_GET['stock'];
    $supplier = $_GET['supplier'];
    // fetch product data from database based on product_id
    $sql = "UPDATE 024_products SET name='$product_name', description='$description', price=$price, stock=$stock, supplier='$supplier' WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);
 
    // send confirmation or error message
    if ( mysqli_query($conn, $sql) === TRUE) {
        echo "<main><h2 class='mt-4'>Product updated successfully</h2>";
        echo "<p>Product ID: $product_id</p>";
        echo "<p>Product Name: $product_name</p>";
        echo "<p>Description: $description</p>";
        echo "<p>Price: $price</p>";
        echo "<p>Stock: $stock</p>";
        echo "<p>Supplier: $supplier</p></main>";
    } else {
        echo "<main><h2 class='mt-4'>Error updating product: " . mysqli_error($conn) . "</h2></main>";
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado
?>