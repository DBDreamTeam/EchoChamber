<?php

session_start();

header("Location: ../public/landing.php");

$_SESSION["FriendUserID"] = $_POST["friendID"];
echo $_SESSION["FriendUserID"];


?>
