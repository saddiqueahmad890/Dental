<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data to DB</title>
</head>
<body>
    <form action="user" method="POST">
    @csrf  
    <input type="number" name="id" placeholder="Enter the Id"><br><br>
    <input type="text" name="name" placeholder="Enter the Name"><br><br>
    <input type="text" name="department" placeholder="Enter the Department"><br><br>
    <input type="text" name="gender" placeholder="Enter the gender"><br><br>
    <button type="submit">Save</button>
    </form> 
</body>
</html>