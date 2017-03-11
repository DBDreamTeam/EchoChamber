<?php
session_start();

// Set session variables
$_SESSION["loggedUser"] = $_GET["name"];
$_SESSION["friend2"] = $_GET["FriendName"];
$_SESSION["groupName"] = $_GET["GroupName"];
$_SESSION["isGroup"] = $_GET["isGroup"];

$isGroup= $_SESSION["isGroup"];

if ($isGroup == '0') {
  echo '<script type="text/javascript">window.location = "http://localhost:8080/profile.php";</script>';
} else {
  echo '<script type="text/javascript">window.location = "http://localhost:8080/groupBlog.php";</script>';
}

?>
