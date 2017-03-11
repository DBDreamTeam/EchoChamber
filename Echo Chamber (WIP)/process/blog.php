<?php

session_start();

include '../includes/connect.php';

$blogInput = $_POST["blogInput"];
echo $blogInput;
//get the BlogID of current profile
$FriendUserID = $_SESSION["FriendUserID"];
$BlogID = $_SESSION["BlogID"];
$isGroup = $_SESSION["isGroup"];

if ($isGroup == '0') {
  echo "individual";
  echo '<script type="text/javascript">window.location = "http://localhost:8888/ECHOCHAMBER/public/profile.php";</script>';
} else {
  echo "group";
  echo '<script type="text/javascript">window.location = "http://localhost:8888/groupBlog.php";</script>';
}

$insertBlog = "INSERT INTO posts (BlogID, text, AlbumID) VALUES ('$BlogID','$blogInput', NULL)";
if ($link -> query($insertBlog) === TRUE) {
} else {
  echo "Error: ". $insertBlog . "<br>" . $link->error;
}




?>
