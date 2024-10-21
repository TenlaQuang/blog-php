<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng Bài</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Đăng Bài Mới</h2>
        <form action="post.php" method="POST">
            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Bài</button>
        </form>
    </div>

    <?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'db.php'; // Kết nối cơ sở dữ liệu

        $content = $_POST['content'];
        $user_id = $_SESSION['user_id']; // Giả định bạn đã lưu ID người dùng trong phiên

        $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
        if ($conn->query($sql) === TRUE) {
            echo "Bài đăng thành công!";
            header("Location: index.php"); // Quay lại trang chính sau khi đăng bài
            exit();
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
