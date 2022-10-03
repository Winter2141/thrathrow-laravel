<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $unreadNotifications = $user->unreadNotifications()->orderByDesc('created_at')->paginate(20);
        $readNotifications = $user->readNotifications()->orderByDesc('created_at')->paginate(20);

        return Inertia::render('Notifications/Index', [
            'unread' => $unreadNotifications,
            'read' => $readNotifications,
        ]);
    }

    public function markRead(string $notification)
    {
        $user = \Auth::user();
        $n = $user->notifications()->find($notification);
        if ($n == null) {
            throw new \Exception('dsdfsd');
        }

        $n->markAsRead();

        return Redirect::route('notifications.index');
    }
}
