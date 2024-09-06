<?php
namespace App\Mail;

use App\Models\PatientAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorAppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(PatientAppointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->view('emails.doctor_reminder')
                    ->subject('Appointment Reminder')
                    ->with(['appointment' => $this->appointment]);
    }
}
