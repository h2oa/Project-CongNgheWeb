<?php

include 'db_connection.php';
include 'register.php';
include 'login.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['email'])) {
    $email_re = $_GET['email'];
    $parts = explode('@', $email_re);
    $username_re = $parts[0];
    $password_re = 'default_password';
    if (validateRegistration($username_re, $password_re, $email_re)) {
        // Đăng ký với thông tin người dùng vào cơ sở dữ liệu
        if (validateLogin($username_re, $password_re)) {
            // Đăng nhập thành công, lưu thông tin người dùng vào session
            $_SESSION['user_id'] = getUserID($username_re);
            $_SESSION['username'] = $username_re;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Thông tin đăng nhập không hợp lệ";
            header("Location: login.php");
        }
    } else {
        // header("Location: login.php?success=0");
        if (validateLogin($username_re, $password_re)) {
            // Đăng nhập thành công, lưu thông tin người dùng vào session
            $_SESSION['user_id'] = getUserID($username_re);
            $_SESSION['username'] = $username_re;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Thông tin đăng nhập không hợp lệ";
            header("Location: login.php");
        }
    }
}