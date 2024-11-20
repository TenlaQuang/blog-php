<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Thêm bình luận vào bài viết.
     */
    // public function store(Request $request, $postId)
    // {
    //     $request->validate([
    //         'content' => 'required|string|max:255',
    //     ]);

    //     $post = Post::findOrFail($postId);

    //     Comment::create([
    //         'post_id' => $post->id,
    //         'user_id' => Auth::id(),
    //         'content' => $request->content,
    //     ]);

    //     return redirect()->back()->with('success', 'Bình luận thành công!');
    // }
    public function store(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    // Tạo mới bình luận
    $comment = Comment::create([
        'post_id' => $post->id,
        'user_id' => Auth::id(),
        'content' => $request->content,
    ]);

    // Trả về phản hồi với thông tin bình luận và tên người dùng
    return response()->json([
        'status' => 'success',
        'message' => 'Bình luận thành công!',
        'comment' => $comment,
        'user_name' => $comment->user->name, // Thêm tên người dùng
    ]);
}

}
