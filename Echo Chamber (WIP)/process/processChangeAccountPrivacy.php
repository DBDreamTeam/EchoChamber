<?php 
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>

<?php
header('Location: ../public/manageAccount.php');
?>

<?php
$userID = $_SESSION["LoggedUserID"];
$newPrivacy=$_POST["privacy"];
?>

<?php
$blogID = getBlogID($userID, 0, $link);
updateBlogPrivacy($blogID, $newPrivacy, $link);
?>
