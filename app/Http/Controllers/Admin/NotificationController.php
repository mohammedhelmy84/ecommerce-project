<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // هات إشعارات الأدمن الحالي
        $notifications = Auth::user()->notifications;

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    }

    public function latest()
    {
        $user = auth()->user();

        return response()->json([
            'count' => $user->unreadNotifications->count(),
            'notifications' => $user->notifications()->latest()->take(5)->get(),
        ]);
    }


}
