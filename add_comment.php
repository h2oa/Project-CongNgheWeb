<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$user_comment = $_SESSION['username'];

$blogID = $_POST['blog_id'];
$viewer = $_POST['viewer'];
$authorBlog = $_POST['author_blog'];
$commentContent = $_POST['comment_content'];

// Cần 1 hàm xử lý hình ảnh
// Done
$imagePath = '';
if ($_FILES['image']['size'] > 0) {
    $imagePath = 'images/' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
}

// Hàm xử lý tệp âm thanh
// Done
$audioPath = '';
if ($_FILES['audio']['size'] > 0) {
    $audioPath = 'audio/' . $_FILES['audio']['name'];
    move_uploaded_file($_FILES['audio']['tmp_name'], $audioPath);
}

// Inseat bình luận và đường dẫn tệp vào db
$query = "INSERT INTO comments (blog_id, user_id, content, image_path, audio_path, created_at, user)
          VALUES ('$blogID', '$userID', '$commentContent', '$imagePath', '$audioPath', NOW(), '$user_comment')";
$result = mysqli_query($connection, $query);

header("Location: view_blog.php?blog_id=$blogID&viewer=$viewer&author_blog=$authorBlog");
exit();
?>
