<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flash Sessions</title>
</head>
@if(session('user'))
<h3>Data Saved for {{session('user')}}</h3>
@endif
<body>
    <form action="user" method="POST">
    @csrf  
    <input type="text" name="user" placeholder="Enter the User Name"><br><br>
    <input type="text" name="email" placeholder="Enter the User Email"><br><br>
    <button type="submit">Save</button>
    </form> 
</body>
</html>


