<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/header.php';  ?>
<main class="container">
    <h1>Seleccionar pedido</h1>
    <form action="/student024/Shop/backend/db/db_order_select.php" method="get">
        <label for="order_number">ID Pedido (dejar en blanco para todos):</label>
        <input type="number" id="order_number" name="order_number"><br><br>

        <input type="submit" value="Buscar Pedido">
    </form>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/footer.php';   ?>