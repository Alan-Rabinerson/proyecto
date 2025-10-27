<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<main>
    <h1>Pedidos</h1>
    <p>Gestión de pedidos.</p>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/orders/form_order_insert.php'">Añadir Pedido</button>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/orders/db_order_list.php'; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>