<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Content của index.php
// Sửa thêm
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
