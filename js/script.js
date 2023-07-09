// Lắng nghe sự kiện khi tài liệu đã được tải hoàn toàn
document.addEventListener("DOMContentLoaded", function() {
    // Lắng nghe sự kiện khi người dùng nhấp vào nút "Delete" của bình luận
    document.querySelectorAll(".delete-comment").forEach(function(element) {
        element.addEventListener("click", function(event) {
            event.preventDefault();

            // Xác nhận xóa bình luận trước khi thực hiện
            if (confirm("Bạn có chắc chắn muốn xóa bình luận này?")) {
                // Gửi yêu cầu xóa bình luận bằng Ajax
                var commentID = element.getAttribute("data-comment-id");
                deleteComment(commentID);
            }
        });
    });

    // Hàm xóa bình luận bằng Ajax
    function deleteComment(commentID) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_comment.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Xóa bình luận khỏi giao diện người dùng sau khi xóa thành công
                var comment = document.querySelector("#comment-" + commentID);
                if (comment) {
                    comment.remove();
                }
            }
        };
        xhr.send("comment_id=" + commentID);
    }
});
