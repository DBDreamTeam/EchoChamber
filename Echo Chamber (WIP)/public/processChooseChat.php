<?php include 'connect.php'?>
<?php session_start(); ?>

<?php
header('Location: chat.php');
?>

<?php 
// Get variables
$chatName = $_POST["chatName"];
echo $chatName;
$chatID = null;
$chatFriends = $_POST["friend"];
?>

<?
// Insert chat into chat table
$insertChat = "INSERT INTO chat (ChatTitle) VALUES ('{$chatName}')";

if ($link -> query($insertChat) === TRUE) {
    echo "New chat inserted into chat successfully";
    $chatID = mysqli_insert_id($link);
    echo "New chat id: " . $chatID;
} else {
    echo "Error: ". $insertChat . "<br>" . $link->error;
}

$_SESSION["chatID"] = $chatID;
echo "Session variable chatID set";
print_r($_SESSION);
?>

<?
// Insert chat members into chat_members table
for($i = 0; $i< count($chatFriends); $i++) {
    $insertChatMembers = "INSERT INTO chat_members (ChatID, UserID) VALUES ({$chatID}, {$chatFriends[$i]})";

    if ($link -> query($insertChatMembers) === TRUE) {
        echo "Chat members inserted into chat_members successfully";
    } else {
        echo "Error: ". $insertChatMembers . "<br>" . $link->error;
    }
}
?>