<?php 

// THIS IS JUST FOR COMMENTS ON PICTURES

include '../includes/phptop.php';
include '../includes/functions.php';

header('Location: ../public/photos.php');

$userID = $_SESSION["LoggedUserID"];

// need to get this from somewhere
//$postID = 61;
?>


<?php
$postID = $_POST["picID"];
echo $postID;
$commentText = $_POST["comment"];
echo $commentText;

insertComment($userID, $commentText, $postID, $link);
        
?>

