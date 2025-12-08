<?php
// delete all session data and redirect to main page
session_start();
session_unset();
session_abort();
header("Location: /student024/Shop/backend/login/login.php");
exit();
?>