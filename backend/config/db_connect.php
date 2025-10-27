<?php
$username = 'root';
$password = '';
$host = 'localhost';
$database = 'online_shop';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}

?>