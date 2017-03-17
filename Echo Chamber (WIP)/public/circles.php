<?php 
include '../includes/phptop.php';
include '../includes/functions.php';
?>

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
<title>Circles</title>
</head>

<body>




<h1>Circles!</h1>

<?php include '../includes/navigation.php';?>

<h2>Create a New Circle!</h2>

<!-- Form for creating new circle -->
<form action = "../process/processCircleCreate.php" method = "post" enctype="multipart/form-data">

<p>Select Members for your Circle...</p>

    <?php getFriends($userID, $link); // Lists all user's friends ?>
    <input type="hidden" name="circleMember[]" value ="<?php echo $userID;?>">

<p> Give your circle a name...</p>
    <input type = "text" name="circleName" placeholder = "Name your circle">

<p> Who has access to your circle?</p>
    
    <select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
    </select><br>
    
<p> Upload a nice pic for your circle to marvel at :) </p>
    
    <input type="file" name = "uploadedimage"><br><br>
    
    <input type = "submit" value = "Create circle!">
</form>


<h2>Your Circles!</h2>

<?php getCircles($userID, $link); ?>

<p>You might also be interested in...</p>
<!--Lists circles with privacy 'Friends' and 'FriendsOfFriends'-->

<form action="blog.php" method="post">

<?php 
$fOfFCircles = getFOfFCircles($userID, $link); 
for($i=0; $i<count($fOfFCircles); $i++) {
    $circleName = getCircleNamefromID($fOfFCircles[$i], $link);
    echo "<button type=\"submit\" name=\"circleID\" value =\"{$fOfFCircles[$i]}\">{$circleName}</button><br>";
}

$friendsCircles = getFriendsCircles($userID, $link);
for($j=0; $j<count($friendsCircles); $j++) {
    $circleName = getCircleNamefromID($friendsCircles[$j], $link);
    echo "<button type=\"submit\" name=\"circleID\" value =\"{$friendsCircles[$i]}\">{$circleName}</button><br>";
}

?>


</form>

</body>
</html>
