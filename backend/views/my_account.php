<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?> 
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/read_customer_data.php'; ?>

        <main class="bg-azul-oscuro min-h-screen text-beige p-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-semibold mb-6">Mi cuenta</h1>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Sidebar -->
                    <aside class="md:col-span-1 bg-azul-claro p-4 rounded">
                        <nav>
                            <ul class="space-y-2 text-sm">
                                <li><a class="block px-3 py-2 rounded hover:bg-azul-oscuro" href="#account-summary">Resumen</a></li>
                                <li><a class="block px-3 py-2 rounded hover:bg-azul-oscuro" href="/student024/Shop/backend/views/my_orders.php">Mis pedidos</a></li>
                                <li><a class="block px-3 py-2 rounded hover:bg-azul-oscuro" href="#addresses">Direcciones</a></li>
                                <li><a class="block px-3 py-2 rounded hover:bg-azul-oscuro" href="#payment-methods">Métodos de pago</a></li>
                                <li><a class="block px-3 py-2 rounded hover:bg-azul-oscuro" href="/student024/shop/backend/login/change_password.php">Cambiar contraseña</a></li>
                            </ul>
                        </nav>
                    </aside>

                    <!-- Content -->
                    <section class="md:col-span-3 bg-azul-oscuro p-6 rounded border border-azul-claro">
                        <!-- Account summary -->
                        <div id="account-summary" class="mb-8">
                            <h2 class="text-2xl font-medium mb-3">Resumen de cuenta</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                <div class="p-4 bg-azul-claro rounded">
                                    <p class="text-sm text-beige opacity-80">Nombre</p>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($full_name ?? ($_SESSION['username'] ?? 'Usuario'), ENT_QUOTES); ?></p>
                                </div>
                                <div class="p-4 bg-azul-claro rounded">
                                    <p class="text-sm text-beige opacity-80">Email</p>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?></p>
                                </div>
                                <div class="p-4 bg-azul-claro rounded">
                                    <p class="text-sm text-beige opacity-80">Teléfono</p>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($phone ?? '', ENT_QUOTES); ?></p>
                                </div>
                                <div class="p-4 bg-azul-claro rounded">
                                    <p class="text-sm text-beige opacity-80">Pedidos</p>
                                    <p class="font-semibold text-white"><a class="underline" href="/student024/Shop/backend/views/my_orders.php">Ver mis pedidos</a></p>
                                </div>
                            </div>
                           <?php include_once $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/customers/form_customer_update_call.php'; ?>
                        </div>

                        <!-- Addresses -->
                        <div id="addresses" class="mb-8">
                            <h3 class="text-xl font-medium mb-2">Direcciones</h3>
                            <?php if (!empty($addresses)): ?>
                                <ul class="space-y-2">
                                    <?php foreach ($addresses as $addr): ?>
                                        <li class="p-3 bg-azul-claro rounded">
                                            <?php echo htmlspecialchars(($addr['street'] ?? '') . ', ' . ($addr['city'] ?? '') . ' ' . ($addr['zip_code'] ?? ''), ENT_QUOTES); ?>
                                            <form action="db_address_delete.php" method="POST" class="inline">
                                                <button type="submit" class="mt-2 px-4 py-2 bg-rojo rounded text-white hover:bg-granate" value="<?php echo $addr['address_id']; ?>">Eliminar dirección</button>
                                            </form>
                                            <button onClick="window.location.href='/student024/shop/backend/forms/addresses/form_address_update.php" id="manage-addresses-btn" class="mt-4 ml-2 px-4 py-2 bg-azul-oscuro rounded text-white hover:bg-granate">Actualizar direccion</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-beige opacity-80">No hay direcciones guardadas.</p>
                            <?php endif; ?>
                            <button  type="button" onClick="window.location.href='/student024/shop/backend/forms/addresses/form_address_insert.php'" id="add-address-btn" class="mt-4 px-4 py-2 bg-green-600 rounded text-white hover:bg-green-700">Agregar nueva dirección</button>
                            
                        </div>

                        <!-- Payment methods -->
                        <div id="payment-methods" class="mb-8">
                            <h3 class="text-xl font-medium mb-2">Métodos de pago</h3>
                            <?php if (!empty($payment_methods)){ ?>
                                <ul class="space-y-2">
                                    <?php foreach ($payment_methods as $m){ ?>
                                        <li class="p-3 bg-azul-claro rounded"><?php echo htmlspecialchars($m['method_name'] ?? 'Método', ENT_QUOTES); ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <p class="text-beige opacity-80">No hay métodos de pago registrados.</p>
                            <?php } ?>
                        </div>
                        

                    </section>
                </div>
            </div>
        </main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado ?> 