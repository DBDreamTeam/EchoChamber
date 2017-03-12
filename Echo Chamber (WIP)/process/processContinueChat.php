<?php
include '../includes/phptop.php';
include '../includes/functions.php';?>


<?php
header('Location: ../public/chatWindow.php');
?>


<?php
$userID = $_SESSION["userID"];
$_SESSION["chatID"] = $_POST["chat"];
?>

