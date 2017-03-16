<?php
include '../includes/phptop.php';
include '../includes/functions.php';

header('Location: ../public/chatWindow.php');

$userID = $_SESSION["userID"];
$_SESSION["chatID"] = $_POST["chat"];
?>

