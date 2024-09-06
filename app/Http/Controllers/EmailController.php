<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendemail(Request $request)
    {
        $data = [
            'name' => 'John Doe',
            'message' => 'You have a new notification!',
            'url' => 'http://example.com'
        ];

        Mail::to('user@example.com')->send(new UserNotification($data));

        return back()->with('success', 'Email sent successfully!');
    }
}
