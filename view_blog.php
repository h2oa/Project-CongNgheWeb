<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

if (isset($_GET['blog_id'])) {
    $blogID = $_GET['blog_id'];
} else {
    header("Location: dashboard.php");
    exit();
}

// id người dùng hiện tại đang xem blog
if (isset($_GET['user_id'])) {
    $userID = $_GET['user_id'];
} else {
    // Nếu không có ID người dùng trong URL, sử dụng ID người dùng hiện tại
    $userID = $_SESSION['user_id'];
}


$blog = getBlog($blogID);
$authorBlog = $_GET['author_blog']; // tác giả blog hiện tại
$viewer = $_GET['viewer']; // người xem hiện tại
// Lấy danh sách bình luận của blog
$comments = getComments($blogID);

// Hàm lấy thông tin blog từ db
// Done
function getBlog($blogID) {
    include 'db_connection.php';

    // Query blog dựa trên ID
    $query = "SELECT * FROM blogs WHERE id = '$blogID'";
    $result = mysqli_query($connection, $query);

    $blog = mysqli_fetch_assoc($result);

    mysqli_close($connection);

    return $blog;
}

// Hàm lấy danh sách bình luận của blog từ db
function getComments($blogID) {
    include 'db_connection.php';

    // Query
    $query = "SELECT * FROM comments WHERE blog_id = '$blogID'";
    $result = mysqli_query($connection, $query);

    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    mysqli_close($connection);

    return $comments;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>View Blog</h1>
        <h2><?php echo $blog['title']; ?></h2>
        <p><?php echo $blog['content']; ?></p>
        <?php if (!empty($blog['image_path'])) { ?>
                    <img src="<?php echo $blog['image_path']; ?>" alt="Image">
                <?php } ?>
                <?php if (!empty($blog['audio_path'])) { ?>
                <audio controls>
                    <source src="<?php echo $blog['audio_path']; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                </audio>

        <h3>Comments</h3>
        <?php foreach ($comments as $comment) { ?>
            <div class="comment">
                <div class="comment-content">
                    <?php echo $comment['content']; ?>
                </div>
                <p>Posted by: <?php echo $comment['user']; ?></p>
    <?php } ?>
                <?php if ($viewer == $authorBlog && (count($comments) > 0)) { ?>
                    <a href="delete_comment.php?comment_id=<?php echo $comment['id']; ?>">Delete</a>
                <?php } ?>
            </div>
            
        <?php } ?>
        <form method="POST" action="add_comment.php">
            <input type="hidden" name="blog_id" value="<?php echo $blogID; ?>">
            <input type="hidden" name="viewer" value="<?php echo $viewer; ?>">
            <input type="hidden" name="author_blog" value="<?php echo $authorBlog; ?>">
            <textarea name="comment_content" required></textarea>
            <!-- <p>Thêm hình ảnh cho comment?</p>
            <input type="file" name="image">
            <p>Thêm audio cho comment?</p>
            <input type="file" name="audio"> -->
            <button type="submit">Submit</button>
        </form>



        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
