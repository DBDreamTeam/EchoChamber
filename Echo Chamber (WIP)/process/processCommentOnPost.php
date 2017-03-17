<?php

session_start();

header("Location: ../public/profile.php");

include("../includes/connect.php");
include("../includes/functions.php");

$commentText = $_POST["comment-text"];
$userID = $_SESSION["LoggedUserID"];
$postID = $_POST["postID"];
//$isPhoto = 0;

insertComment($userID, $commentText, $postID, $link);

?>
