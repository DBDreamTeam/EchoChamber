<?php include 'connect.php'?>

<?php session_start(); ?>

<?php
header('Location: chat.php');
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
// Inserts message into message table
function insertMessage($ChatID, $UserID, $MsgContent, $MsgPic, $conn) {
    $messageInsert = "INSERT INTO message (ChatID, UserID, Text, Photo) VALUE ({$ChatID}, {$UserID}, '{$MsgContent}', '{$MsgPic}')";

    if ($conn -> query($messageInsert) === TRUE) {
        echo "Message inserted into messages successfully";
    } else {
        echo "Error: ". $messageInsert . "<br>" . $conn->error;
    }
}
?>

<?php

insertMessage($chatID, $userID, $msgContent, $msgPic, $link);

?>

