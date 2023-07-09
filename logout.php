<?php
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang login.php sau khi đăng xuất
header("Location: login.php");
exit();
?>
