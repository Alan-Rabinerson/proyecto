<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';  
    if ($_SESSION['role'] == 'user') {
        header("Location: /student024/shop/backend/views/my_orders.php");
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/functions/showOrders.php';
?>
<main>
    <h1>Pedidos</h1>
    <p>Gestión de pedidos.</p>
    <form  method="GET">
        <input type="text" name="order_id" placeholder="ID del pedido" class="border-azul-claro border" onkeyup="showOrders(this.value)" required>
    </form>
    <button class="mt-4 mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" onclick="location.href='/student024/shop/backend/views/my_orders.php'">Ver Mis Pedidos</button>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/orders/form_order_insert.php'">Añadir Pedido</button>
    <div class="orders-container mt-4 h-fit w-fit flex flex-wrap items-center justify-center gap-4" id="orders-container">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/orders/db_order_list.php'; ?>
    </div>
</main>
<script src="/student024/shop/JavaScript/showOrders.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';  ?>