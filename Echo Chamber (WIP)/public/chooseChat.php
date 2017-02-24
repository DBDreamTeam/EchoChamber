<?php include 'connect.php'?>
<?php
// to get this from session variable
$userID = 105;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Choose Chat</title>
</head>

<body>

<h1> Welcome to Chat! </h1>
<h2> Who would you like to chat to? </h2>

<h3> Chat to friends....</h3>

<!-- List of available friends -->
<form action = "processChooseChat.php" method = "post">

<?php 
// Lists all user's friends
$selectFriends = "SELECT UserID, UserName FROM users";     // need to change so only friends are displayed

$friendsResult = mysqli_query($link, $selectFriends);

if (mysqli_num_rows($friendsResult) > 0) {
    while ($row = mysqli_fetch_assoc($friendsResult)) {
        echo "<input type=\"checkbox\" name=\"friend[]\" value=\" " . $row["UserID"] . "\">" . $row["UserName"] . "<br>";
    }
}
?>

<h3> Or to one of your circles! </h3>
<!--List of available groups -->

<?php
// Lists all user's groups

// TO DO WHEN HAVE CHECKED GROUPS TABLES ARE OK
?>



<h2> Choose a name for your chat! </h2>
<input type = "text" name = "chatName" placeholder = "Chat Name"><br>

<input type = "submit" value = "Chat Now!">

</form>

</body>
</html>