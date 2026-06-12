<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Liên kết khóa ngoại với bảng tasks (Nếu xóa task thì tự động xóa hết comment liên quan)
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); 
            
            // Liên kết khóa ngoại với bảng users (Để biết ai là người viết bình luận đó)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Cột lưu nội dung của bình luận
            $table->text('content'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};