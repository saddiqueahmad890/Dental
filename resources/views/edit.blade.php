<h1>Update Data</h1>
<form action="/identsoft/edit" method="POST">
    @csrf
    <input type="hidden" name="id" value={{$student['id']}} ><br><br>
    <input type="text" name="name" value={{$student['name']}}><br><br>
    <input type="text" name="department" value={{$student['department']}}><br><br>
    <input type="text" name="gender" value={{$student['gender']}}><br><br>
    <button type="submit">Update</button>
</form> 
