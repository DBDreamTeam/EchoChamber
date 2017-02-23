<?php include 'connect.php'?>

<?php //include 'processChooseChat.php'?>
<?php session_start(); ?>

<?php
mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");
?>

<?php
$_SESSION["userID"] = 104;  // to set at login
$_SESSION["chatID"] = 7;  // to set on select chat page
?>

<?php 
// assigning from session
$userID = $_SESSION["userID"];
$chatID = $_SESSION["chatID"];
?>

<?php
// Displays all members of the chat with specified id 
function displayChatMembers($IDforChat, $conn) {

    $selectChatMembers = "SELECT users.UserName, chat_members.ChatID FROM users, chat_members WHERE chat_members.ChatID = {$IDforChat} AND users.UserID = chat_members.UserID";
    
    $chatMembersResult = mysqli_query($conn, $selectChatMembers);
    
    if(mysqli_num_rows($chatMembersResult) > 0) {
        while($row = mysqli_fetch_assoc($chatMembersResult)) {
            echo $row["UserName"] . ", ";
            
        }
    }
}
?>

<?php
// Gets the chat title corresponding to the given chat ID
function getChatTitleFromID($ChatID, $conn) {
    $selectChatName = "SELECT ChatTitle FROM chat WHERE ChatID = {$ChatID}";
    
    $chatNameResult = mysqli_query($conn, $selectChatName);
    
    if(mysqli_num_rows($chatNameResult) > 0) {
        while($row = mysqli_fetch_assoc($chatNameResult)) {
            $chatTitle = $row["ChatTitle"]; 
        }
    }
    return $chatTitle;
}
?>

<?php
// Gets the username corresponding to the user ID given
function getUsernameFromID($idUser, $conn) {
    $username = null;
    
    $selectUsername = "SELECT Username FROM users WHERE UserID = {$idUser}";
    
    $usernameResult = mysqli_query($conn, $selectUsername);
    
    if(mysqli_num_rows($usernameResult) > 0) {
        while($row = mysqli_fetch_assoc($usernameResult)) {
            $username = $row["Username"];
        }
    }
    return $username;
}
?>

<?php
// Retrieves messsages for chat id specified 
function retrieveMessages($idChat, $conn) {
    $msgArray = array();
    $i = 0;

    $selectMsgs = "SELECT UserID, Text, Photo, DateTime FROM message WHERE ChatID = {$idChat}";
    
    $msgsResult = mysqli_query($conn, $selectMsgs);
    
    if(mysqli_num_rows($msgsResult) > 0) {
        while($row = mysqli_fetch_assoc($msgsResult)) {
            echo getUsernameFromID($row["UserID"], $conn) . "<br>";
            echo $row["DateTime"] . "<br>";
            echo $row["Text"]. "<br>";
            echo "<br>";
        }
    }
    //print_r($msgArray);
    return $msgArray;
}
?>
    
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chat</title>
</head>

<body>

<h1>Chat!</h1>

<h2>This is the <?php echo getChatTitleFromID($chatID, $link); ?> chat! </h2>

<h3> You are chatting to: <?php displayChatMembers($chatID, $link); ?> </h3>

<h2> The Chat! </h2>

<?php
// Displays existing messages from the chat
$msgArray = retrieveMessages($chatID, $link);
?>


<h2> Write a message to your friends! </h2>

<form action = "processChatMessage.php" method = "post" id="msgForm">
    <textarea name="message" form="msgForm" placeholder = "Craft your words here!"></textarea><br>
    <input type = "submit" value = "Send!">
</form>


</body>
</html>