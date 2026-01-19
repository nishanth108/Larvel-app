<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = auth()->user();
        $notifications = $user->notifications;  // Eager load
        $notification = $notifications->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
