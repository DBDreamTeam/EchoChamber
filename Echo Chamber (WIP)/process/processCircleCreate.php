<?php 
include '../includes/phptop.php';
include '../includes/functions.php';

header('Location: ../public/manageCircles.php');
?>

<?php
$userID = $_SESSION["LoggedUserID"];

$blogID = 1;    // TO CHANGE TO CALCULATE

$circleName = $_POST["circleName"];
//echo "Circle name: " . $circleName;
$circlePrivacy = $_POST["privacy"];
//echo "Circle privacy: " . $circlePrivacy;
$circleMembers = $_POST["circleMember"];
//echo "Circle Members: " . $circleMembers[0];
//print_r($circleMembers);
?>

<?php

$albumID = 0;
$doesAlbumExist = doesAlbumNameExist("Circle Photos", $userID, $link);

if($doesAlbumExist == 1) {
    // if album "Circle Photos" already exists, insert photo into existing album
    $albumID = getAlbumIDFromName("Circle Photos", $userID, $link);
    //echo "album does exist";
} else{
    // if album "Circle Photos does not already exist, create new album
    $albumID = insertAlbum("Circle Photos", $userID, "Circles", $link);
    //echo "album does not exist";
}

// inserts the image into the imageID table
$imageID = insertImageNew($albumID, "uploadedimage", $link);

// Inserts all group information into the groups table
$groupID = insertGroup($circleName, $imageID, $circlePrivacy, $link);




//echo "<br> Group ID: ". $groupID;
insertGroupMembers($groupID, $circleMembers, $link);

?>

