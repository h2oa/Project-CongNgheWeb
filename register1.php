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
        $error_message = "Thông tin đăng ký không hợp lệ, username hoặc email đã tồn tại!";
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

<html lang="en"> 
 <head> 
  <meta charset="UTF-8"> 
  <title>Register</title> 
  <link rel="stylesheet" href="css/login.css"> 
 </head> 

 <body>
 <script src='./js/handle_register.js'></script>
 <div class="container">
	<div class="screen">
		<div class="screen__content">

        <?php if (isset($error_message)) { ?>
            <?php echo "<script src=\"./js/error_register.js\"></script>"; ?>
        <?php } ?>
			<form class="login" method="POST" action="">
                <div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="email" id="email" name="email" class="login__input" placeholder="Email" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" id="username" name="username" class="login__input" placeholder="Username" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" id="password" name="password" class="login__input" placeholder="Password" required>
				</div>
				<button class="button login__submit">
					<span class="button__text">Register Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
                <button class="button login__submit" id="btn_signin" onclick="hrefLogin()">
                    <span class="button__text">Register Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>	
			</form>
		</div>
        <div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div> 
 </body>
</html>
