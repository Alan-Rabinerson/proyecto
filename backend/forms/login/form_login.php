<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php'; ?>
<main>
    <h1>Login</h1>
    <form action="/student024/shop/backend/db/login/db_login_validation"  method="POST">
        <div>
            <label for="username">Username:</label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="password" name="password" required>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" type="submit" onclick="event.preventDefault(); this.form.submit();">Login</button>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php'; ?>
