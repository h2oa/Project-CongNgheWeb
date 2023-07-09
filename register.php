<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa. Nếu đã đăng nhập, chuyển hướng đến trang dashboard.php
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Kiểm tra xem người dùng đã gửi yêu cầu đăng ký hay chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';
    // Lấy dữ liệu từ form đăng ký
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Kiểm tra dữ liệu đăng ký
    if (validateRegistration($username, $password, $email)) {
        // Đăng ký thành công, lưu thông tin người dùng vào cơ sở dữ liệu (hoặc thực hiện các thao tác khác)
        // Sau đó, chuyển hướng đến trang login.php để người dùng đăng nhập
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Thông tin đăng ký không hợp lệ";
    }
}

// Hàm kiểm tra thông tin đăng ký (có thể thay thế bằng logic xác thực khác)
function validateRegistration($username, $password, $email) {
    // Nếu thông tin đăng ký hợp lệ, cập nhật thông tin người dùng vào cơ sở dữ liệu
    if (insertUser($username, $password, $email)) {
        return true;
    }

    return false;
}

function insertUser($username, $password, $email) {
    include 'db_connection.php';

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Chuẩn bị truy vấn INSERT
    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";

    // Thực hiện truy vấn
    if (mysqli_query($connection, $query)) {
        // Đóng kết nối
        mysqli_close($connection);
        return true;
    } else {
        // Xử lý lỗi nếu có
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
