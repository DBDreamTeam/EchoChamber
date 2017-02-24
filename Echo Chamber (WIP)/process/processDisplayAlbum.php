<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>

<?php
header('Location: ../public/photos.php');
?>

<?php 
// In practice, to be set at login
$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["userID"];
?>

<?php
$albumID = $_POST["albumID"];
echo $albumID;
//echo $albumName . "<br>";
?>

<?
// Get album name from album ID
function getAlbumName($albumID, $conn) {
    $albumName = null;
    $selectAlbumName = "SELECT AlbumName FROM albums WHERE albumID = '{$albumID}'";
    
    $albumNameResult = mysqli_query($conn, $selectAlbumName);
    
    if(mysqli_num_rows($albumNameResult) >0) {
        $row = mysqli_fetch_assoc($albumNameResult);
        $albumName = $row["AlbumName"];
    }
    return $albumName;
}
?>

<?php
/*
if($albumID != 'allAlbum') 
$albumName = getAlbumName($albumID, $link);
echo $albumName;*/

$_SESSION["albumID"] = $albumID;
//$_SESSION["albumName"] = $albumName;
?>