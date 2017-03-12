<?php

session_start();

//get the BlogID of current profile
$_SESSION["BlogID"];

echo '<h1>Search Results</h1>';

if (!empty($_POST['searchTxt'])) {

  include 'connect.php';
  $q = $_POST['searchTxt'];
  //Get the matching username
  $query = "SELECT * FROM users WHERE Username LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);

  while ($output = mysqli_fetch_assoc($result)){
    echo 'User: '; echo '<a href = "profile">'.$output['Username'].'</a>';
    $_SESSION["friend2"] = $output['Username'];
    echo '<br>';
  }

  echo '<br>';
  //Get the matching Circle
  $query = "SELECT * FROM groups WHERE Name LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);
  while ($output = mysqli_fetch_assoc($result)){
    echo 'Circle: '; echo '<a href = "groupBlog">'.$output['Name'].'</a>';
    $_SESSION["groupName"] = $output['Name'];
    echo '<br>';
  }

}

?>
