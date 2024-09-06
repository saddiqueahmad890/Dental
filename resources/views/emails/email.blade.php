<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Dental Clinic</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            color: #007BFF;
        }
        .content {
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $clinicName }}" class="brand-image">
            <h1>Welcome to Our Dental Clinic</h1>
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>Thank you for visiting our dental clinic. We are delighted to have you as our patient and are committed to providing you with the best dental care possible.</p>
            <p>Our clinic offers a wide range of services, including routine check-ups, cleanings, fillings, and more. Our team of experienced professionals is here to ensure that your visit is as comfortable and pleasant as possible.</p>
            <p>If you have any questions or need to schedule your next appointment, please don't hesitate to contact us at {{ $clinicPhone }} or email us at {{ $clinicEmail }}.</p>
            <p>We look forward to seeing you again soon!</p>
            <p>Sincerely,</p>
            <p>{{ $clinicName }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $clinicName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
