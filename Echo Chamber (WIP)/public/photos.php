<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>

<?php 
$loggedUser = $_SESSION["LoggedUserID"];
echo "Logged user ID:" . $loggedUser . "<br>";
$pageOwner = $_SESSION["FriendUserID"];
echo "Page owner ID:" . $pageOwner;


// In practice, to be set at login
//$_SESSION["userID"] = 185;

//$_SESSION["albumID"] = "allAlbums";
?>

<?php
//$userID = $_SESSION["userID"];
$albumID = $_SESSION["albumID"]; // $albumID should be set to "allPhotos" at start of session
echo "<br>" .  $albumID;

?>


<?php


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

<h1>Photos</h1>

<?php include '../includes/navigation.php'?>

<!-- buttons for users to select which of their albums they want to display -->
<form action = "../process/processDisplayAlbum.php" method="post">

<button type="submit" value="allPhotos" name="albumID">All Albums</button><br>

<?php $userAlbums = getAccessibleAlbumIDs($loggedUser, $pageOwner, $link); 

for($i=0; $i<count($userAlbums); $i++) {
    $albumName = getAlbumNameFromID($userAlbums[$i], $link);
?>
    <button type="submit" value="<?php echo $userAlbums[$i]; ?>"name = "albumID"><?php echo $albumName; ?></button>
<?php
}
?>
</form>

<?

?>

<br>
<!-- displays user's albums depending on selection made -->
<?php
if(strcmp($albumID, "allPhotos") == 0) {
    displayAllAccessiblePhotos($loggedUser, $pageOwner, $link);
} else {
    displayAlbumPhotos($albumID, $link);
}
?>

<?php
mysqli_close($link);
?>

</body>
</html>