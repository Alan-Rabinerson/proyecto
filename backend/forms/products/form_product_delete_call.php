<form action="/student024/Shop/backend/forms/products/form_product_delete.php" method="POST" class="mt-3">

    <div class="mb-3">
        <input type="number" class="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>" readonly hidden required>

        <input type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" value="Delete Product">
        
        
    </div>
</form>