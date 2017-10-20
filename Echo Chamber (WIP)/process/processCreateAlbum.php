<?php 
include '../includes/phptop.php';
include '../includes/functions.php';?>
<?php
header('Location: ../public/managePhotos.php');
?>

<?php
// to get from session
$userID = $_SESSION["LoggedUserID"];
?>

<?php
// Insert album into table albums
$ownerID = $userID;
$albumName = $_POST["albumName"];
$albumPrivacy = $_POST["privacy"];

insertAlbum($albumName, $ownerID, $albumPrivacy, $link);

?>