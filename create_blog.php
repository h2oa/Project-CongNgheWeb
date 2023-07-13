<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Xử lý tạo blog mới
// Done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    // Cần 1 hàm xử lý hình ảnh
    // Done
    // $imagePath = '';
    // if ($_FILES['image']['size'] > 0) {
    //     $imagePath = 'images/' . $_FILES['image']['name'];
    //     move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    // }

    // Hàm xử lý tệp âm thanh
    // Done
    $audioPath = '';
    if ($_FILES['audio']['size'] > 0) {
        $audioPath = 'audio/' . $_FILES['audio']['name'];
        move_uploaded_file($_FILES['audio']['tmp_name'], $audioPath);
    }

    // Lưu thông tin blog vào db
    if (saveBlog($userID, $title, $content, $author, $audioPath)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Lỗi: Không thể lưu blog";
    }
}

// Hàm lưu blog vào db
// Done
function saveBlog($userID, $title, $content, $author, $audioPath) {
    include 'db_connection.php';

    // INSERT
    // $query = "INSERT INTO blogs (user_id, title, content, created_at, author, image_path, audio_path)
    //             VALUES ('$userID', '$title', '$content', NOW(), '$author', '$imagePath', '$audioPath')";
    $query = "INSERT INTO blogs (user_id, title, content, created_at, author, audio_path)
                VALUES ('$userID', '$title', '$content', NOW(), '$author', '$audioPath')";

    if (mysqli_query($connection, $query)) {
        mysqli_close($connection);
        return true;
    } else {
        echo "Lỗi: " . mysqli_error($connection);
        mysqli_close($connection);
        return false;
    }
}

// // Inseat bình luận và đường dẫn tệp vào db
// $query = "INSERT INTO comments (blog_id, user_id, content, image_path, audio_path, created_at, user)
//           VALUES ('$blogID', '$userID', '$commentContent', '$imagePath', '$audioPath', NOW(), '$user_comment')";
// $result = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create a New Blog</h1>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            <input type="hidden" name="author" value="<?php echo $_SESSION['username']; ?>">
            <!-- <p>Thêm hình ảnh cho comment?</p>
            <input type="file" name="image"> -->
            <p>Thêm audio cho comment?</p>
            <input type="file" name="audio">
            <button type="submit">Create Blog</button>
        </form>
    </div>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
</body>
</html>
