<?php

$username = 'dwess1234';
$host = 'remotehost.es';
$database = 'dwesdatabase';
$password = 'Usertest1234.';

$conn = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($conn, 'utf8');

if (!$conn) {
    http_response_code(500);
    die("Connection failed: " . mysqli_connect_error());
}