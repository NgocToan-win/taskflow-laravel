<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tên công việc
            $table->text('description')->nullable(); // Mô tả chi tiết
            
            // Trạng thái: pending (Chờ xử lý), in_progress (Đang làm), completed (Hoàn thành)
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            
            $table->dateTime('due_date')->nullable(); // Hạn chót
            
            // Khóa ngoại liên kết với bảng users (Người được giao việc)
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            // Khóa ngoại liên kết với bảng users (Người tạo công việc)
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};