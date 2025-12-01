<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Determine requested path
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = strtolower(parse_url($request_uri, PHP_URL_PATH) ?? '');

    // Whitelist of public paths (no login required)

    if (!isset($_SESSION['username']) && $path !== '/student024/shop/backend/login/login.php' && $path !== '/student024/shop/backend/login/logout.php') {
        header('Location: /student024/Shop/backend/login/login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Proyecto</title>
        <link rel="stylesheet" href="/student024/Shop/styles/output.css">
    </head>
    <body class="bg-azul-oscuro text-beige">
        <header class="header">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="/student024/Shop/assets/logos/logo_sin_fondo._rectangular.png" alt="Logo" class="h-auto max-h-24 object-contain"/>
                </div>
                <nav class="flex items-center justify center">
                    <ul class="flex space-x-2 list-none p-0 m-0">
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/index.php">Home</a></li>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/products.php">Products</a></li>
                        
                        <?php if ( $_SESSION['role'] == 'admin') { ?>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/customers.php">Customers</a></li>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/my_account.php">My Account</a></li>
                        <?php } else { ?>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/my_account.php">My Account</a></li>

                        <?php } ?>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/orders.php">Orders</a></li>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/shopping_cart.php">Shopping Cart</a></li>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/index.html">Homepage</a></li>
                    </ul>
                    <div class="ml-4">
                        <?php if (isset($_SESSION['username'])){ ?>
                            <span class="mr-2 text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/login/logout.php';">Logout</button>
                        <?php } else { ?>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/views/login.php'">Login</button>
                        <?php } ?>
                    </div>
                </nav>
            </div>
            <style>
                header {
                    border-bottom: 2px solid #ccc;
                }

            </style>

        </header>




