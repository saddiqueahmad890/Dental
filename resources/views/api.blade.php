<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api Data</title>
</head>
<body>
    <h1>This is the Data from API</h1>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Photo</td>
        </tr>
        @foreach($collection as $user)
        <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['first_name']}}</td>
            <td>{{$user['email']}}</td>
            <td><img src ={{$user ['avatar'] }} alt="" /></td>
        </tr>
        @endforeach
    </table>
        
</body>
</html>