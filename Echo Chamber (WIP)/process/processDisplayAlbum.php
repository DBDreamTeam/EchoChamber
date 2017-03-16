<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();

header('Location: ../public/photos.php');

$albumID = $_POST["albumID"];
echo $albumID;

/*
if($albumID != 'allAlbum') 
$albumName = getAlbumName($albumID, $link);
echo $albumName;*/

$_SESSION["albumID"] = $albumID;
echo $_SESSION["albumID"];
//$_SESSION["albumName"] = $albumName;
?>