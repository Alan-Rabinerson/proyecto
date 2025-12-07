<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/show_success_error_msg.php';// Muestra mensajes de éxito o error
    if ($_SESSION['role'] != 'admin') {
        header("Location: /student024/shop/backend/index.php");
        exit();
    }
?>
<main class="flex items-center flex-col">
    <h1 class="underline text-4xl">Gestión de Clientes</h1>
    <input class="form-control"  type="text" id="searchInput" placeholder="Buscar clientes por nombre" onkeyup="showCustomers(this.value)">
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/customers/form_customer_insert.php'">Añadir Cliente</button>
    <div class="flex flex-wrap items-center justify-center gap-4 mt-4" id="customer-list">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/customers/db_customer_list.php'; ?>
    </div>
    
<script src="/student024/shop/Javascript/showcustomers.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>