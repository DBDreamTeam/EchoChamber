<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/photoFunctions.php';?>

<?php 
// In practice, to be set at login
$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["userID"];
$albumID = $_SESSION["albumID"]; // $albumID should be set to "allAlbums" at start of session
//echo $albumID;

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

<?php include '../includes/navigation.php'?>

<h2>Create an Album</h2>
<!-- Form to create a new album-->
<form action = "../process/processCreateAlbum.php" method="post">

<p>Album Name:</p>
<input type="text" name="albumName" placeholder="Enter a name for your album!" required><br>

<p>Who can see your album?</p>
<select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
</select><br>

<input type="submit" value = "Create Album!">

</form>

<h2>Upload Photos!</h2>
<!-- Form to allow users to upload photos -->
<form action="../process/processUploadPhotos.php" method="post" enctype="multipart/form-data">

<p>Select an Image:</p>
<input type="file" name = "uploadedimage"><br>

<p>Choose an album for your image:</p>

<select name = "albumName">;
<? getUserAlbumsCB($userID, $link); // displays the photo albums of the currently logged-in user ?>
</select><br>

<input type = "submit" value = "Upload Now!"><br>

</form>

<h2> Your Albums! </h2>
<!-- buttons for users to select which of their albums they want to display -->
<form action = "../process/processDisplayAlbum.php" method="post">

<button type="submit" value="allPhotos" name="albumID">All Albums</button><br>

<?php $userAlbums = getUserAlbumIDs($userID, $link); 

for($i=0; $i<count($userAlbums); $i++) {
    $albumName = getAlbumNameFromID($userAlbums[$i], $link);
?>
    <button type="submit" value="<?php echo $userAlbums[$i]; ?>"name = "albumID"><?php echo $albumName; ?></button>
<?php
}
?>
</form>

<br>
<!-- displays user's albums depending on selection made -->
<?php
if(strcmp($albumID, "allPhotos") == 0) {
    displayAllUserPhotos($userID, $link);
} else {
    displayAlbumPhotos($albumID, $link);
}
?>

<?php
mysqli_close($link);
?>

</body>
</html>