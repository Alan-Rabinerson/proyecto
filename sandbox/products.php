<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado 
    $searchTerm = $_POST['searchTerm'] ?? '';
    $submit = $_POST['submit'] ?? false;
?>

<main class="bg-azul-oscuro min-h-screen p-6 text-beige">
    <h1 class="text-2xl font-bold mb-4 text-center text-beige">Productos</h1>
    <p>Gestión de productos.</p>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/products/form_product_insert.php'">Añadir Producto</button>
    <form action="./products.php" method="GET">
        <input type="text" name="searchTerm" id="searchTerm" placeholder="Buscar producto..." class="px-2 py-1 border border-gray-300 rounded" onkeyup="showProducts(this.value)" />
    </form>
    <div class="flex flex-wrap items-center justify-center gap-2" id="txtHint">
        
    </div>
</main>
<script src="/student024/shop/sandbox/showproducts.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>

