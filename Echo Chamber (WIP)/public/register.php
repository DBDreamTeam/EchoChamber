<?php 
include '../includes/connect.php';
mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");

ini_set('$file_uploads', 'On');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
</head>

<body>

<form action="../process/processRegistration.php" method="post" enctype="multipart/form-data">

User Name: <input type="text" name="userName" placeholder="Enter User Name" required><br>

Email: <input type="text" name="email" placeholder="Enter Email" required><br>

Password: <input type="password" name = "password" placeholder="Enter Password" required><br>

Repeat Password: <input type="password" name="pass-repeat" placeholder="Re-enter Password" required><br>

Birthday: 
<select name ="year">
    <option value = "1970">1970</option>
    <option value = "2010">2010</option>
</select>

<select name="month">
    <option value="01">January</option>
    <option value = "03">March</option>
</select>

<select name="day">
    <option value = "01">1</option>
    <option value = "02">2</option>
</select>

<!--<input type="submit">

</form>-->

Picture:
<!--<form action="saveimage.php" method="post" enctype="multipart/form-data">-->
<input type="file" name = "uploadedimage">
<input type = "submit" value = "Upload Image" name = "Upload Now">



</form>

</body>
</html>