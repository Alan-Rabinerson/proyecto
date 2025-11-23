<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'];
?>
<form method="POST" class="add-to-cart-form flex flex-col gap-4 items-center justify-center mt-4">
    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add to Cart</button>
</form>