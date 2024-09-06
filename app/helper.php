<?php

use App\Models\Notification;

use Carbon\Carbon;


use App\Mail\DynamicMail;
use Illuminate\Support\Facades\Mail;

if (!function_exists('sendDynamicEmail')) {
    function sendDynamicEmail($recipientName, $recipientEmail, $messageBody)
    {
        // Validate email address format
        if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email address provided.");
        }

        Mail::to($recipientEmail)->send(new DynamicMail($recipientName, $messageBody));
    }
}

if (!function_exists('getDocNumber')) {
    function getDocNumber($id,$type='')
    {
        return $type . date('y') . date('m') . str_pad($id,  STR_PAD_LEFT);


    }
}


if (!function_exists('displayIndexValue')) {
    function displayIndexValue($index,$array)
    {
        $index = trim($index);
        if(is_numeric($index)) {
            if(array_key_exists($index,$array)) {
                return $array[$index];
            } else {
                return $index;
            }
        } else if(!empty($index)) {
            return $index;
        }
    }
}




if (!function_exists('calculateAge')) {
    function calculateAge($date_of_birth)
    {
        $dob = Carbon::parse($date_of_birth);
        $today = Carbon::now();

        $years = $today->diffInYears($dob); // Use $dob instead of $date_of_birth

        return [
            'years' => $years,
        ];
    }
}


if (!function_exists('sendNotification')) {
    function sendNotification($Id, $url, $msg, $userId = null)
    {
        $notification = new Notification([
            'notification_from' => auth()->id(),
            'notification_to' => $userId ?? 1,
            'text' => $msg,
            'url' => route($url, $Id),
        ]);
        $notification->save();
    }
}
