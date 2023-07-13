<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$viewer = $_SESSION['username'];

$blogs = getBlogs();

// Hàm lấy danh sách blog từ db
function getBlogs() {
    include 'db_connection.php';

    // Query
    $query = "SELECT blogs.id, blogs.title, blogs.author, users.username, users.id as user_id
          FROM blogs
          INNER JOIN users ON blogs.user_id = users.id";
    $result = mysqli_query($connection, $query);

    $blogs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }

    mysqli_close($connection);

    return $blogs;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
            </tr>
            <?php foreach ($blogs as $blog) { ?>
                <tr>
                <td><a href="view_blog.php?blog_id=<?php echo $blog['id']; ?>&viewer=<?php echo $viewer; ?>&author_blog=<?php echo $blog['author']; ?>"><?php echo $blog['title']; ?></a></td>
                    <td><?php echo $blog['author']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="create_blog.php">Create New Blog</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
