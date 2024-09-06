<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('notification_to', Auth::id())->get();
        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);

        if ($notification) {
            $notification->status = 'read';
            $notification->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function readAll()
    {
        $userId = auth()->id();
        Notification::where('notification_to', $userId)
            ->where('status', 'new')
            ->update(['status' => 'read']);

        return response()->json(['success' => true]);
    }

}
