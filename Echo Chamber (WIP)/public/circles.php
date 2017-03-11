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
<title>Circles</title>
</head>

<body>

<?php
// Gets friends of friends of user of specified ID and returns an array of user IDs of these friends of friends
function getFriendsOfFriends($userID, $conn) {
    $friendsOfFriends = array();
    $j= 0;
    
    $friends = getFriendsArr($userID, $conn);

    for($i=0; $i<count($friends); $i++) {
        $selectFOfF = "SELECT UserTwo FROM friendships WHERE UserOne = {$friends[$i]}";
        
        $fOfFResult = mysqli_query($conn, $selectFOfF);
        
        if(mysqli_num_rows($fOfFResult) > 0) {
            while($row=mysqli_fetch_assoc($fOfFResult)) {
                $friendsOfFriends[$j] = $row["UserTwo"];
                $j++;
            }
        }
    }
    //echo "Friends of friends: <br>";
    //print_r($friendsOfFriends);
    //echo "<br>";
    return $friendsOfFriends;
}

// Gets all friends of user of specified ID and returns an array of the user IDs of these friends
function getFriendsArr($userID, $conn) {
    $friendsArray = array();
    $i = 0;

    $selectFriends = "SELECT friendships.UserTwo, users.Username FROM friendships, users WHERE friendships.UserOne = {$userID} AND users.UserID = friendships.UserTwo";
    
    $friendsResult = mysqli_query($conn, $selectFriends);
    
    if(mysqli_num_rows($friendsResult) > 0) {
        while ($row = mysqli_fetch_assoc($friendsResult)) {
            $friendsArray[$i] = $row["UserTwo"];
            $i++;
        }
    }
    return $friendsArray;
}

function getFOfFCircles($userID, $conn) {
    $fOfFCirclesArr = array();
    $i = 0;
    
    // gets array of friends of friends of the user
    $friendsOfFriends = getFriendsOfFriends($userID, $conn);
    
    for($j=0; $j<count($friendsOfFriends); $j++) {
        // gets IDs of circles of each friend of friends
        $fOfFCircles = getUserCircleIDs($friendsOfFriends[$j], $conn);
        //echo "Friends of friends circles: <br>";
        //print_r($fOfFCircles);
        //echo "<br>";
        
        for($k=0; $k<count($fOfFCircles); $k++) {
        
            $getFFCircles = "SELECT GroupID FROM groups WHERE Privacy = 'FriendsOfFriends' AND GroupID = {$fOfFCircles[$k]}";
        
            $getFFCirclesResult = mysqli_query($conn, $getFFCircles);
        
            if(mysqli_num_rows($getFFCirclesResult) >0) {
                while ($row = mysqli_fetch_assoc($getFFCirclesResult)) {
                    if(!(in_array($row["GroupID"], $fOfFCirclesArr))){
                        $fOfFCirclesArr[$i] = $row["GroupID"];
                        $i++;
                    }
                }
            }
        }
    }
   // echo "Friends of friends circles <br>";
   // print_r($fOfFCirclesArr);
   // echo "<br>";
    return $fOfFCirclesArr;
}

function getFriendsCircles($userID, $conn) {
    $friendsCirclesArray = array();
    $i = 0;
    
    $friends = getFriendsArr($userID, $conn);
    //echo "User's friends: <br>";
    //print_r($friends);
    //echo "<br>";
    
    for($j=0; $j<count($friends); $j++) {
    
        $friendCircles = getUserCircleIDs($friends[$j], $conn);
        //echo "friend's circles {$j} <br>";
        //print_r($friendCircles);
        //echo "<br>";
        
        for($k=0; $k<count($friendCircles); $k++) {
        
            $getFriendCircles = "SELECT GroupID FROM groups WHERE Privacy = 'Friends' AND GroupID = {$friendCircles[$k]}";
            
            $result = mysqli_query($conn, $getFriendCircles);
            
            if(mysqli_num_rows($result) >0) {
                while($row = mysqli_fetch_assoc($result)) {
                    if(!(in_array($row["GroupID"], $friendsCirclesArray))){
                        $friendsCirclesArray[$i] = $row["GroupID"];
                        $i++;
                    }
                }
            }
        }
    }
    //echo "Arrays with privacy friends <br>";
    //print_r($friendsCirclesArray);
    //echo "<br>";
    return $friendsCirclesArray;  
}

function getAllAccCircles($userID, $conn) {
    $allCircles = array();
    $i = 0;
    
    $friendsOfFriendsC = getFOfFCircles($userID, $conn);
    $friendsC = getFriendsCircles($userID, $conn);
    
    for($j=0; $j<count($friendsOfFriendsC); $j++) {
        $allCircles[$i] = $friendsOfFriendsC[$j];
        $i++;
    }
    
    for($k=0; $k<count($friendsC); $k++) {
        if(!(in_array($friendsC[$k], $allCircles))) {
            $allCircles[$i] = $friendsC[$k];
            $i++;
        }
    }
    //echo "All circles <br>";
    //print_r($allCircles);
   // echo "<br>";
    return $allCircles;
}
    

?>


<h1>Circles!</h1>

<?php include '../includes/navigation.php';?>

<h2>Create a New Circle!</h2>

<!-- Form for creating new circle -->
<form action = "../process/processCircleCreate.php" method = "post" enctype="multipart/form-data">

<h3>Select Members for your Circle...</h3>

    <?php getFriends($userID, $link); // Lists all user's friends ?>
    <input type="hidden" name="circleMember[]" value ="<?php echo $userID;?>">

<h3> Give your circle a name...</h3>
    <input type = "text" name="circleName" placeholder = "Name your circle">

<h3> Who has access to your circle?</h3>
    
    <select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
    </select><br>
    
<h3> Upload a nice pic for your circle to marvel at :) </h3>
    
    <input type="file" name = "uploadedimage"><br><br>
    
    <input type = "submit" value = "Create circle!">
</form>


<h2>Your Circles!</h2>

<?php getCircles($userID, $link); ?>

<h2>You might also be interested in...</h2>
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