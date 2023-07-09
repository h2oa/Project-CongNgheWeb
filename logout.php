<?php
session_start();

// Xóa session
$_SESSION = array();

// Hủy session
session_destroy();

header("Location: login.php");
exit();
?>
