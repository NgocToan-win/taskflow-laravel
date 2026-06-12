<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReportNotification;

class ReportController extends Controller
{
    // 1. Hiển thị trang Báo cáo
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Task::where('assigned_to', Auth::id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lấy tất cả task của user để tính toán số liệu tĩnh đầy đủ
        $allTasks = Task::where('assigned_to', Auth::id())->get();
        
        // Tính toán số liệu tổng quan
        $stats = [
            'total' => $allTasks->count(),
            'completed' => $allTasks->where('status', 'completed')->count(),
            'in_progress' => $allTasks->where('status', 'in_progress')->count(),
            'pending' => $allTasks->where('status', 'pending')->count(),
        ];

        // Phân trang danh sách công việc (10 task trên 1 trang)
        $tasks = $query->latest()->paginate(10)->withQueryString();

        return view('reports.index', compact('tasks', 'stats', 'search'));
    }

    // 2. Chức năng Xuất file CSV (Đọc được bằng Excel)
    public function exportCsv()
    {
        $tasks = Task::where('assigned_to', Auth::id())->latest()->get();
        $filename = "bao_cao_cong_viec_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Tên công việc', 'Trạng thái', 'Hạn chót', 'Ngày tạo'];

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            
            // Thêm mã BOM để Excel đọc tiếng Việt có dấu (UTF-8) không bị lỗi font
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $status = 'Chờ xử lý';
                if($task->status == 'in_progress') $status = 'Đang làm';
                if($task->status == 'completed') $status = 'Hoàn thành';

                $row = [
                    $task->id,
                    $task->title,
                    $status,
                    $task->due_date ? ' ' . \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Không có',
                    ' ' . $task->created_at->format('d/m/Y')
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        // Ghi nhận lịch sử xuất báo cáo vào quả chuông thông báo
        Auth::user()->notify(new ReportNotification());

        return response()->stream($callback, 200, $headers);
    }
}