<?php

$message = '';

// Create connection
$conn = new mysqli('localhost', 'root', 'root','echochamber');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else{
	if($conn->connect_error){
		$message = $conn->connect_error;
	}
}

?>