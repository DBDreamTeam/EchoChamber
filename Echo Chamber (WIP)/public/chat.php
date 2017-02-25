<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>

<?php 
// In practice, to be set at login
$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["userID"];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chat</title>
</head>

<body>

<h1> Welcome to Chat! </h1>

<h2> Or continue with an existing one </h2>

<?php getUserChatIDs($userID, $link); ?>
<!-- List of user's existing chats -->
<form action = "../process/processContinueChat.php" method = "post">

<?php 
$userChats = getUserChatIDs($userID, $link);

for($i=0; $i<count($userChats); $i++) {
    $chatName = getChatNameFromID($userChats[$i], $link);
?>

<input type="checkbox" name="chat" value="<?php echo $userChats[$i]; ?>"><?php echo $chatName;?> <br>

<?php
}
?>

<input type="submit" value = "Continue Chat">
</form>

<h2> Start a New Chat! </h2>
<h3> Who would you like to chat to? </h3>

<h2> Chat to friends....</h2>

<!-- List of user's friend -->
<form action = "../process/processStartChat.php" method = "post">

<?php 
$userFriends = getFriendIDs($userID, $link); 

for($i=0; $i<count($userFriends); $i++) {
    $userName = getUsernameFromID($userFriends[$i], $link);
?>
    <input type="checkbox" name="friend[]" value="<?php echo $userFriends[$i]; ?>"><?php echo $userName; ?><br>
<?php
}
?>

<h2> Or to one of your circles! </h2>
<!--List all circle's the user belongs to: -->

<?php
$userCircles = getUserCircleIDs($userID, $link);

for($i=0; $i<count($userCircles); $i++) {
    $circleName = getCircleNameFromID($userCircles[$i], $link);
?>

    <input type = "checkbox" name="circle[]" value="<?php echo $userCircles[$i]; ?>"><?php echo $circleName; ?><br>

<?php
}
?>


<h3> Choose a name for your chat! </h3>
<input type = "text" name = "chatName" placeholder = "Chat Name"><br>

<input type = "submit" value = "Start New Chat!">

</form>

</body>
</html>