<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos del producto a actualizar
    $product_id = $_POST['product_id'];
    // fetch product data from database based on product_id
    $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $product_id = $products[0]['product_id'];
    $product_name = $products[0]['name'];
    $description = $products[0]['description'];
    $price = $products[0]['price'];
    $stock = $products[0]['stock'];
    $supplier = $products[0]['supplier'];
   

?>
        <main>
            <h2 class="mt-4">Update Product</h2>
            <form action="/student024/shop/backend/db/products/db_product_update.php" method="GET" class="mt-3">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product ID to Update:</label>
                    <input type="number" class="form-control" id="product_id" name="product_id" readonly value="<?php echo $product_id; ?>" >
                </div>
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required value="<?php echo $product_name; ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" required value="<?php echo $description; ?>">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required value="<?php echo $price; ?>">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required value="<?php echo $stock; ?>">
                </div>
                <div class="mb-3">
                    <label for="supplier" class="form-label">Supplier:</label>
                    <input type="text" class="form-control" id="supplier" name="supplier" required value="<?php echo $supplier; ?>">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="1">Football</option>
                        <option value="2">Basketball</option>
                        <option value="3">Tennis</option>
                        <option value="4">Clothing</option>
                        <option value="5">Footwear</option>
                        <option value="6">Outdoor</option>
                        <option value="7">Running</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 mt-4">Update Product</button>
            </form>
        </main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>