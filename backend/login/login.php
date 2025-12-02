<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php'; ?>
<?php

    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $errores = ['usuario' => '', 'login' => '', 'contrasena' => ''];
    if (isset($_POST['submit'])) {
        

        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM 024_customers WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (!preg_match('/^[a-zA-Z0-9_]{3,16}$/', $username)) {
            $errores['usuario'] = "Por favor, inserte un nombre de usuario válido.";
        } else {
            $errores['usuario'] = '';
        }

        if (!preg_match('/^[a-zA-Z0-9_]{6,18}$/', $password)) {
            $errores['contrasena'] = "Por favor, inserte una contraseña válida.";
        } else {
            $errores['contrasena'] = '';
        }

        if (count($user) > 0 && count($user) === 1) {
            // Credenciales válidas, redirigir al backend
            $_SESSION['loggedin'] = true;
            $_SESSION['customer_id'] = $user[0]['customer_id'];
            $_SESSION['username'] = $user[0]['username'];
            setcookie('username', $user[0]['username'], time() + (86400 * 30), "/"); // 86400 = 1 day
            if ($user[0]['type'] == 'admin') {
                $_SESSION['role'] = 'admin';
                header("Location: /student024/shop/backend/index.php");
                exit;
            } else {
                $_SESSION['role'] = 'user';
                header("Location: /student024/shop/frontend/homepage.html");
            }

        } else {
            // Credenciales inválidas, mostrar mensaje de error
            $errores['login'] = 'Usuario o contraseña inválidos. Por favor, inténtelo de nuevo.';
            exit;
        }
    }
?>
<main>
    <h1>Login</h1>
    <form  action="/student024/shop/backend/login/login.php" method="POST">
        <div>
            <label for="username">Username:</label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="username" name="username" required>
            <?php echo '<div class="text-red-500">'.$errores['usuario'].'</div>'; ?>

        </div>
        <div>
            <label for="password">Password:</label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="password" name="password" required>
            <?php echo '<div class="text-red-500">'.$errores['contrasena'].'</div>'; ?>
        </div>
        <?php echo '<div class="text-red-500">'.$errores['login'].'</div>'; ?>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" type="submit" name="submit" >Login</button>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php'; ?>
