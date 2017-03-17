<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';

header('Location: ../public/chatWindow.php');
?>

<?php
$userID = $_SESSION["LoggedUserID"];
$chatID = $_SESSION["chatID"];
?>

<?php
// Get from session variable
//$userID = 105;
?>

<?php
// Values from superglobals
$msgContent = $_POST["message"];
$picID = null;
?>

<?php

$albumID = null;
if(!empty($_FILES["uploadedimage"]["name"])){

    echo "Thinks image has been uploaded <br>";

    $doesAlbumExist = doesAlbumNameExist("Chat Photos", $userID, $link);
    echo $doesAlbumExist;
    
    if($doesAlbumExist == false) {
        // if album called "Chat Photos" does not already exist, create new album
        $albumID = insertAlbum("Chat Photos", $userID, "Friends", $link);
    } else {
        // if album does already exists, get its ID
        $albumID = getAlbumIDFromName("Chat Photos", $userID, $link);
    }
    $picID = insertImageNew($albumID, "uploadedimage", $link);
} else {
    $picID = null;
}

insertMessage($chatID, $userID, $msgContent, $picID, $link);

?>

