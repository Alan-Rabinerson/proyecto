<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/sandbox/search_product.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $searchTerm = $_POST['searchTerm'] ?? '';
    $products = searchProduct($conn, $searchTerm);
    $submit = $_POST['submit'] ?? false;
?>
<main class="bg-azul-oscuro min-h-screen p-6 text-beige">
    <h1 class="text-2xl font-bold mb-4 text-center text-beige">Productos</h1>
    <p>Gestión de productos.</p>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="location.href='/student024/shop/backend/forms/products/form_product_insert.php'">Añadir Producto</button>
    <form action="./products.php" method="POST">
        <input type="text" name="searchTerm" placeholder="Buscar producto..." class="px-2 py-1 border border-gray-300 rounded" />
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Buscar</button>
    </form>
    <div class="flex flex-wrap items-center justify-center gap-2">
        <?php 
        if ($submit) {
            if(empty($products)){
                ?><p class="text-beige">No se encontraron productos.</p><?php
            }else{
                foreach ($products as $product){ ?>
                    <div class="product-card border border-gray-400 rounded p-4 m-2 w-64 bg-white text-black">
                        <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p class="mb-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="font-semibold">Precio: $<?php echo number_format($product['price'], 2); ?></p>
                    </div>
         <?php  } 
            }
        }else {
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/products/db_product_list.php';
        }
    ?>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?>
