<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<main>
    <h1>Productos</h1>
    <p>Gestión de productos.</p>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/products/form_product_insert.php'">Añadir Producto</button>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/products/db_product_list.php'; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>
