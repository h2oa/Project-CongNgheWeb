# I. Đề tài

Project môn Công nghệ web và dịch vụ trực tuyến.

Hãy sử dụng các kiến thức lập trình frontend và backend mà bạn biết (có thể được học tập trong môn học hoặc tự học), không hạn chế công nghệ (javascript, Java, Python, v.v...) để xây dựng trang web blog với các chức năng sau:

1. Sử dụng tài khoản gmail để login.
2. User sau khi login có thể viết blog của mình. Nội dung blog yêu cầu tối thiểu phải chấp nhận text, hình ảnh, âm thanh. Text có thể được format (đậm, nghiêng, font to/nhỏ, v.v..).
3. Các user khác khi vào blog có thể bình luận và xem các bình luận của người khác
4. User sở hữu bài blog có thể nhìn được tất cả các bình luận và xóa bình luận
5. Yêu cầu giao diện thiết kế đẹp mắt, các chức năng chạy không lỗi.

# Usage

## 1. Tải về mã nguồn

Tải về bằng `git` hoặc Download file zip.

## 2. Xampp

Sử dụng chạy Apache server. Tải về tại https://www.apachefriends.org/download.html.

Chạy service Apache (port 80) và MySQL (port 3306)

![image](https://github.com/lengochoahust/Project-CongNgheWeb/assets/114990730/c8e3d421-a9aa-4ee5-b98e-4a22dcea381a)

Mã nguồn đặt tại `C:\xampp\htdocs` (Thư mục htdocs trong đường dẫn cài đặt của Xampp)

## 3. Tạo cơ sở dữ liệu

- Truy cập http://localhost/phpmyadmin/
- Tạo database với tên `mysql_database`
- Truy cập database `mysql_database`, trong mục SQL chạy các query sau:
- Bảng lưu thông tin người dùng
```
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);
```

- Bảng lưu thông tin các bài blog
```
CREATE TABLE blogs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    author VARCHAR(255),
    image_path VARCHAR(255),
    audio_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

- Bảng lưu thông tin các bình luận
```
CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    blog_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user VARCHAR(255),
    FOREIGN KEY (blog_id) REFERENCES blogs(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## 4. Truy cập trang web

Truy cập trang web tại http://localhost:80/ hoặc http://localhost:80/<tên folder project>
