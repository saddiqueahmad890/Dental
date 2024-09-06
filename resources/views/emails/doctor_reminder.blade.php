<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body>
    <h1>Dear Dr. {{ $appointment->doctor->name }},</h1>
    <p>This is a reminder for your upcoming appointment with {{ $appointment->user->name }} on {{ $appointment->appointment_date }}.</p>
    <p>Thank you.</p>
</body>
</html>
