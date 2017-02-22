<?php include 'connect.php'?>
<?php
ini_set('$file_uploads', 'On');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
</head>

<body>

<form action="processSignIn.php" method="post" enctype="multipart/form-data">

Email: <input type="text" name="email" placeholder="Enter email" required><br>

Password: <input type="password" name = "pass" placeholder="Enter Password" required><br>

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