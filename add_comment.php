<?php
session_start();
include 'db_connection.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$userID = $_SESSION['user_id'];
$user_comment = $_SESSION['username'];

// Lấy dữ liệu từ form bình luận
$blogID = $_POST['blog_id'];
$commentContent = $_POST['comment_content'];

// Xử lý tệp hình ảnh
$imagePath = '';
if ($_FILES['image']['size'] > 0) {
    $imagePath = 'images/' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
}

// Xử lý tệp âm thanh
$audioPath = '';
if ($_FILES['audio']['size'] > 0) {
    $audioPath = 'audio/' . $_FILES['audio']['name'];
    move_uploaded_file($_FILES['audio']['tmp_name'], $audioPath);
}

// Thêm bình luận và đường dẫn tệp vào cơ sở dữ liệu
$query = "INSERT INTO comments (blog_id, user_id, content, image_path, audio_path, created_at, user)
          VALUES ('$blogID', '$userID', '$commentContent', '$imagePath', '$audioPath', NOW(), '$user_comment')";
$result = mysqli_query($connection, $query);

// Chuyển hướng trở lại trang view_blog.php sau khi thêm bình luận thành công
header("Location: view_blog.php?blog_id=$blogID");
exit();
?>
