<?php
// delete all session data and redirect to main page
session_start();
session_unset();
header("Location: /student024/Shop/backend/login/login.php");
exit();
?>