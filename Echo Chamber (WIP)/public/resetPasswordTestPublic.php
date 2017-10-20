<?php 
include '../includes/connect.php';
mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");

ini_set('$file_uploads', 'On');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
</head>

<body>

<form action="../process/processResetPassword.php" method="post" enctype="multipart/form-data">

<!-- User Name: <input type="text" name="userName" placeholder="Enter User Name" required><br>

Email: <input type="text" name="email" placeholder="Enter Email" required><br>
-->
New Password: <input type="password" name = "newPassword" placeholder= "Enter New Password" required><br>

Repeat New Password: <input type="password" name= "repeatNewPassword" placeholder= "Re-enter New Password" required><br>

<!--Birthday: 
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
-->
<!--<input type="submit">

</form>-->

<!--<form action="saveimage.php" method="post" enctype="multipart/form-data">-->
<input type = "submit" value = "Submit" name = "Confirm">



</form>

</body>
</html>