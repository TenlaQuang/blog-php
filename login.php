<?php
session_start();
include 'db.php'; // Kết nối cơ sở dữ liệu

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Xác thực mật khẩu
        if (password_verify($password, $row['password'])) {
            // Thiết lập phiên người dùng
            $_SESSION['user_id'] = $row['id']; // Lưu ID người dùng
            $_SESSION['username'] = $username;  // Lưu tên người dùng
            header("Location: index.php"); // Chuyển hướng về trang chính
            exit();
        } else {
            $error_message = "Mật khẩu không chính xác.";
        }
    } else {
        $error_message = "Tên người dùng không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng Nhập</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Đăng Nhập</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Tên Người Dùng:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật Khẩu:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>

        <p class="mt-3">Bạn chưa có tài khoản? <a href="register.php">Đăng Ký ngay!</a></p>
    </div>
</body>
</html>
