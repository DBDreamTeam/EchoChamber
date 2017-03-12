<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>

<?php 
// In practice, to be set at login
//$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["LoggedUserID"];
$albumID = $_SESSION["albumID"]; // $albumID should be set to "allAlbums" at start of session
//echo $albumID;

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Photos</title>

<head>
</head>

</head>

<body>

<h1>Manage Photos</h1>

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
    <option value = "public">Public</option>
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
<? getUserAlbumsCB($loggedUser, $link); // displays the photo albums of the currently logged-in user ?>
</select><br>

<input type = "submit" value = "Upload Now!"><br>

</form>


<h2>Manage Existing Albums</h2>
<h3>Delete or Rename your Albums, or Adjust Privacy Settings</h3>

<?
$privacies = ['Friends', 'Circles', 'FriendsOfFriends', 'Public'];
$userAlbums = getUserAlbumsArr($userID, $link);

for($i=0; $i<count($userAlbums); $i++) {
    $albumName = getAlbumNameFromID($userAlbums[$i], $link); 
    echo $albumName;
    $privArray = array();
    $privArray[0] = getAlbumPrivacySettings($userAlbums[$i], $link);
    ?>
    <form action = "../process/processDeleteAlbum.php" method="post">
        <button type="delete" value="<?php echo $userAlbums[$i];?>" name="albumID">Delete</button>
    </form>
    <form action = "../process/processRenameAlbum.php" method="post">
        <input type="text" placeholder = "Enter a new name for your album" name="newAlbumName">
        <input type="hidden" value="<?php echo $userAlbums[$i];?>" name="albumID">
        <input type="submit" value="Apply Rename">
    </form>
    <form action = "../process/processChangeAlbumPrivacy.php" method="post">
        <select name ="privacy">
        <option value = "Friends">Friends</option>
        <option value = "Circles">Circles</option>
        <option value = "FriendsOfFriends">Friends of Friends</option>
        <option value = "Public">Public</option>
        </select>
        <input type="hidden" value="<?php echo $userAlbums[$i];?>" name="albumID">
        <input type = "submit" value = "Apply privacy settings changes">
    </form>
        
<?php
echo "<br>";
}
?>

<?php
mysqli_close($link);
?>

</body>
</html>