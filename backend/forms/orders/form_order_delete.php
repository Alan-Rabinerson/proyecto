<form action="/student024/shop/backend/db/orders/db_order_delete.php" method="GET">
    <div class="">
        <input type="number" id="order_number" name="order_number" value="<?php echo $order_number; ?>" required hidden readonly>
    </div>
    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar Pedido</button>
</form>

