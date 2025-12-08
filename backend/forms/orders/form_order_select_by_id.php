<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';  ?>

<main>
    <form action="/student024/shop/backend/forms/form_order_update.php" method="get">
        <label for="order_number">ID del Pedido:</label>
        <input type="number" id="order_number" name="order_number" required>
        <button type="submit">Buscar Pedido</button>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';  ?>