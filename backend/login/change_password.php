<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';?> 
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/read_customer_data.php'; 
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/login/db_change_password.php';?>
        <main class="bg-azul-oscuro min-h-screen text-beige p-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-semibold mb-6">Cambiar Contraseña</h1>

                <section id="change-password" class="bg-azul-oscuro p-6 rounded border border-azul-claro max-w-md">
                    <form action="/student024/shop/backend/login/change_password.php" method="POST" class="space-y-4" >
                        <div>
                            <label for="current_password" class="block text-sm font-medium mb-1">Contraseña Actual</label>
                            <input type="password" id="current_password" name="current_password" required class="w-full p-2 rounded bg-azul-claro border border-azul-claro text-white">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium mb-1">Nueva Contraseña</label>
                            <input type="password" id="new_password" name="new_password" required class="w-full p-2 rounded bg-azul-claro border border-azul-claro text-white">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium mb-1">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-2 rounded bg-azul-claro border border-azul-claro text-white">
                        </div>
                        <div>
                            <input type="hidden" name="submit" value="">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Cambiar Contraseña</button>
                        </div>
                    </form>
                </section>
            </div>
        </main>

<?php 

include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';?> 