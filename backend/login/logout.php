<?php
// delete all session data and redirect to main page
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_log.php';
session_start();
write_log("User " . $_SESSION['username'] . " logged out", "connection_log.txt");
session_unset();
header("Location: /student024/Shop/backend/login/login.php");
exit();
?>