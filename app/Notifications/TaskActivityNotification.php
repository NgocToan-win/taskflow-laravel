<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskActivityNotification extends Notification
{
    use Queueable;

    public $task;
    public $action;

    // Nhận dữ liệu truyền vào (Task gì? Hành động gì?)
    public function __construct($task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    // Chọn kênh gửi thông báo là Database
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Cấu trúc dữ liệu sẽ lưu vào database
    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id ?? null,
            'title' => $this->task->title ?? 'Một công việc',
            'action' => $this->action, // VD: 'tạo mới', 'cập nhật', 'xóa'
            'message' => 'Bạn vừa ' . $this->action . ' công việc: ' . ($this->task->title ?? ''),
        ];
    }
}