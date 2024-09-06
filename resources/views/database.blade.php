<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<table border="1">
        <tr>
            <td>ID</td>
            <td>Company Id</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Birthday</td>
        </tr>
        @foreach($users as $student)
        <tr>
            <td>{{$student['id']}}</td>
            <td>{{$student['company_id']}}</td>
            <td>{{$student['name']}}</td>
            <td>{{$student['email']}}</td>
            <td>{{$student['phone']}}</td>
            <td>{{$student['date_of_birth']}}</td>
        </tr>
        @endforeach
</table>
<div>{{$users->links()}}</div>
<style>
    .w-5{
        display: none;
    }


</style>
</body>
</html>