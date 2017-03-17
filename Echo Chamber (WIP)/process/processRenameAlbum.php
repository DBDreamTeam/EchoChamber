<?php
include '../includes/phptop.php';
include '../includes/functions.php';

header('Location: ../public/managePhotos.php');
?>

<?php
$albumID = $_POST["albumID"];
$newAlbumName = $_POST["newAlbumName"];

updateAlbumName($albumID, $newAlbumName, $link);
?>