<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'content',
    ];

    /**
     * Người viết bình luận
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Công việc chứa bình luận
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}