<?php 
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
session_start();
$customer_id = $_SESSION['customer_id'];


?>
<form action="/student024/shop/backend/db/shopping_cart/db_shopping_cart_insert.php" method="POST">
    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
    </div>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add to Cart</button>
</form>