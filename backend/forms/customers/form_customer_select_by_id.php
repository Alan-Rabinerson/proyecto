<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/header.php'; ?>

    <main>
        <h2 class="mt-4">Select Customer by ID</h2>
        <form action="./form_customer_update.php" method="GET" class="mt-3">
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer ID:</label>
                <input type="number" class="form-control" id="customer_id" name="customer_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Select Customer</button>
        </form>
    </main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/includes/footer.php';  ?>