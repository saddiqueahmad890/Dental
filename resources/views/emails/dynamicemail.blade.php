e<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .header img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #333333;
            margin-top: 0;
        }
        .content p {
            color: #666666;
            line-height: 1.5;
        }
        .content .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #999999;
            border-top: 1px solid #dddddd;
            border-radius: 0 0 10px 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://mir-s3-cdn-cf.behance.net/user/230/6f56a6809497741.5ffc91be6d25b.jpg" alt="Confirmation Image">
            <h1>Welcome to Logistic Twenty47</h1>
        </div>
        <div class="content">
            <h2>Hello, {{ $name }}</h2><br>
            <p>
                {{$messageBody}}
            </p>
            <br>
            {{-- <img src="{{ $attachment }}" alt=""> --}}
            <br><br><br><br>
            <p>We are excited to inform you that your account has been created successfully. Welcome to Logistic Twenty47! We are thrilled to have you on board and look forward to working with you.</p>
            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
            <a href="mailto:abi.fuuast@gmail.com" class="button">Contact Support</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Logistic Twenty47. All rights reserved.
        </div>
    </div>
</body>
</html>
