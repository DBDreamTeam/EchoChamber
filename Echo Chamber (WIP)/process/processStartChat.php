<?php 
include '../includes/phptop.php';
include '../includes/functions.php';?>

<?php 
// In practice, to be set at login
//$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["LoggedUserID"];
?>

<?php
header('Location: ../public/chatWindow.php');
?>

<?php 
// Get variables
$chatName = $_POST["chatName"];
$chatFriends = $_POST["friend"];
echo "Chat friends: <br>"; 
print_r($chatFriends);
echo "<br>";
$chatCircles = $_POST["circle"];
echo "Chat circles: <br> ";
print_r($chatCircles);
echo "<br>";

// Initialise variables to be populated
$chatID = null;
?>

<?
// Insert new chat into chat table and get value of chatID 
$chatID = createNewChat($chatName, $link);

$_SESSION["chatID"] = $chatID;
echo "Session variable chatID set <br>";
echo "Session details: <br>";
print_r($_SESSION);
echo "<br>";

$chatCircleMembers = getCircleMemberIDs($chatCircles, $link);

$allChatMembers = combineAllChatMembers($chatFriends, $chatCircleMembers, $userID);

insertChatMembers($chatID, $allChatMembers, $link);

?>