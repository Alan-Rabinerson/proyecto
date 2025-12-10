<form action="/student024/Shop/backend/db/products/db_product_delete.php" method="POST" >
    <div class="mb-3">
        
        <input type="text" class="hidden" id="productId" name="productId" value="<?php echo $product_id; ?>" readonly required hidden>
    </div>
    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete Product</button>
</form>

