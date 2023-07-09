<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa. Nếu chưa đăng nhập, chuyển hướng đến trang login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$userID = $_SESSION['user_id'];

// Lấy danh sách blog từ cơ sở dữ liệu
$blogs = getBlogs();

// Hàm lấy danh sách blog từ cơ sở dữ liệu
function getBlogs() {
    include 'db_connection.php';

    // Truy vấn danh sách blog
    $query = "SELECT blogs.id, blogs.title, blogs.author, users.username, users.id as user_id
          FROM blogs
          INNER JOIN users ON blogs.user_id = users.id";
    $result = mysqli_query($connection, $query);

    // Lấy danh sách blog từ kết quả truy vấn
    $blogs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }

    // Đóng kết nối
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
                <td><a href="view_blog.php?blog_id=<?php echo $blog['id']; ?>&user_id=<?php echo $blog['user_id']; ?>"><?php echo $blog['title']; ?></a></td>
                    <td><?php echo $blog['author']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="create_blog.php">Create New Blog</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
