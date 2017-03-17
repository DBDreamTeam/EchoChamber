<?php
include '../includes/connect.php';
include '../includes/functions.php';
session_start();

header('Location: ../public/manageAccount.php');

$userID = $_SESSION["LoggedUserID"];
$newEmail = $_POST["email"];

updateEmail($userID, $newEmail, $link);

?>