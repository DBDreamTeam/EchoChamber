<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/chatFunctions.php';?>

<?php
$_SESSION["userID"] = 104;  // to set at login
$_SESSION["chatID"] = 7;  // to set on select chat page
?>

<?php 
// assigning from session
$userID = $_SESSION["userID"];
$chatID = $_SESSION["chatID"];
?>

<? // LOCAL FUNCTIONS, RELEVANT TO THIS PAGE ONLY
// Displays all members of the chat with specified id 
function displayChatMembers($IDforChat, $userID, $conn) {

    $selectChatMembers = "SELECT users.UserName, users.UserID, chat_members.ChatID FROM users, chat_members WHERE chat_members.ChatID = {$IDforChat} AND users.UserID = chat_members.UserID";
    
    $chatMembersResult = mysqli_query($conn, $selectChatMembers);
    
    if(mysqli_num_rows($chatMembersResult) > 0) {
        while($row = mysqli_fetch_assoc($chatMembersResult)) {
            if($row["UserID"] != $userID) {
                echo $row["UserName"] . ", ";
            }
        }
    }
}

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
            
            if($row["Photo"] != null) {
                echo "<img src = \"../process/" . getImagePathFromID($row["Photo"], $conn) . "\" width=\"200\" height=\"200\"> <br>";
            }
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

<form action = "../process/processChatMessage.php" method = "post" id="msgForm" enctype="multipart/form-data">
    <textarea name="message" form="msgForm" placeholder = "Craft your words here!"></textarea><br>
    Include a photo: <input type="file" name = "uploadedimage" id="fileToUpload"><br>
    <input type = "submit" value = "Send!" name="submit">
</form>


</body>
</html>