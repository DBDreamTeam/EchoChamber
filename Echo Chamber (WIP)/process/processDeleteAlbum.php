<?php 
include '../includes/phptop.php';
include '../includes/functions.php';
?>
<?php
header('Location: ../public/managePhotos.php');
?>

<?
$albumID = $_POST["albumID"];

deleteAlbum($albumID, $link);
?>