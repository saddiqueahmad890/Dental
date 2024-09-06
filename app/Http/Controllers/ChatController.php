<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);


        $chat = Chat::create($validatedData);
        if ($chat->save()) {
            $notification = new Notification([
                'notification_from' => Auth::id(),
                'notification_to' => 1,
                'text' => 'chat notification',
                'url' => route('tasks.show', $chat->task_id),
            ]);
            $notification->save();
        }

        return back()->with('success', 'Message sent successfully!');
    }
}
