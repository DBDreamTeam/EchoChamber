<?php 
include '../includes/phptop.php';
include '../includes/newFunctions.php';
?>

<?php
header('Location: ../public/managePhotos.php');
?>


<?php
$albumID = $_POST["albumID"];
$newPrivacy = $_POST["privacy"];

updateAlbumPrivacy($albumID, $newPrivacy, $link);
?>