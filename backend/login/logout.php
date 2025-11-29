<?php
session_start();
session_unset();
session_destroy();
header("Location: /student024/shop/backend/index.php");
exit();
?>