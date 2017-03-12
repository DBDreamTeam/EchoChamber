<?php

session_start();

include '../includes/connect.php';
include '../includes/functions.php';

?>

<?php
$LoggedUserID = $_SESSION["LoggedUserID"];
$user = getUsernameFromID($LoggedUserID, $link);
echo "logged user ID". $LoggedUserID . "<br>";
$FriendUserID = $_SESSION["FriendUserID"];
echo "page owner ID " . $FriendUserID;
$CheckFriend = getUsernameFromID($FriendUserID, $link);

/*echo $LoggedUserID; 
echo $user;
echo $FriendUserID;
echo $CheckFriend;*/
?>
<?php 

?>

<html>
<head>
<title>Landing Temp</title>
</head>
<body>

<h1>This is <?php echo $CheckFriend ?>'s page.</h1>

<?php include '../includes/navigation.php';?>

<h2>Friends</h2>
 
<!-- Friend buttons -->
<form action="../process/processSeeFriend.php" method="post">
<?php
$friendsIDArray = getFriendIDs($FriendUserID, $link);

for($i=0; $i<count($friendsIDArray); $i++) {
    $friendName = getUsernameFromID($friendsIDArray[$i], $link);  
?>

<button type="submit" name="friendID" value="<?php echo $friendsIDArray[$i]; ?>"><?php echo $friendName; ?> </button>

<? } ?>
</form>

<h2>Friends of Friends</h2>
<form action="../process/processSeeFriend.php" method="post">
<?php
$fOfFIDArray = getFriendsOfFriends($FriendUserID, $link);

for($i=0; $i<count($fOfFIDArray); $i++) {
    $friendName = getUsernameFromID($fOfFIDArray[$i], $link);  
?>

<button type="submit" name="friendID" value="<?php echo $fOfFIDArray[$i]; ?>"><?php echo $friendName; ?> </button>

<? } ?>
</form>

<h2>All Users</h2>
<form action="../process/processSeeFriend.php" method="post">
<?php
$userArray = getAllUsers($link);

for($i=0; $i<count($userArray); $i++) {
    $username = getUsernameFromID($userArray[$i], $link);  
?>

<button type="submit" name="friendID" value="<?php echo $userArray[$i]; ?>"><?php echo $username; ?> </button>

<? } ?>
</form>

<h2>Manage</h2>
<?php
if(isPageOwner($LoggedUserID, $FriendUserID, $link)) {
    echo 
    "<a href=\"managePhotos.php\">Manage Photos</a><br>
    <a href=\"manageCircles.php\">Manage Circles</a>";
}
?>

</body>
</html>