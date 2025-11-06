<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Proyecto</title>
        <link rel="stylesheet" href="/student024/Shop/styles/output.css">
    </head>
    <body>
        <header class="w-full bg-background p-3 mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="/student024/Shop/assets/logos/logo_sin_fondo._rectangular.png" alt="Logo" class="h-auto max-h-24 object-contain"/>
                </div>
                <nav class="flex items-center justify center">
                    <ul class="flex space-x-2 list-none p-0 m-0">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <li class="px-3 py-1 rounded"><a href="/student024/Shop/backend/"><img class="max-w-8" src="/student024/Shop/frontend/assets/logos/carrito_blanco.png" alt=""></a></li>
                        <?php } ?>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/index.php">Home</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/products.php">Products</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/customers.php">Customers</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/orders.php">Orders</a></li>
                    </ul>
                    <div class="ml-4">
                        <?php if (isset($_SESSION['username'])){ ?>
                            <span class="mr-2 text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/login/logout.php';">Logout</button>
                        <?php } else { ?>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="window.location.href='/student024/Shop/backend/forms/login/form_login.php'">Login</button>
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




