<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}

// Content của index.php
// Sửa thêm
?>
