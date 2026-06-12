<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportNotification extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Báo cáo',
            'action' => 'xuất báo cáo',
            'message' => 'Bạn vừa xuất một file báo cáo công việc (CSV) về thiết bị.',
        ];
    }
}