<?php 
include '../includes/phptop.php';
include '../includes/functions.php';
?>


<?php
//$_SESSION["userID"] = 104;  // to set at login
//$_SESSION["chatID"] = 7;  // to set on select chat page
?>

<?php 
// assigning from session
$userID = $_SESSION["LoggedUserID"];
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

<?php include '../includes/navigation.php'?>

<h2>This is the <?php echo getChatNameFromID($chatID, $link); ?> chat! </h2>

<h3> You are chatting to: <?php displayChatMembers($chatID, $userID, $link); ?> </h3>

<?php
// Displays existing messages from the chat
$msgArray = retrieveMessages($chatID, $link);
?>

<h2> Write a message to your friends! </h2>

<form action = "../process/processChatMessage.php" method = "post" id="msgForm" enctype="multipart/form-data">
    <textarea name="message" form="msgForm" placeholder = "Craft your words here!"></textarea><br>
    Include a photo: <input type="file" name = "uploadedimage" id="fileToUpload"><br>
    <input type = "submit" value = "Send Message" name="submit">
</form>


</body>
</html>