<?php 
include '../includes/phptop.php';
include '../includes/functions.php';

?>

<?php
header('Location: ../public/photos.php');
?>

<?php 
// In practice, to be set at login
//$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["LoggedUserID"];
?>

<?php
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

