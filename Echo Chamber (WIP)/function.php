<?php

function loggedin(){
	if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])){
		return true;
	}else {
		return false;
	}
}

function getuser ($id, $field) {
	$query = $conn->query("SELECT $field FROM users WHERE UserID = '$id'");
	$run = mysqli_fetch_array($query);
	return $run [$field];
}

/**
function isFriend($username_to_check) {
	
	
	$usernameSeparator = "," . $username_to_check . ",";
	
	if (strstr($this->user['friend_array']))
	
		
}

*/

?>


