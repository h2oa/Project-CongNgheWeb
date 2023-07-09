<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa. Nếu chưa đăng nhập, chuyển hướng đến trang login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$userID = $_SESSION['user_id'];

// Kiểm tra xem có ID bình luận được truyền vào không
if (isset($_GET['comment_id'])) {
    $commentID = $_GET['comment_id'];

    // Xóa bình luận từ cơ sở dữ liệu
    if (deleteComment($commentID, $userID)) {
        // Chuyển hướng về trang trước đó sau khi xóa bình luận thành công
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $error_message = "Lỗi: Không thể xóa bình luận";
    }
} else {
    // Nếu không có ID bình luận được truyền vào, chuyển hướng về trang dashboard.php
    header("Location: dashboard.php");
    exit();
}

// Hàm xóa bình luận từ cơ sở dữ liệu
function deleteComment($commentID, $userID) {
    include 'db_connection.php';

    // Xác minh rằng bình luận thuộc về người dùng hiện tại trước khi xóa
    $query = "SELECT * FROM comments WHERE id = '$commentID' AND user_id = '$userID'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Xóa bình luận từ cơ sở dữ liệu
        $deleteQuery = "DELETE FROM comments WHERE id = '$commentID'";
        mysqli_query($connection, $deleteQuery);
        
        // Đóng kết nối
        mysqli_close($connection);
        return true;
    }

    // Đóng kết nối
    mysqli_close($connection);
    return false;
}
?>
