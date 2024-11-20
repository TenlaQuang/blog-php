<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách bài viết.
     */
    public function index()
    {
        $posts = Post::with(['comments.user', 'likes'])->orderBy('created_at', 'desc')->get();

        $userLikes = Like::where('user_id', Auth::id())->pluck('post_id')->toArray();

        return view('blog', compact('posts', 'userLikes'));
    }

    /**
     * Lưu bài viết mới.
     */
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // Tạo bài viết mới
    $post = Post::create([
        'content' => $request->content,
        'user_id' => Auth::id(),
    ]);

    // Kiểm tra xem có ảnh nào được upload không
    if ($request->hasFile('images')) {
        $imagePaths = [];
        foreach ($request->file('images') as $file) {
            $folderPath = public_path('assets/img/posts');
            
            // Kiểm tra và tạo thư mục nếu chưa có
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true);
            }

            // Tạo tên file duy nhất
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = 'posts/' . $filename;

            try {
                // Di chuyển file vào thư mục lưu trữ
                $file->move($folderPath, $filename);

                // Lưu thông tin ảnh vào bảng `post_images`
                PostImage::create([
                    'post_id' => $post->id, // Liên kết với bài viết
                    'image_url' => $filePath, // Lưu đường dẫn ảnh
                ]);
            } catch (\Exception $e) {
                return back()->with('error', 'Không thể upload ảnh');
            }
        }
    }

    return redirect()->back()->with('success', 'Thêm bài viết và ảnh thành công!');
}

    /**
     * Xử lý hành động "Like/Bỏ Like".
     */
    public function like($id)
    {
        $post = Post::findOrFail($id);
        $userId = Auth::id();

        // Kiểm tra nếu người dùng đã like bài viết chưa
        $existingLike = Like::where('user_id', $userId)->where('post_id', $post->id)->first();

        if ($existingLike) {
            // Nếu đã like, xóa like
            $existingLike->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Đã bỏ like bài viết.',
                'likes_count' => $post->likes_count // Cập nhật số lượt like
            ]);
        } else {
            // Nếu chưa like, thêm like
            Like::create([
                'user_id' => $userId,
                'post_id' => $post->id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Đã like bài viết.',
                'likes_count' => $post->likes_count // Cập nhật số lượt like
            ]);
        }
    }
    

    /**
     * Lưu bình luận mới.
     */
    public function storeComment(Request $request, $postId)
    {  $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $postId,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được đăng.');
    }
    
    
}
