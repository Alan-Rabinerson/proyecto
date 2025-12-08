<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';  ?>
<main>
    <h1>Insertar Cliente</h1>
    <form action="/student024/shop/backend/db/customers/db_customer_insert.php" method="post">
        <div class="mb-3">
            <label for="first_name" class="form-label">Nombre:</label>
            <input type="text" class="block w-full border border-gray-300 rounded px-3 py-2" id="first_name" name="first_name" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Apellido:</label>
            <input type="text" class="block w-full border border-gray-300 rounded px-3 py-2" id="last_name" name="last_name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico:</label>
            <input type="email" class="block w-full border border-gray-300 rounded px-3 py-2" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono:</label>
            <input type="tel" class="block w-full border border-gray-300 rounded px-3 py-2" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario:</label>
            <input type="text" class="block w-full border border-gray-300 rounded px-3 py-2" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="block w-full border border-gray-300 rounded px-3 py-2" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label">Fecha de Nacimiento:</label>
            <input type="date" class="block w-full border border-gray-300 rounded px-3 py-2" id="birth_date" name="birth_date">
        </div>

        <input type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" value="Insertar Cliente">
    </form>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';   ?>