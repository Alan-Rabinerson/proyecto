<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<main>
    <h2 class="mt-4">Ver Productos</h2>
    <form action="../db/db_product_select.php" method="GET" class="mt-3">
        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID (leave empty to view all):</label>
            <input type="number" class="form-control" id="product_id" name="product_id">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View Products</button>
    </form>
    
    
</main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado ?>