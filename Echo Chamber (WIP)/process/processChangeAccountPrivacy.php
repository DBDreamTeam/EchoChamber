<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();

header('Location: ../public/manageAccount.php');

$userID = $_SESSION["LoggedUserID"];
$newPrivacy=$_POST["privacy"];

$blogID = getBlogID($userID, 0, $link);
updateBlogPrivacy($blogID, $newPrivacy, $link);
?>
