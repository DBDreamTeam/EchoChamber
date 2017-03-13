<?php

session_start();

// Add the last response into the array in SESSION
$entity = $_POST['entity'];
$sentiment = $_POST['sentiment'];
$_SESSION['onboarding_entities'][$entity] = $sentiment;

// If they have responded to enough entities, add their responses to the
// DB and send them to the homepage
if (count($_SESSION['onboarding_entities']) >= 3) {
  
  require_once('../includes/connect.php');
  // Looping through the entities and adding them to the DB
  foreach ($_SESSION['onboarding_entities'] as $entity=>$sentiment) {
    $userid = $_SESSION['LoggedUserID'];
    $sql = "REPLACE INTO sentiments (UserID, Entity, Sentiment)
                VALUES ($userid, '$entity', '$sentiment')";
    $result = mysqli_query($link, $sql);
  }
  // Remove the array from SESSION data
  unset($_SESSION['onboarding_entities']);
  // Redirect them to their profile
  header('Location: ../public/profile.php');
  
} else {
  // If they haven't been shown enough entities, redirect them to respond
  // to another
  header('Location: ../public/choose-your-chamber.php');
}

?>
