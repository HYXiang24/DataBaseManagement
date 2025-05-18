<?php
session_start();
session_unset();
session_destroy();
header("Location: home.php"); // 重定向到 home.php
exit();
?>
