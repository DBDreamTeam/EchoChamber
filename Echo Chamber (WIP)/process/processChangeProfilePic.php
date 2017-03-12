<?php
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>

<?php
//header('Location: ../public/manageAccount.php');
?>

<?php
$userID = $_SESSION["LoggedUserID"];
?>


<?php
$picID = 0;

$doesAlbumExist = doesAlbumNameExist("Profile Pictures", $userID, $link);

if($doesAlbumExist == 1) {
    // if a "Profile Pictures" album does exist, add the new profile picture to it
    $albumID = getAlbumIDFromName('Profile Pictures', $userID, $link);
    $picID = insertImageNew($albumID, "uploadedimage", $link);
    echo "Album exists <br>";
} else{
    // if the album does not already exist (this should not be the case, unless the user did not uplaod a profile picture on registration), create it
    $albumID = insertAlbum('Profile Pictures', $userID, 'Friends', $link);
    $picID = insertImageNew($albumID, "uploadedImage", $link);
}
    
// update the profile picture ID in the user table    
updateUsrPicID($userID, $picID, $link);

$link->close();
?>
    