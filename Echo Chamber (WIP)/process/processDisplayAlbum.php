<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>


<?php
header('Location: ../public/photos.php');
?>

<?php 
// In practice, to be set at login
//$_SESSION["userID"] = 105;
?>

<?php
//$userID = $_SESSION["userID"];
?>

<?php
$albumID = $_POST["albumID"];
echo $albumID;
//echo $albumName . "<br>";
?>



<?php
/*
if($albumID != 'allAlbum') 
$albumName = getAlbumName($albumID, $link);
echo $albumName;*/

$_SESSION["albumID"] = $albumID;
echo $_SESSION["albumID"];
//$_SESSION["albumName"] = $albumName;
?>