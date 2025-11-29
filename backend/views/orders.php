<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado 
    if ($_SESSION['role'] == 'user') {
        header("Location: /student024/shop/backend/views/my_orders.php");
        exit;
    }
?>
<main>
    <h1>Pedidos</h1>
    <p>Gestión de pedidos.</p>
    <form action="./orders.php" method="POST">
        <input type="text" name="order_id" placeholder="ID del pedido" class="border-azul-claro border" required>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar Pedido</button>
    </form>
    <button class="mt-4 mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" onclick="location.href='/student024/shop/backend/views/my_orders.php'">Ver Mis los Pedidos</button>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/orders/form_order_insert.php'">Añadir Pedido</button>
    <div class="orders-container mt-4 h-fit w-fit flex flex-wrap items-center justify-center gap-4">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/orders/db_order_list.php'; ?>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>