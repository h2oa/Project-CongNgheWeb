<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form đăng nhập
    $username_log = $_POST['username'];
    $password_log = $_POST['password'];

    // Check dữ liệu đăng nhập
    if (validateLogin($username_log, $password_log)) {
        // Đăng nhập thành công, lưu thông tin người dùng vào session
        $_SESSION['user_id'] = getUserID($username_log);
        $_SESSION['username'] = $username_log;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_login = true;
        $error_message = "Thông tin đăng nhập không hợp lệ";
    }
}

// Hàm kiểm tra thông tin đăng nhập
function validateLogin($username_log, $password_log) {
    include 'db_connection.php';

    // Truy vấn db
    $query = "SELECT * FROM users WHERE username = '$username_log'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        // Check password
        if (password_verify($password_log, $hashedPassword)) {
            // Success
            mysqli_close($connection);
            return true;
        }
    }

    mysqli_close($connection);
    return false;
}

// Hàm lấy ID của người dùng
function getUserID($username_log) {
    include 'db_connection.php';

    // Query
    $query = "SELECT id FROM users WHERE username = '$username_log'";
    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);
    $userID = $row['id'];

    mysqli_close($connection);

    return $userID;
}
?>

<!DOCTYPE html>

<html lang="en"> 
 <head> 
  <meta charset="UTF-8"> 
  <title>Login</title> 
  <link rel="stylesheet" href="css/login.css"> 
 </head> 

 <body>
 <script src='./js/handle_gmail_login.js'></script>
 <script src='./js/handle_login.js'></script>
 <div class="container">
	<div class="screen">
		<div class="screen__content">

        <?php if (isset($error_message)) { ?>
            <?php echo "<script src=\"./js/error_login.js\"></script>"; ?>
        <?php } ?>
			<form class="login" method="POST" action="">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" id="username" name="username" class="login__input" placeholder="Username" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" id="password" name="password" class="login__input" placeholder="Password" required>
				</div>
				<button class="button login__submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
                <button class="button login__submit" id="btn_signin" onclick="hrefRegister()">
                    <span class="button__text">Register Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
                <button class="button login__submit" id="btn_signin" onclick="handleAuthClick()">
                    Login with Gmail
                </button>
                <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>				
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
