<?php

session_start();

include 'connect.php';

$blogInput = $_POST["blogInput"];

//get the BlogID of current profile
$FriendUserID = $_SESSION["FriendUserID"];
$BlogID = $_SESSION["BlogID"];
$isGroup = $_SESSION["isGroup"];

if ($isGroup == '0') {
  echo "individual";
  echo '<script type="text/javascript">window.location = "http://localhost:8080/profile.php";</script>';
} else {
  echo "group";
  echo '<script type="text/javascript">window.location = "http://localhost:8080/groupBlog.php";</script>';
}

$insertBlog = "INSERT INTO posts (BlogID, text, AlbumID) VALUES ('$BlogID','$blogInput', NULL)";
if ($conn -> query($insertBlog) === TRUE) {
} else {
  echo "Error: ". $insertBlog . "<br>" . $conn->error;
}




?>
