<?php

include 'connect.php';

$requestFrom = $_GET["user_from"];
$currentUser = $_GET["user_to"];

$reject = $_GET["reject"];
$accept = $_GET["accept"];

//perform if accept button is pressed
if($accept == 'yes') {
	$acceptFriendQuery = "INSERT INTO friendships (Username, friends_array) VALUES ('$requestFrom', '$currentUser')";
	if ($conn -> query($acceptFriendQuery) === TRUE) {
	} else {
		echo "Error: ". $acceptFriendQuery . "<br>" . $conn->error;
	}	
				
	$acceptFriendQuery2 = "INSERT INTO friendships (Username, friends_array) VALUES ('$currentUser', '$requestFrom')";

	if ($conn -> query($acceptFriendQuery2) === TRUE) {
		echo "You are friends now!";
	} else {
		echo "Error: ". $acceptFriendQuery2 . "<br>" . $conn->error;
	}	
	
	$removeFriendRequest = "DELETE FROM friend_request WHERE user_from = '$requestFrom' AND user_to = '$currentUser'";
				
	if ($conn -> query($removeFriendRequest) === TRUE) {
 	} else {
		echo "Error: ". $removeFriendRequest . "<br>" . $conn->error;
    }
				
}
			
//perform if reject button is pressed
if($reject == 'yes') {
	$removeFriendQuery = "DELETE FROM friend_request WHERE user_from = '$requestFrom'";
				
	if ($conn -> query($removeFriendQuery) === TRUE) {
		echo "Rejected";
 	} else {
		echo "Error: ". $removeFriendQuery . "<br>" . $conn->error;
    }
}

?>