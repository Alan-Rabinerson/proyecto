<?php

$username = 'root';
$password = '';
$host = 'localhost';
$database = 'online_shop';
if ($_SERVER['SERVER_NAME'] === 'remotehost') {
    $username = 'dwess1234';
    $password = 'Usertest1234.';
    $host = 'remotehost';
    $database = 'dwesdatabase';
}



$conn = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($conn, 'utf8');

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}

?>