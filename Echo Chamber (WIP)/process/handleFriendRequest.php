<?php
session_start();
include 'connect.php';

$requestFromID = $_GET["user_from"];
$currentUserID = $_GET['user_to'];
$reject = $_GET["reject"];
$accept = $_GET["accept"];

//perform if accept button is pressed
if($accept == 'yes') {
	$acceptFriendQuery = "INSERT INTO friendships (UserOne, UserTwo) VALUES ('$requestFromID', '$currentUserID')";
	if ($conn -> query($acceptFriendQuery) === TRUE) {
	} else {
		echo "Error: ". $acceptFriendQuery . "<br>" . $conn->error;
	}

	$acceptFriendQuery2 = "INSERT INTO friendships (UserOne, UserTwo) VALUES ('$currentUserID', '$requestFromID')";

	if ($conn -> query($acceptFriendQuery2) === TRUE) {
		echo "You are friends now!";
	} else {
		echo "Error: ". $acceptFriendQuery2 . "<br>" . $conn->error;
	}

	$removeFriendRequest = "DELETE FROM friend_requests WHERE user_from = '$requestFromID' AND user_to = '$currentUserID'";

	if ($conn -> query($removeFriendRequest) === TRUE) {
 	} else {
		echo "Error: ". $removeFriendRequest . "<br>" . $conn->error;
    }


	$removeFriendRequest2 = "DELETE FROM friend_requests WHERE user_from = '$currentUserID' AND user_to = '$requestFromID'";

		if ($conn -> query($removeFriendRequest2) === TRUE) {
	 	} else {
			echo "Error: ". $removeFriendRequest2 . "<br>" . $conn->error;
	    }

}

//perform if reject button is pressed
if($reject == 'yes') {
	$removeFriendQuery = "DELETE FROM friend_requests WHERE user_from = '$requestFromID' AND user_to = '$currentUserID'";

	if ($conn -> query($removeFriendQuery) === TRUE) {
		echo "Rejected";
 	} else {
		echo "Error: ". $removeFriendQuery . "<br>" . $conn->error;
    }

}

?>
