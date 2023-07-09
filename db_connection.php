<?php
// Thông số database
// Sử dụng MySQL của Xampp server
$host = 'localhost';
$port = 3306;
$database = 'mysql_database';
$username = 'root';
$password = '';

// Connect đến db
$connection = mysqli_connect($host, $username, $password, $database, $port);

// Check lỗi
if (!$connection) {
    die("Lỗi kết nối: " . mysqli_connect_error());
}

// Ghi dữ liệu đúng định dạng
mysqli_set_charset($connection, 'utf8mb4');

// Ví dụ: Lấy dữ liệu từ bảng 'users'
// $query = "SELECT * FROM users";
// $result = mysqli_query($connection, $query);

// if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
//     }
// } else {
//     echo "Không có dữ liệu.";
// }

// Ngắt kết nối
// mysqli_close($connection);
?>
