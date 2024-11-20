<?php
$visitors = 200;
$tours = 50;
$fiveStarReviews = 200;
$positiveFeedback = 95;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <!-- CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/blog.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <!-- Header top -->
        <div class="header__top">
            <div class="container__fluid">
                <div class="header__top-inner">
                    <a href="" class="logo">
                        <img src="../assets/img/logo.png" alt="" class="logo__img">
                    </a>
                    <nav class="navbar">
                        <ul class="navbar__list">
                            <li class="navbar__item">
                                <a href="../" class="navbar__link">Home</a>
                            </li>
                            <li class="navbar__item">
                                <a href="about.php" class="navbar__link">About Us</a>
                            </li>
                            <li class="navbar__item">
                                <a href="destinations.php" class="navbar__link">Destinations </a>
                            </li>
                            <li class="navbar__item">
                                <a href="tour.php" class="navbar__link">Tour </a>
                            </li>
                            <li class="navbar__item">
                                <a href="blog.php" class="navbar__link navbar__link--active">Blog </a>
                            </li>
                            <li class="navbar__item">
                                <a href="contact.php" class="navbar__link">Contact Us </a>
                            </li>
                        </ul>
                    </nav>
                    <a href="account.php" class="header__account">
                        <i class="fa-regular fa-user"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->
    <!-- Main -->
    <main class="main">
    <section class="banner">
        <div class="container">
            <div class="banner__inner">
                <p class="section-desc-heading banner__desc">
                    We'd love to hear from you!
                </p>
                <h1 class="section-title banner__title">
                    Destinations Banner
                </h1>
            </div>
        </div>
    </section>

    <section class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Form thêm bài viết mới -->
                    <div class="mb-4 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">
                            Thêm Bài Viết
                        </button>
                    </div>

                    <!-- Cửa sổ Thêm Bài Viết (Modal) -->
                    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostModalLabel">Thêm Bài Viết Mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Nội dung -->
                                        <div class="form-group mb-3">
                                            <label for="content">Nội dung:</label>
                                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                                        </div>

                                        <!-- Input file cho nhiều hình ảnh -->
                                        <div class="form-group mb-3">
                                            <label for="images">Chọn hình ảnh:</label>
                                            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple onchange="previewImages(event)">
                                        </div>

                                        <!-- Hiển thị các hình ảnh đã chọn -->
                                        <div class="form-group mb-3">
                                            <div id="previews" class="d-flex flex-wrap"></div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Thêm bài viết</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách các bài viết -->
                    <div class="mt-4">
                        
                          <!-- Danh sách bài viết -->
                    <h2 class="section-title">Danh sách bài viết</h2>
                    @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <!-- Nội dung -->
                                <p class="card-text">{{ $post->content }}</p>
                                
                                <!-- Hình ảnh -->
                                @if ($post->images)
                                    <div class="post-images">
                                    @foreach ($post->images as $image)
                                        <img src="{{ asset('assets/img/' . $image->image_url) }}" alt="Post Image" style="width:150px; height:150px; margin:5px;">
                                    @endforeach

                                    </div>
                                @endif

                                

                                <!-- Danh sách bình luận -->
                                <h6 class="mt-3">Bình luận:</h6>
                                @foreach($post->comments as $comment)
                                    <div class="comment">
                                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                                    </div>
                                @endforeach
                                <!-- Nút Like và số lượt like (Cùng hàng với form bình luận) -->
                                <div class="d-flex align-items-center mb-3">
                                <div class="likes">
                                    <!-- Hiển thị số lượng like -->
                                    <span class="like-count" id="like-count-{{ $post->id }}">{{ $post->likes_count }} lượt like</span>

                                    <!-- Nút like hoặc hủy like -->
                                    <button class="btn btn-like" id="like-btn-{{ $post->id }}" 
                                        data-post-id="{{ $post->id }}" 
                                        data-liked="{{ $post->likes()->where('user_id', Auth::id())->exists() }}">
                                        @if ($post->likes()->where('user_id', Auth::id())->exists())
                                            Hủy Like
                                        @else
                                            Like
                                        @endif
                                    </button>
                                </div>

                                    <!-- Bình luận -->
                                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="w-100 d-flex">
                                        @csrf
                                        <textarea name="content" class="form-control me-2" placeholder="Viết bình luận..." rows="2" style="resize: none;"></textarea>
                                        <button type="submit" class="btn btn-success">Gửi bình luận</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <h3 class="blog__title section-title">Danh Mục</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="#" class="list-group-link">Điểm đến</a></li>
                        <li class="list-group-item"><a href="#" class="list-group-link">Hướng dẫn du lịch</a></li>
                        <li class="list-group-item"><a href="#" class="list-group-link">Kinh nghiệm</a></li>
                    </ul>

                    <h3 class="blog__title section-title">Theo dõi chúng tôi</h3>
                    <ul class="social">
                        <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.tiktok.com/@ndt02092005?lang=vi-VN"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.instagram.com/entyyy_29/"><i class="fa-brands fa-instagram"></i></a>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

    <!-- End Main -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-12 col-12">
                    <div class="footer__info">
                        <h2 class="footer__info-title">
                            Contact
                        </h2>
                        <div class="footer__info-detail">
                            <div class="footer__info-location">
                                <a href="https://www.google.com/maps/place/279+%C4%90.+Mai+%C4%90%C4%83ng+Ch%C6%A1n,+Ho%C3%A0+H%E1%BA%A3i,+Ng%C5%A9+H%C3%A0nh+S%C6%A1n,+%C4%90%C3%A0+N%E1%BA%B5ng+550000,+Vi%E1%BB%87t+Nam/@15.9902661,108.2439063,17z/data=!3m1!4b1!4m6!3m5!1s0x3142109909a5c113:0xec183e71a660c3b8!8m2!3d15.990261!4d108.2464866!16s%2Fg%2F11hd1zsth0?entry=ttu"
                                    target="_blank" class="footer__info-text">
                                    <strong>Address</strong> : 279 Mai Đăng Chơn - Ngũ Hành Sơn - Đà Nẵng
                                </a>
                            </div>
                            <p>
                                <a href="mailto:contact@tnna.vn" class="footer__info-text"><strong>Email</strong> :
                                    contact@tnna.vn</a>
                            </p>
                            <p>
                                <a href="tel:0876338837" class="footer__info-text"><strong>Hotline</strong> :
                                    0876338837</a>
                            </p>
                        </div>
                        <h3 class="footer__title">
                            Follow Us
                        </h3>
                        <div class="footer__social">
                            <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@ndt02092005?lang=vi-VN"><i class="fa-brands fa-tiktok"></i></i></a>
                            <a href="https://www.instagram.com/entyyy_29/"><i class="fa-brands fa-instagram"></i></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-lg-6 col-6">
                    <div class="footer__place">
                        <h3 class="footer__title">
                            Top destination
                        </h3>
                        <ul class="footer__list">
                            <li class="footer__item"><a href="#" class="footer__link">Cầu sông Hàn</a></li>
                            <li class="footer__item"><a href="#" class="footer__link">Động Phong Nha</a></li>
                            <li class="footer__item"><a href="#" class="footer__link">Chợ Cồn</a></li>
                            <li class="footer__item"><a href="#" class="footer__link">Đình Thái, Con Kec</a></li>
                            <li class="footer__item"><a href="#" class="footer__link">Hội An</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-lg-6 col-6">
                    <div class="footer__place">
                        <h3 class="footer__title">
                            Đéo biết đặt gì
                        </h3>
                        <ul class="footer__list">
                            <li class="footer__item">
                                <a href="about.php" class="footer__link">About Us</a>
                            </li>
                            <li class="footer__item">
                                <a href="blog.php" class="footer__link">Blog</a>
                            </li>
                            <li class="footer__item">
                                <a href="blog.php" class="footer__link">Blog</a>
                            </li>
                            <li class="footer__item">
                                <a href="account.php" class="footer__link">Account</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-lg-6 col-6">
                    <div class="footer__support">
                        <h3 class="footer__title">
                            Hỗ trợ
                        </h3>
                        <ul class="footer__list">
                            <li class="footer__item">
                                <a href="" class="footer__link">Quản trị viên</a>
                            </li>
                            <li class="footer__item">
                                <a href="" class="footer__link">Nhân viên hỗ trợ</a>
                            </li>
                        </ul>
                        <h3 class="footer__title footer__title--pay">
                            Pay
                        </h3>
                        <figure class="footer__img-wrap">
                            <img src="../assets/img/bidv.png" alt="" class="footer__img">
                            <img src="../assets/img/bidv.png" alt="" class="footer__img">
                            <img src="../assets/img/bidv.png" alt="" class="footer__img">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <script src="../assets/bootstrap/jquery.slim.min.js"></script>
    <script src="../assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/about.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    <script>
    function previewImages(event) {
        const previewContainer = document.getElementById('previews');
        previewContainer.innerHTML = ''; // Clear previous previews

        const files = event.target.files;
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '100px';
                img.style.marginRight = '10px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        // Lắng nghe sự kiện click trên nút like
        $('.btn-like').click(function(e) {
            e.preventDefault();

            var postId = $(this).data('post-id'); // Lấy ID bài viết
            var liked = $(this).data('liked'); // Kiểm tra nếu đã like
            var button = $(this);
            
            $.ajax({
                url: '/posts/like/' + postId, // URL route
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    post_id: postId
                },
                success: function(response) {
                    // Cập nhật số lượt like
                    $('#like-count-' + postId).text(response.likes_count + ' lượt like');
                    
                    // Thay đổi trạng thái nút like
                    if (liked) {
                        button.text('Like'); // Nếu đã like thì bỏ like
                    } else {
                        button.text('Hủy Like'); // Nếu chưa like thì like
                    }

                    // Cập nhật trạng thái liked
                    button.data('liked', !liked);
                }
            });
        });
    });
    </script>
    <script>
            $(document).ready(function() {
            $('.comment-form').submit(function(e) {
                e.preventDefault(); // Ngừng gửi form thông thường

                var form = $(this);
                var postId = form.data('post-id'); // Lấy post_id từ data attribute
                var content = form.find('.comment-content').val(); // Lấy nội dung bình luận

                // Gửi AJAX
                $.ajax({
                    url: '/posts/' + postId + '/comment', // URL của route
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                        content: content, // Nội dung bình luận
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Hiển thị bình luận mới ngay trên trang
                            var commentHtml = `
                                <div class="comment">
                                    <p>${response.comment.content} - <strong>${response.comment.user.name}</strong></p>
                                </div>
                            `;
                            form.closest('.post').find('.comments-section').append(commentHtml);

                            // Xóa nội dung textarea
                            form.find('.comment-content').val('');
                        } else {
                            alert('Đã xảy ra lỗi khi gửi bình luận');
                        }
                    },
                    error: function(xhr) {
                        alert('Đã xảy ra lỗi');
                    }
                });
            });
        });
    </script>
</body>

</html>