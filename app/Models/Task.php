<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Khai báo các trường cho phép lưu vào Database (Mass Assignment)
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'assigned_to',
        'created_by',
        'attachment_path',
        'attachment_name',
        'attachment_type',
    ];

    // Khai báo ép kiểu dữ liệu
    protected $casts = [
        'due_date' => 'datetime', // Bắt buộc Laravel giữ lại Giờ:Phút:Giây
    ];

    /**
     * Get the user who created the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who is assigned to perform the task.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    /**
 * Danh sách bình luận của công việc
 */
    public function comments()
   {
       return $this->hasMany(Comment::class);
   }
}