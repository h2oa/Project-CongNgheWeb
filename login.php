<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa. Nếu đã đăng nhập, chuyển hướng đến trang dashboard.php
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Kiểm tra xem người dùng đã gửi yêu cầu đăng nhập hay chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra dữ liệu đăng nhập
    if (validateLogin($username, $password)) {
        // Đăng nhập thành công, lưu thông tin người dùng vào session
        $_SESSION['user_id'] = getUserID($username);
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Thông tin đăng nhập không hợp lệ";
    }
}

// Hàm kiểm tra thông tin đăng nhập
function validateLogin($username, $password) {
    include 'db_connection.php';

    // Truy vấn người dùng dựa trên tên đăng nhập
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    // Kiểm tra số hàng kết quả
    if (mysqli_num_rows($result) > 0) {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        // So sánh mật khẩu đã mã hóa từ form đăng nhập với mật khẩu đã lưu trong cơ sở dữ liệu
        if (password_verify($password, $hashedPassword)) {
            // Mật khẩu đúng, trả về true
            mysqli_close($connection);
            return true;
        }
    }

    // Đóng kết nối
    mysqli_close($connection);
    return false;
}

// Hàm lấy ID của người dùng dựa trên tên đăng nhập
function getUserID($username) {
    include 'db_connection.php';

    // Truy vấn người dùng dựa trên tên đăng nhập
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    // Lấy ID của người dùng từ kết quả truy vấn
    $row = mysqli_fetch_assoc($result);
    $userID = $row['id'];

    // Đóng kết nối
    mysqli_close($connection);

    return $userID;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
            <p>Không có tài khoản? Đăng ký tại <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
