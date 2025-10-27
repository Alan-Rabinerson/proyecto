<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Proyecto</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body>
        <header class="w-full bg-blue-900 p-3 mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="/student024/Shop/frontend/assets/logos/logo_sin_slogan_rectangular.png" alt="Logo" class="h-auto max-h-24 object-contain"/>
                </div>
                <nav class="flex items-center">
                    <ul class="flex space-x-2 list-none p-0 m-0">
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/index.php">Home</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/products.php">Products</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/customers.php">Customers</a></li>
                        <li class="px-3 py-1 bg-white border border-gray-200 rounded"><a class="text-blue-600 hover:underline" href="/student024/Shop/backend/orders.php">Orders</a></li>
                    </ul>
                    <div class="ml-4">
                        <?php if (isset($_SESSION['username'])){ ?>
                            <span class="mr-2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
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




