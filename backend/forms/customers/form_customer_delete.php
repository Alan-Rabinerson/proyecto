<form action="/student024/Shop/backend/db/customers/db_customer_delete.php" method="GET">
    <div class="mb-3">
        <input type="number" name="id" class="hidden" id="id"  value="<?php echo $customer_id; ?>" required readonly hidden>
    </div>
    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete Customer</button>
</form>
    