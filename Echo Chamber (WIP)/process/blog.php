<?php

session_start();

include '../includes/connect.php';
include '../includes/functions.php';

$blogInput = $_POST["blogInput"];
echo $blogInput;
//get the BlogID of current profile
$FriendUserID = $_SESSION["FriendUserID"];
$LoggedUserID = $_SESSION["LoggedUserID"];
$BlogID = $_SESSION["BlogID"];
$isGroup = $_SESSION["isGroup"];

$picID = null;

// if an image has been uploaded
if(!empty($_FILES["uploadedimage"]["name"])){
    // checks if album of name "Blog Pictures" already exists"
    $doesAlbumExist = doesAlbumNameExist("Blog Pictures", $LoggedUserID, $link);
    
    if($doesAlbumExist == 1) {
    // if a "Blog Pictures" album does exist, get the albumID and add the new blog picture to it
    $albumID = getAlbumIDFromName('Blog Pictures', $LoggedUserID, $link);
    $picID = insertImageNew($albumID, "uploadedimage", $link);
    echo "Album exist <br>";
    } else {
    // if the album does not already exist, create it and add the picture to it
    $albumID = insertAlbum('Blog Pictures', $LoggedUserID, 'Friends', $link);
    $picID = insertImageNew($albumID, "uploadedImage", $link);
    }
}
 

if ($isGroup == '0') {
  echo "individual";
  echo '<script type="text/javascript">window.location = "http://localhost:8888/ECHOCHAMBER/public/profile.php";</script>';
} else {
  echo "group";
  echo '<script type="text/javascript">window.location = "http://localhost:8888/groupBlog.php";</script>';
}

$insertBlog = "INSERT INTO posts (BlogID, text, PictureID) VALUES ('$BlogID','$blogInput', $picID)";
if ($link -> query($insertBlog) === TRUE) {
} else {
  echo "Error: ". $insertBlog . "<br>" . $link->error;
}




?>
