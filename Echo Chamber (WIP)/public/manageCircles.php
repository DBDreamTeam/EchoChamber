<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>

<? // get session variables
$userID = $_SESSION["LoggedUserID"];
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Circles</title>
</head>

<body>

<h1>Manage Circles</h1>

<?php include '../includes/navigation.php';?>

<h2>Create a New Circle!</h2>

<!-- Form for creating new circle -->
<form action = "../process/processCircleCreate.php" method = "post" enctype="multipart/form-data">

<h3>Select Members for your Circle...</h3>

    <?php getFriends($userID, $link); // Lists all user's friends ?>
    <input type="hidden" name="circleMember[]" value ="<?php echo $userID;?>">

<h3> Give your circle a name...</h3>
    <input type = "text" name="circleName" placeholder = "Name your circle">

<h3> Who has access to your circle?</h3>
    
    <select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
    </select><br>
    
<h3> Upload a nice pic for your circle to marvel at :) </h3>
    
    <input type="file" name = "uploadedimage"><br><br>
    
    <input type = "submit" value = "Create circle!">
</form>

</body>
</html>