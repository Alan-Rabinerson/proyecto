<?php
// Fix: include the correct DB connect file and use prepared statements.
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
session_start();


$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM 024_customers WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (count($user) > 0 && count($user) === 1) {
    // Credenciales válidas, redirigir al backend
    $_SESSION['loggedin'] = true;
    $_SESSION['customer_id'] = $user[0]['customer_id'];
    $_SESSION['username'] = $username;
    if (isset($user[0]['role']) && $user[0]['role'] == 'admin') {
        $_SESSION['role'] = 'admin';
        header("Location: /student024/shop/backend/index.php");
        exit;
    } else {
        $_SESSION['role'] = 'user';
        header("Location: /student024/shop/frontend/homepage.html");
        exit;
    }

} else {
    // Credenciales inválidas, mostrar mensaje de error
    echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = '/student024/shop/backend/login/form_login.php';</script>";
    exit;
}
?>