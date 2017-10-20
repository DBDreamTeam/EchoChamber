<?php

session_start();

header("Location: ../public/profile.php");

$_SESSION["FriendUserID"] = $_POST["friendID"];
//echo $_SESSION["FriendUserID"];


?>