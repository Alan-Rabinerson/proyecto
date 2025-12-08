<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';  ?>
<main>
    <form action="/student024/shop/backend/db/db_customer_select.php" method="GET">
        <div class="mb-3">
            <label for="customerId" class="form-label">Customer ID (dejar en blanco para todos)</label>
            <input type="text" class="form-control" id="customerId" name="customerId">
        </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar</button>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';  ?>