<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Hiển thị danh sách thông báo
    public function index()
    {
        // Lấy tất cả thông báo của người dùng, phân trang 10 cái/trang
        $notifications = Auth::user()->notifications()->paginate(10);
        
        return view('notifications.index', compact('notifications'));
    }

    // Đánh dấu tất cả là đã đọc
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}