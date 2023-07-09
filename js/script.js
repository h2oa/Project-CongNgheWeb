document.addEventListener("DOMContentLoaded", function() {
    // Xử lý sự kiện khi người dùng nhấp vào nút "Delete" của bình luận
    document.querySelectorAll(".delete-comment").forEach(function(element) {
        element.addEventListener("click", function(event) {
            event.preventDefault();

            if (confirm("Bạn có chắc chắn muốn xóa bình luận này?")) {
                // Ajax handle
                var commentID = element.getAttribute("data-comment-id");
                deleteComment(commentID);
            }
        });
    });

    // deleteComment with Ajax
    function deleteComment(commentID) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_comment.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var comment = document.querySelector("#comment-" + commentID);
                if (comment) {
                    comment.remove();
                }
            }
        };
        xhr.send("comment_id=" + commentID);
    }
});
