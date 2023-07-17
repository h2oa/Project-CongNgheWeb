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
    <title>View Blog</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/clean-blog.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="css/comment.css"> -->

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
<!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="dashboard.php">Home</a>
                    </li>
                    <li>
                        <a href="create_blog.php">New Blog</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                    <!-- <li>
                        <a href="contact.html">Contact</a>
                    </li> -->
                </ul>
            </div>
        <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <header class="intro-header" style="background-image: url('images/create-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>Create a New Blog</h1>
                        <!-- <h2 class="subheading">Problems look mighty small from 150 miles up</h2> -->
                        <span class="meta">Share interesting things in your life through blogging</span>
                    </div>
                </div>
            </div>
        </div>
    </header>


<!-- Create blog -->

<body>
    <div class="container">
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" style="width: 800px; height: 50px;" required><br>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            <input type="hidden" name="author" value="<?php echo $_SESSION['username']; ?>">
            <!-- <p>Thêm hình ảnh cho comment?</p>
            <input type="file" name="image"> -->
            <p>Thêm audio cho blog?</p>
            <input type="file" name="audio">
            <style>
  .custom-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #337ab7;
    color: white;
    border: none;
    border-radius: 4px;
    text-align: center;
    font-size: 16px;
    cursor: pointer;
    margin-right: 20px;
  }

  .custom-button:hover {
    background-color: #286090;
  }
</style>
            <button type="submit" class="custom-button" style="float: right;">Create Blog</button>
        </form>
    </div>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
</body>
</html>
