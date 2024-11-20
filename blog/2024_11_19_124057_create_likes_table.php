<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại với bảng users
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Khóa ngoại với bảng posts
            $table->timestamps();

            // Đảm bảo mỗi user chỉ like 1 bài post duy nhất
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
}
