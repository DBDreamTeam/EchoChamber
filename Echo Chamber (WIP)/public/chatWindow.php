<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/chatFunctions.php';?>

<?php
//$_SESSION["userID"] = 104;  // to set at login
//$_SESSION["chatID"] = 7;  // to set on select chat page
?>

<?php 
// assigning from session
$userID = $_SESSION["userID"];
$chatID = $_SESSION["chatID"];
?>
    
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>You are Chatting</title>
</head>

<body>

<h1>You are Chatting!</h1>

<h2>This is the <?php echo getChatNameFromID($chatID, $link); ?> chat! </h2>

<h3> You are chatting to: <?php displayChatMembers($chatID, $userID, $link); ?> </h3>

<?php
// Displays existing messages from the chat
$msgArray = retrieveMessages($chatID, $link);
?>

<h2> Write a message to your friends! </h2>

<form action = "../process/processChatMessage.php" method = "post" id="msgForm">
    <textarea name="message" form="msgForm" placeholder = "Craft your words here!"></textarea><br>
    <input type = "submit" value = "Send!">
</form>


</body>
</html>