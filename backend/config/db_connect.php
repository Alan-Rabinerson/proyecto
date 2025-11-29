<?php
$username = 'root';
$password = '';
$host = 'localhost';
$database = 'online_shop';

$conn = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($conn, 'utf8');

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}

?>