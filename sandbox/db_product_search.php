<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/sandbox/search_product.php';
    $searchTerm = $_POST['searchTerm'] ?? '';
    $products = searchProduct($conn, $searchTerm);

    foreach ($products as $product) {
        echo "<div class='border p-4 m-2 bg-white text-black rounded shadow-md w-64'>
                <h2 class='text-xl font-bold mb-2'>{$product['name']}</h2>
                <p class='mb-2'>{$product['description']}</p>
                <p class='font-semibold'>Precio: \${$product['price']}</p>
              </div>";
    }
?>