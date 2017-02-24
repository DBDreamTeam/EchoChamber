<?php include '../includes/phptop.php'?>
<?php include '../includes/functions.php'?>

<?php
header('Location: ../public/circles.php');
?>

<?php
$userID = $_SESSION["userID"];

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
// Creates album "Circle Photos" - NEED TO ALTER THIS TO DEAL WITH SITUATION WHERE ALBUM ALREADY EXISTS 
$albumID = insertAlbum("Circle Photos", $userID, "Circles", $link);

// Inserts the image into the pictures table, with albumID of the circles album specified above
$tempName = getTempName();
$targetPath = getTargetPath();
$imageID = null;

if(move_uploaded_file($tempName, $targetPath)) {
    $imageID = insertImage($targetPath, $albumID, $link);
} else{
   exit("Error While uploading image on the server");
}

// Inserts all group information into the groups table
$groupID = insertGroup($blogID, $circleName, $imageID, $circlePrivacy, $link);

//echo "<br> Group ID: ". $groupID;
insertGroupMembers($groupID, $circleMembers, $link);

?>

