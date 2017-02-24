<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/photoFunctions.php';?>

<?php 
// In practice, to be set at login
$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["userID"];
//$_SESSION["albumID"] = "hello";
$albumID = $_SESSION["albumID"];
echo $albumID;

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Photos</title>

<head>
</head>

</head>

<body>

<h1>My Photos</h1>

<?php 
// in reality, get user id from sessions
$userID = 105;
?>

<?php
$selectAlbums = "SELECT AlbumName FROM albums WHERE OwnerID = {$userID}";
?>


<h2>Create an Album!</h2>

<form action = "../process/processCreateAlbum.php" method="post">

Album Name: <br>
<input type="text" name="albumName" placeholder="Enter a name for your album!" required><br>

Who can see your album? <br>
<select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
</select><br>

<input type="submit" value = "Create Album!">

</form>


<h2>Upload Photos!</h2>

<!-- Form to allow users to upload photos -->
<form action="uploadPhotos.php" method="post" enctype="multipart/form-data">

Select an Image: <br>
<input type="file" name = "uploadedimage"><br>

Choose an album for your image: <br>
<select name = "albumName">;
<? getUserAlbumsCB($userID, $link); // displays the photo albums of the currently logged-in user ?>
</select><br>

<input type = "submit" value = "Upload Now!"><br>

</form>


<h2> Your Albums! </h2>

<form action = "../process/processDisplayAlbum.php" method="post">

<?php getUserAlbumBtns($userID, $link); ?>

</form>

<br>
<?php displayAllUserPhotos($userID, $link) ?>
<br>
<h2> Photos from album </h2>
<?php displayAlbumPhotos($albumID, $link)?>

<?php
mysqli_close($link);
?>

</body>
</html>