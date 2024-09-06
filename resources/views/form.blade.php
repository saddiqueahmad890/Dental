<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>This is Login form</h3>
</body>
<!-- @if($errors->any())
@foreach ($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
@endif -->
<form action="doom" method="POST">
    @csrf
    <input type="text" name="username" placeholder="Enter the User Name"><br>
    <span style="color:red">@error('username'){{$message}}@enderror</span><br>
    <input type="password" name="password" placeholder="Enter the User Password"><br><br>
    <span style="color:red">@error('password'){{$message}}@enderror</span><br>
    <button type="submit">Login</button>
</form>
</html>