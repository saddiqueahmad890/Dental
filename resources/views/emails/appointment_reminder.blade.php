<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body>
    <h1>Appointment Reminder</h1>
    <p>Dear {{ $appointment->user->name }},</p>
    <p>This is a reminder for your upcoming appointment with Dr. {{ $appointment->doctor->name }} on {{ $appointment->appointment_date }} at {{ $appointment->start_time }}.</p>
    <p>Thank you!</p>
</body>
</html>
