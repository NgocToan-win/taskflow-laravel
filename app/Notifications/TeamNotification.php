<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeamNotification extends Notification
{
    use Queueable;

    public $team;
    public $action;
    public $actorName;

    public function __construct($team, $action, $actorName)
    {
        $this->team = $team;
        $this->action = $action;
        $this->actorName = $actorName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $messages = [
            'invited'   => "{$this->actorName} đã mời bạn vào nhóm: {$this->team->name}",
            'accepted'  => "{$this->actorName} đã đồng ý tham gia nhóm: {$this->team->name}",
            'requested' => "{$this->actorName} xin gia nhập nhóm do bạn quản lý: {$this->team->name}",
            'approved'  => "{$this->actorName} đã duyệt bạn vào nhóm: {$this->team->name}",
            // Thêm 2 dòng dưới đây
            'removed'   => "Bạn đã bị trưởng nhóm {$this->actorName} xóa khỏi nhóm: {$this->team->name}",
            'left'      => "{$this->actorName} đã từ chối lời mời hoặc rời khỏi nhóm: {$this->team->name}",
        ];

        return [
            'title' => 'Thông báo nhóm',
            'action' => $this->action,
            'message' => $messages[$this->action] ?? 'Có hoạt động mới trong nhóm của bạn.',
        ];
    }
}