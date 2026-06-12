<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Thêm dòng khai báo Auth ở đây cho gọn

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Lấy thống kê số lượng
        $totalTasks = Task::where('assigned_to', $userId)->count();
        $inProgressTasks = Task::where('assigned_to', $userId)->where('status', 'in_progress')->count();
        $completedTasks = Task::where('assigned_to', $userId)->where('status', 'completed')->count();
        $pendingTasksCount = Task::where('assigned_to', $userId)->where('status', 'pending')->count();
        
        // Task quá hạn (hạn chót nhỏ hơn hôm nay và chưa hoàn thành)
        $overdueTasks = Task::where('assigned_to', $userId)
                            ->where('due_date', '<', Carbon::now())
                            ->where('status', '!=', 'completed')
                            ->count();

        // 2. Tính phần trăm (Tránh lỗi chia cho 0 nếu chưa có task nào)
        $inProgressPercent = $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100, 1) : 0;
        $completedPercent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

        // Lấy danh sách task cho bảng Kanban (phân trang 5 task/trang, pagination độc lập từng cột)
        $pendingTasksList = Task::where('assigned_to', $userId)->where('status', 'pending')->latest()->paginate(5, ['*'], 'pending_page')->withQueryString();
        $inProgressTasksList = Task::where('assigned_to', $userId)->where('status', 'in_progress')->latest()->paginate(5, ['*'], 'inprogress_page')->withQueryString();
        $completedTasksList = Task::where('assigned_to', $userId)->where('status', 'completed')->latest()->paginate(5, ['*'], 'completed_page')->withQueryString();

        // ==========================================
        // 3. DỮ LIỆU MỚI CHO BIỂU ĐỒ (CHART.JS)
        // ==========================================
        
        // A. Dữ liệu Biểu đồ tròn (Tỉ lệ hoàn thành)
        $chartPieData = [$completedTasks, $inProgressTasks, $overdueTasks];

        // B. Dữ liệu Biểu đồ cột (Task mới trong 7 ngày qua)
        $chartBarLabels = [];
        $chartBarData = [];
        
        // Chạy vòng lặp lùi về 6 ngày trước cho đến hôm nay
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            // Lấy tên ngày (VD: 28/05)
            $chartBarLabels[] = $date->format('d/m'); 
            // Đếm số task được gán tạo trong ngày đó
            $chartBarData[] = Task::where('assigned_to', $userId)->whereDate('created_at', $date->toDateString())->count();
        }

        // 4. LẤY HOẠT ĐỘNG GẦN ĐÂY (5 thông báo mới nhất)
        // Code đã được viết ngắn gọn lại nhờ có khai báo Auth ở trên
        $recentActivities = Auth::user()->notifications()->latest()->take(5)->get();

        // 5. Truyền tất cả biến ra ngoài View
        return view('dashboard', compact(
            'totalTasks', 'inProgressTasks', 'completedTasks', 'overdueTasks',
            'inProgressPercent', 'completedPercent',
            'pendingTasksList', 'inProgressTasksList', 'completedTasksList',
            'pendingTasksCount',
            'chartPieData', 'chartBarLabels', 'chartBarData',
            'recentActivities'
        ));
    }
}