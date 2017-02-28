<?php

include 'connect.php';

$requestFrom = $_GET["user_from"];
$currentUser = $_GET["user_to"];

//Get the userID
  $getUserIDSql = "SELECT UserID FROM users WHERE Username ='$requestFrom'";
  $result = $conn->query($getUserIDSql);
	if($conn->connect_error){
		$message = $conn->connect_error;
	}
  while($row = $result->fetch_assoc()) {
    $requestFromUserID = $row['UserID'];


  }

//Get the current userID
	$getUserIDSql2 = "SELECT UserID FROM users WHERE Username ='$currentUser'";
	$result2 = $conn->query($getUserIDSql2);
	if($conn->connect_error){
		$message = $conn->connect_error;
	}
	while($row = $result2->fetch_assoc()) {
	  $currentUserUserID = $row['UserID'];
	}

$reject = $_GET["reject"];
$accept = $_GET["accept"];

//perform if accept button is pressed
if($accept == 'yes') {
	$acceptFriendQuery = "INSERT INTO friendships (UserOne, UserTwo) VALUES ('$requestFromUserID', '$currentUserUserID')";
	if ($conn -> query($acceptFriendQuery) === TRUE) {
	} else {
		echo "Error: ". $acceptFriendQuery . "<br>" . $conn->error;
	}

	$acceptFriendQuery2 = "INSERT INTO friendships (UserOne, UserTwo) VALUES ('$currentUserUserID', '$requestFromUserID')";

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


	$removeFriendRequest2 = "DELETE FROM friend_request WHERE user_from = '$currentUser' AND user_to = '$requestFrom'";

		if ($conn -> query($removeFriendRequest2) === TRUE) {
	 	} else {
			echo "Error: ". $removeFriendRequest2 . "<br>" . $conn->error;
	    }

}

//perform if reject button is pressed
if($reject == 'yes') {
	$removeFriendQuery = "DELETE FROM friend_request WHERE user_from = '$requestFrom' AND user_to = '$currentUser'";

	if ($conn -> query($removeFriendQuery) === TRUE) {
		echo "Rejected";
 	} else {
		echo "Error: ". $removeFriendQuery . "<br>" . $conn->error;
    }

}

?>
