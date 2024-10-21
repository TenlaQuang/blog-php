<?php
session_start();
include 'db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Trang Chính</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Trang Chính</h1>

        <?php if ($is_logged_in): ?>
            <a href="post.php" class="btn btn-primary mb-3">Thêm Bài Đăng</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-secondary mb-3">Đăng Nhập</a>
            <a href="register.php" class="btn btn-secondary mb-3">Đăng Ký</a>
        <?php endif; ?>

        <!-- Lấy các bài đăng -->
        <?php
        $sql = "SELECT posts.id, users.username, posts.content, posts.created_at 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hiển thị bài đăng
            while($row = $result->fetch_assoc()) {
                echo "<div class='card mt-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['username'] . "</h5>";
                echo "<p class='card-text'>" . $row['content'] . "</p>";
                echo "<p class='card-text'><small class='text-muted'>" . $row['created_at'] . "</small></p>";

                // Hiển thị bình luận
                $post_id = $row['id'];
                $comment_sql = "SELECT comments.content, users.username 
                                FROM comments 
                                JOIN users ON comments.user_id = users.id 
                                WHERE comments.post_id = $post_id";
                $comment_result = $conn->query($comment_sql);

                if ($comment_result->num_rows > 0) {
                    while ($comment = $comment_result->fetch_assoc()) {
                        echo "<div class='ml-3'>";
                        echo "<strong>" . $comment['username'] . ":</strong> " . $comment['content'];
                        echo "</div>";
                    }
                }

                // Form bình luận
                echo "<form action='comment.php' method='POST'>";
                echo "<input type='hidden' name='post_id' value='$post_id'>";
                echo "<div class='form-group'>";
                echo "<input type='text' class='form-control' name='content' placeholder='Bình luận...' required>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-secondary'>Gửi</button>";
                echo "</form>";

                echo "</div></div>";
            }
        } else {
            echo "<p>Không có bài đăng nào.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
