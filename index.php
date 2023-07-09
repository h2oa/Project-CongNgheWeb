<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa. Nếu chưa đăng nhập, chuyển hướng đến trang login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Hiển thị nội dung trang index.php
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Home Page</h1>
        <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
