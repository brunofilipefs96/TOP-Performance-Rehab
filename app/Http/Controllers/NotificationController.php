<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->with('notificationType')
            ->orderBy('pivot_created_at', 'desc')
            ->paginate(12);

        return view('pages.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $user = Auth::user();
        $user->notifications()->updateExistingPivot($notification->id, ['read_at' => now()]);

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
