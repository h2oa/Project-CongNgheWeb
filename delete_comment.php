<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

if (isset($_GET['comment_id'])) {
    $commentID = $_GET['comment_id'];

    // Xóa bình luận từ db
    if (deleteComment($commentID, $userID)) {
        // success
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $error_message = "Lỗi: Không thể xóa bình luận";
    }
} else {
    header("Location: dashboard.php");
    exit();
}

// Hàm xóa bình luận từ db
// Done
function deleteComment($commentID, $userID) {
    include 'db_connection.php';

    // Xác minh bình luận thuộc về người dùng hiện tại trước khi xóa
    // $query = "SELECT * FROM comments WHERE id = '$commentID' AND user_id = '$userID'";
    $query = "SELECT * FROM comments WHERE id = '$commentID'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Qeury xóa bình luận từ db
        // Done
        $deleteQuery = "DELETE FROM comments WHERE id = '$commentID'";
        mysqli_query($connection, $deleteQuery);
        
        mysqli_close($connection);
        return true;
    }

    mysqli_close($connection);
    return false;
}
?>
