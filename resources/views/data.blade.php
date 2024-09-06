<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete from DB</title>
</head>
<body>
    <table border="1">
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Department</td>
                <td>Gender</td>
                <td>Operation</td>
                
            </tr>
            @foreach ($students as $student)
            <tr>
                <td>{{$student['id']}}</td>
                <td>{{$student['name']}}</td>
                <td>{{$student['department']}}</td>
                <td>{{$student['gender']}}</td>
                <td><a href={{"delete/".$student['id']}}>Delete</a>
                <a href={{"edit/".$student['id']}}>Update</a></td>

            </tr>
            @endforeach
    </table>
</body>
</html>