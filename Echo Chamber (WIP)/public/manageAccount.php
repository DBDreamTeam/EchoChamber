<?php 
include '../includes/connect.php';
include '../includes/functions.php';
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>EchoChamber</title>

<!-- Bootstrap -->
<link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/custom.css" rel="stylesheet" type="text/css">

<title>My Account</title>

</head>

<header>
    <h1><span id="echo">Echo</span>Chamber</h1>
</header>

<body>

<h2>My Account</h2>

<?php include '../includes/navigation.php'?>

<div class="row">
<div class="col-xs-4 col-xs-offset-1">

<h3>Change Password</h3>
<form action="../process/processResetPassword.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label for="password">New Password:</label>
        <input type="password" name = "newPassword" placeholder= "Enter New Password" required class="form-control"><br>
    </div>
    <div class="form-group">
        <label for="password">Repeat New Password: </label>
        <input type="password" name= "repeatNewPassword" placeholder= "Re-enter New Password" required class="form-control"><br>
    </div>
    <input type = "submit" value = "Submit" name = "Confirm"><br>

</form>
 
<h3>Change Privacy Settings</h3>
<form action="../process/processChangeAccountPrivacy.php" method="post">
    <select name="privacy">
    <option value="Friends">Friends</option>
    <option value="Circles">Circles</option>
    <option value="FriendsOfFriends">Friends of Friends</option>
    <option value="Public">Public</option>
    </select>
    <input type="submit" value="Apply changes">
</form>

<h3>Change email address</h3>
<form action ="../process/processChangeEmail.php" method="post">
    <div class="form-group">
        <label for="email">New Email:</label>
        <input type="email" class="form-control" id="email" placehold="newemail@echochamber.com" name="email">
    </div>
    <button type="submit" class="btn btn-default">Change email</button>
</form>

<h3>Change profile pic</h3>
<form action = "../process/processChangeProfilePic.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="file">Upload New Profile Pic:</label>
        <input type="file" name = "uploadedimage"><br>
    </div>
    <button type="submit" class="btn btn-default">Update Profile Pic</button>
</form>

</div>
</div>

</body>
</html>