<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Notification;
use App\Services\NotificationService;

class Notifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = ['notificationAdded' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::active()
            ->latest()
            ->take(20)
            ->get();

        $this->unreadCount = Notification::active()
            ->unread()
            ->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        NotificationService::markAllAsRead();
        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        Notification::find($notificationId)?->delete();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin.notifications');
    }
}
