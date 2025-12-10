<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php';
    // get customer_id from session, product_id and order_number from GET
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_GET['product_id'];
    $order_number = $_GET['order_number'];
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
    $sql = "SELECT * FROM 024_products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $product_name = $products[0]['name'];   

?>
<main class="w-screen text-center flex flex-col items-center" >
    
    <span class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold mb-4">Product Review</h1>
        <p class="text-lg "><strong>Product Name:</strong> <?php echo $product_name; ?></p>
    </span>
    
    <div class="flex items-center justify-center gap-4 mt-4 w-full">
        
        <img src='/student024/Shop/assets/imagenes/foto<?php echo htmlspecialchars($product_id, ENT_QUOTES, 'UTF-8'); ?>.jpg' alt='<?php echo htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8'); ?>' class='w-80 h-80 object-cover mb-2 rounded'></img>
    
        <?php if (isset($_GET['error'])) {
            echo "<p class='text-red-500'>" . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . "</p>";
        } ?>
        <form action="/student024/Shop/backend/db/reviews/submit_review.php" class="flex flex-col gap-4" method="POST">
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>" required readonly hidden>
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" required readonly hidden>
            <input type="hidden" name="order_number" id="order_number" value="<?php echo $order_number; ?>" required readonly hidden;>
            <label for="review">Review</label>
            <textarea name="review" id="review" rows="10" cols="50" class="form-control" required></textarea>
            <label for="rating" >Rating (1-5):</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            <button type="submit" class="boton-rojo w-fit">Submit Review</button>
        </form>
    </div>
</main>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php';
?>