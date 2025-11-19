<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?>
<main>
    <h1>Clientes</h1>
    <p>Gestión de clientes.</p>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/customers/form_customer_insert.php'">Añadir Cliente</button>
    

        <div class="flex flex-wrap items-center justify-center gap-4">
            <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/customers/db_customer_list.php'; ?>
        </div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>