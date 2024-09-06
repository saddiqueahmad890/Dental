<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
@include ('day')
<body>
    @for ($i=0; $i< 10; $i++)
    <br>
    {{$i}}
    @endfor
    <!-- @if($name=="zahid")
    <h3>Welcome Zahid</h3>
    @elseif($name=="umer")
    <h3>Welcome Umer</h3> 
    @else
    {{$name}}<br> Is a Unknown User   </body>
    @endif -->
</html>