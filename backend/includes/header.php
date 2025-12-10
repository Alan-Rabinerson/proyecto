<?php
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Determine requested path
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = strtolower(parse_url($request_uri, PHP_URL_PATH) ?? '');

    // Whitelist of public paths (no login required)
    if (!isset($_SESSION['username']) && $path !== '/student024/Shop/backend/login/login.php' && $path !== '/student024/Shop/backend/login/logout.php' && $path !== '/student024/Shop/backend/views/register.php') {
        header('Location: /student024/Shop/backend/login/login.php');
        exit;   
    }
    // // Restore session from cookie if available
    // if (isset($_COOKIE['user']) && !isset($_SESSION['username'])) {
    //     $userData = json_decode($_COOKIE['user'], true);
    //     if ($userData && isset($userData['username']) && isset($userData['role'])) {
    //         $_SESSION['username'] = $userData['username'];
    //         $_SESSION['role'] = $userData['role'];
    //     }
    // }

    // whitelist of admin-only paths
    $admin_paths = [
        '/student024/Shop/backend/views/customers.php',
        '/student024/Shop/backend/views/reviews.php',
        '/student024/Shop/backend/views/orders.php',
        '/student024/Shop/backend/forms/products/form_product_insert.php',
        '/student024/Shop/backend/forms/products/form_product_delete.php',
        '/student024/Shop/backend/forms/products/form_product_update.php',
        '/student024/Shop/backend/forms/orders/form_order_insert.php',
        '/student024/Shop/backend/forms/orders/form_order_update.php',
        '/student024/Shop/backend/forms/shopping_cart/form_shopping_cart_insert.php',
        '/student024/Shop/backend/forms/shopping_cart/form_shopping_cart_update.php',
    ];
    if (in_array($path, $admin_paths) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
        // User is not admin, redirect to login page or show error
        header('Location: /student024/Shop/backend/index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Proyecto</title>
        <link rel="stylesheet" href="/student024/Shop/styles/css/output.css">
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
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { // if user is admin show the option to manage customers and reviews ?>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/customers.php">Customers</a></li>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/my_account.php">My Account</a></li>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/reviews.php">Review Management</a></li>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/orders.php">Orders</a></li>
                        <?php } else { // if user is not admin show only my account ?>
                            <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/my_account.php">My Account</a></li>

                        <?php } ?>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/my_orders.php">My Orders</a></li>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/backend/views/shopping_cart.php">Shopping Cart</a></li>
                        <li class="px-3 py-1 bg-azul-claro border border-gray-200 rounded"><a class="text-beige hover:underline" href="/student024/Shop/index.html">Homepage</a></li>
                    </ul>
                    <div class="ml-4">
                        <?php if (isset($_SESSION['username'])){ // if user is logged in show avatar, name and logout button ?>
                            <span class="mr-2 text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                            <img src="/student024/Shop/assets/avatars/avatar.png" alt="Avatar" class="inline-block h-8 w-8 rounded-full mr-2 object-cover">
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/login/logout.php';">Logout</button>
                        <?php } else { // if not logged in show login and register buttons ?>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/views/login.php'">Login</button>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/views/register.php'">Register</button>
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




