<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php
header('Location: ../public/managePhotos.php');
?>

<?php
$loggedUserID = $_SESSION["LoggedUserID"];
echo $loggedUserID;
$albumName = $_POST["albumName"];
echo $albumName;

// get album ID
$albumID = getAlbumIDFromName($albumName, $loggedUserID, $link);
echo $albumID;

// insert image into album
insertImageNew($albumID, "uploadedimage", $link);

?>