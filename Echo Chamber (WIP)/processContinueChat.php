<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>
<?php include '../includes/chatFunctions.php';?>

<?php
header('Location: ../public/chatWindow.php');
?>


<?php
$userID = $_SESSION["userID"];
$_SESSION["chatID"] = $_POST["chat"];
?>

