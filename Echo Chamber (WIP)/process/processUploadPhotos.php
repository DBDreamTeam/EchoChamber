<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>

<?php
header('Location: ../public/photos.php');
?>

<?php
$userID = $_SESSION["userID"];
echo $userID;
$albumName = $_POST["albumName"];
echo $albumName;

// get album ID
$albumID = getAlbumIDFromName($albumName, $userID, $link);
echo $albumID;

// insert image into album
insertImagePlus($albumID, $link);

?>