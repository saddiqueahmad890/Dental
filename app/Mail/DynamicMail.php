<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $messageBody;

    public function __construct($name, $messageBody)
    {
        $this->name = $name;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->view('emails.dynamicemail')
            ->with([
                'name' => $this->name,
                'messageBody' => $this->messageBody,
            ]);
    }
}
