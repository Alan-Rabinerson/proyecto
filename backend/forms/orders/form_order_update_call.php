<form action="/student024/shop/backend/forms/orders/form_order_update.php" method="POST">
    <input type="number" name="order_number" value="<?php echo $order_number; ?>" required readonly hidden>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Order</button>
</form>