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

    // Lưu thông tin blog vào db
    if (saveBlog($userID, $title, $content, $author)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Lỗi: Không thể lưu blog";
    }
}

// Hàm lưu blog vào db
// Done
function saveBlog($userID, $title, $content, $author) {
    include 'db_connection.php';

    // INSERT
    $query = "INSERT INTO blogs (user_id, title, content, created_at, author)
                VALUES ('$userID', '$title', '$content', NOW(), '$author')";

    if (mysqli_query($connection, $query)) {
        mysqli_close($connection);
        return true;
    } else {
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
    <title>Create Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create a New Blog</h1>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            <input type="hidden" name="author" value="<?php echo $_SESSION['username']; ?>">
            <button type="submit">Create Blog</button>
        </form>
    </div>
</body>
</html>
