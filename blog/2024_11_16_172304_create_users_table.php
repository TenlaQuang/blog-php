<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột 'id'
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role')->default('user'); // 'user', 'admin', etc.
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->string('avt')->nullable(); // Đường dẫn avatar
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken(); // Token để nhớ phiên đăng nhập
            $table->timestamps(); // Tự động thêm cột 'created_at' và 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
