<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>

<?php
header('Location: ../public/chatWindow.php');
?>

<?php
$userID = $_SESSION["userID"];
$chatID = $_SESSION["chatID"];
?>

<?php
// Get from session variable
//$userID = 105;
?>

<?php
// Values from superglobals
//$chatID = $_POST["chatID"];
//echo $chatID;
$msgContent = $_POST["message"];
echo $msgContent;
$msgPic = null;
?>

<?php

insertMessage($chatID, $userID, $msgContent, $msgPic, $link);

?>

