<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = auth()->user()->notifications()->take(10)->get();
    return response()->json($notifications);
}

public function markRead($id)
{
    $notif = auth()->user()->notifications()->findOrFail($id);
    $notif->update(['is_read' => true]);
    return response()->json(['success' => true]);
}

public function markAllRead()
{
    auth()->user()->unreadNotifications()->update(['is_read' => true]);
    return response()->json(['success' => true]);
}
}

