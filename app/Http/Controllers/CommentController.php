<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back()->with(
            'success',
            'Đã thêm bình luận thành công!'
        );
    }
}