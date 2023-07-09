<?php
// Thay đổi các giá trị dưới đây để phù hợp với cấu hình của bạn
$host = 'localhost';
$port = 3306;
$database = 'mysql_database';
$username = 'root';
$password = '';

// Kết nối đến cơ sở dữ liệu
$connection = mysqli_connect($host, $username, $password, $database, $port);

// Kiểm tra lỗi kết nối
if (!$connection) {
    die("Lỗi kết nối: " . mysqli_connect_error());
}

// Đặt bộ mã hóa kết nối để đảm bảo đọc và ghi dữ liệu đúng dạng
mysqli_set_charset($connection, 'utf8mb4');

// Các đoạn mã khác và thao tác với cơ sở dữ liệu sẽ sử dụng biến $connection này

// Ví dụ: Lấy dữ liệu từ bảng 'users'
// $query = "SELECT * FROM users";
// $result = mysqli_query($connection, $query);

// if (mysqli_num_rows($result) > 0) {
//     // Xử lý kết quả truy vấn
//     while ($row = mysqli_fetch_assoc($result)) {
//         echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
//     }
// } else {
//     echo "Không có dữ liệu.";
// }

// Đóng kết nối sau khi hoàn tất các thao tác
// mysqli_close($connection);
?>
