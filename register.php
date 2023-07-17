<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';
    // Lấy dữ liệu từ form đăng ký
    $username_re = $_POST['username'];
    $password_re = $_POST['password'];
    $email = $_POST['email'];

    // Kiểm tra
    if (validateRegistration($username_re, $password_re, $email)) {
        // Success, lưu thông tin người dùng vào cơ sở dữ liệu
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Thông tin đăng ký không hợp lệ, kiểm tra lại định dạng email, hoặc username, email đã tồn tại!";
    }
}

// Hàm kiểm tra thông tin đăng ký
// Done
function validateRegistration($username_re, $password_re, $email) {
    include 'db_connection.php';
    // kiểm tra email và username đã tồn tại trong db chưa
    $query_check = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $check_result = $connection->query($query_check);
    if ($check_result->num_rows > 0) {
        return false;
    }
    // Success, update vào db
    if (insertUser($username_re, $password_re, $email)) {
        return true;
    }

    return false;
}

function insertUser($username_re, $password_re, $email) {
    include 'db_connection.php';

    // Encrypt password
    $hashedPassword = password_hash($password_re, PASSWORD_DEFAULT);

    // Query
    $query = "INSERT INTO users (username, password, email) VALUES ('$username_re', '$hashedPassword', '$email')";

    if (mysqli_query($connection, $query)) {
        mysqli_close($connection);
        return true;
    } else {
        // Error
        echo "Lỗi: " . mysqli_error($connection);
        mysqli_close($connection);
        return false;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
