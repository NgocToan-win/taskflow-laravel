<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        // Lấy tất cả các task có cài ngày hạn chót (due_date) của user hiện tại
        $tasks = Task::where('created_by', Auth::id())
                     ->whereNotNull('due_date')
                     ->get();

        // Định dạng dữ liệu khớp với cấu trúc chuẩn của thư viện FullCalendar
        $events = $tasks->map(function ($task) {
            // Đổ màu chấm lịch dựa theo trạng thái của công việc cho dễ nhìn
            $color = '#4f46e5'; // Màu Indigo cho Chờ xử lý (pending)
            if ($task->status === 'in_progress') {
                $color = '#fb923c'; // Màu Cam cho Đang làm
            } elseif ($task->status === 'completed') {
                $color = '#4ade80'; // Màu Xanh lá cho Hoàn thành
            }

            return [
                'id' => $task->id,
                'title' => $task->title,
                // Định dạng chuẩn có chữ T ở giữa (VD: 2026-05-28T09:30:00)
                'start' => \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i:s'), 
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'description' => $task->description,
                    'status' => $task->status
                ]
            ];
        });

        return view('calendar.index', compact('events'));
    }
}