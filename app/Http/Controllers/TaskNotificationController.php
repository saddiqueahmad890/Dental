<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskNotification;
use Illuminate\Support\Facades\Auth;

class TaskNotificationController extends Controller
{
    public function index()
    {
        $tasknotifications = TaskNotification::where('assign_to', Auth::id())->get();
        return response()->json($tasknotifications);
    }

    public function markAsRead(Request $request)
    {
        $tasknotification = TaskNotification::find($request->id);

        if ($tasknotification) {
            $tasknotification->status = 'read';
            $tasknotification->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function readAll()
    {
        $userId = auth()->id();
        TaskNotification::where('assign_to', $userId)
            ->where('status', 'new')
            ->update(['status' => 'read']);

        return response()->json(['success' => true]);
    }

}
