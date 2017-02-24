<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/photoFunctions.php';?>

<?php
header('Location: ../public/photos.php');
?>

<?php
// to get from session
$userID = 105;
?>

<?php
// Insert album into table albums
$ownerID = $userID;
$albumName = $_POST["albumName"];
$albumPrivacy = $_POST["privacy"];

$insertAlbum = "INSERT INTO albums (AlbumName, OwnerID, Privacy) VALUES ('{$albumName}', {$ownerID}, '{$albumPrivacy}')"; 

if ($link -> query($insertAlbum) === TRUE) {
    echo "Inserted into albums successfully";
} else {
    echo "Error: ". $insertAlbum . "<br>" . $link->error;
}


?>