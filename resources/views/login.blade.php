<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions</title>
</head>
<body>
    <form action="user" method="POST">
    @csrf
    <input type="text" name="user" placeholder="Enter the User Name"><br>
    <input type="password" name="password" placeholder="Enter the User Password"><br><br>
    <button type="submit">Login</button>
    </form>
</body>
</html>
