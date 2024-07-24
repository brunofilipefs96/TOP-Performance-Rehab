<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->with('notificationType')
            ->orderBy('pivot_created_at', 'desc')
            ->paginate(12);

        return view('pages.notifications.index', compact('notifications'));
    }

    public function redirectAndMarkAsRead(Notification $notification)
    {
        $user = Auth::user();
        $user->notifications()->updateExistingPivot($notification->id, ['read_at' => now()]);

        return redirect($notification->url);
    }

    public function markAsRead(Notification $notification)
    {
        $user = Auth::user();
        $user->notifications()->updateExistingPivot($notification->id, ['read_at' => now()]);

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->wherePivot('read_at', null)->get();

        foreach ($notifications as $notification) {
            $user->notifications()->updateExistingPivot($notification->id, ['read_at' => now()]);
        }

        return redirect()->back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function deleteAll()
    {
        $user = Auth::user();
        $user->notifications()->detach();

        return redirect()->back()->with('success', 'Todas as notificações foram eliminadas.');
    }

    public function destroy(Notification $notification)
    {
        //
    }
}
