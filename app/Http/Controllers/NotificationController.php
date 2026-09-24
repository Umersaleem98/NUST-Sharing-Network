<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mark Single Notification As Read
    |--------------------------------------------------------------------------
    */

    public function markAsRead(string $notification): RedirectResponse
    {
        $user = Auth::user();

        $userNotification = $user
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($userNotification->read_at)) {
            $userNotification->markAsRead();
        }

        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | Mark All Notifications As Read
    |--------------------------------------------------------------------------
    */

    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back();
    }
}