<?php

session_start();

//get the BlogID of current profile
$_SESSION["friend2"];
echo $_SESSION["friend2"];

echo '<h1>Search Results</h1>';

if (!empty($_POST['searchTxt'])) {

  include 'connect.php';

  //getting input from search.php
  $q = $_POST['searchTxt'];

  //Get the matching username
  $query = "SELECT * FROM users WHERE Username LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);

  while ($output = mysqli_fetch_assoc($result)){
    $_SESSION["friend2"] = $output['Username'];
    $_SESSION["FriendUserID"] = $output['UserID'];
    echo 'User: '; echo '<a href = "profile.php">'.$output['Username'].'</a>';
    echo '<br>';
  }

  echo '<br>';

  //query for posts
  $query = "SELECT * FROM posts WHERE text LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);
  while ($textOutput = mysqli_fetch_assoc($result)){
    $blogID = $textOutput['BlogID'];
    //Check if isGroup
    $isGroupQuery = "SELECT IsGroup FROM blog_wall WHERE BlogID = '$blogID' ";
    $isGroupresult = mysqli_query($conn, $isGroupQuery);
    while($row = $isGroupresult->fetch_assoc()) {
      $isGroup = $row['IsGroup'];
    }


    //Find the matching OwnerID from blog_wall
    $OwnerIDquery = "SELECT OwnerID FROM blog_wall WHERE BlogID = '$blogID' ";
    $OwnerIDresult = mysqli_query($conn, $OwnerIDquery);
    while($row = $OwnerIDresult->fetch_assoc()) {
      $OwnerID = $row['OwnerID'];
    }

    if ($isGroup == '0') {
      //Find username from user table
      $userQuery = "SELECT * FROM users WHERE UserID = '$OwnerID' ";
      $userResult = mysqli_query($conn, $userQuery);
      while ($userOutput = mysqli_fetch_assoc($userResult)){
        $_SESSION["FriendUserID"] = $userOutput['UserID'];
        $_SESSION["friend2"] = $userOutput['Username'];
        echo 'Posts: '; echo '<a href = "profile.php">'.$textOutput['text'].'</a>';
        echo '<br>';
      }
    } elseif ($isGroup == '1') {
      //Find from user table
      $groupQuery = "SELECT Name FROM groups WHERE GroupID = '$OwnerID' ";
      $groupResult = mysqli_query($conn, $groupQuery);
      while ($output = mysqli_fetch_assoc($groupResult)){
        echo 'Posts: ';
        $_SESSION["groupName"] = $output['Name'];
        echo '<a href = "groupBlog.php">'.$textOutput['text'].'</a>';
        echo '<br>';
    }
    echo '<br>';
  }

  }

  echo '<br>';
  //Get the matching Circle
  $groupQuery1 = "SELECT * FROM groups WHERE Name LIKE '%$q%' ";
  $result1 = mysqli_query($conn, $groupQuery1);
  while ($output1 = mysqli_fetch_assoc($result1)){
    $_SESSION["groupName"] = $output1['Name'];
    echo 'Circle: '; echo '<a href = "groupBlog.php">'.$output1['Name'].'</a>';
    echo '<br>';
  }

}

?>
