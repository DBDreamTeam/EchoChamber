<?php
include '../includes/connect.php';
include '../includes/functions.php';
session_start();
?>
<?php
header('Location: ../public/manageAccount.php');
?>

<?php
$userID = $_SESSION["LoggedUserID"];
$newEmail = $_POST["email"];


?>

<?php
updateEmail($userID, $newEmail, $link);


?>