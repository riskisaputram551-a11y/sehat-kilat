<?php

namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationHelper
{
    public static function send($userId, $title, $message, $type = 'info', $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'link' => $link,
        ]);
    }

    public static function getUnreadCount()
    {
        return Notification::where('user_id', Auth::id())->where('is_read', false)->count();
    }

    public static function getNotifications($limit = 10)
    {
        return Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function markAsRead($id)
    {
        $notif = Notification::where('user_id', Auth::id())->find($id);
        if ($notif) {
            $notif->update(['is_read' => true]);
        }
        return $notif;
    }

    public static function markAllAsRead()
    {
        return Notification::where('user_id', Auth::id())->update(['is_read' => true]);
    }
}