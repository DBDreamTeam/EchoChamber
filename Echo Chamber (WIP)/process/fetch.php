<?php

session_start();

echo '<h1>Search Results</h1>';

if (!empty($_POST['searchTxt'])) {

  include 'connect.php';

  //getting input from search.php
  $q = $_POST['searchTxt'];

  //Get the matching username based on search input
  $query = "SELECT * FROM users WHERE Username LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);

  //output the list of users that matches the search input
  while ($output = mysqli_fetch_assoc($result)){
    echo 'User: ';
    $Username = $output['Username']; ?>
    <form method = "POST" action = "profile.php">
    <?php
    //load username value into button which passes back to profile.php
    echo '<input type="submit" value ='.$Username.' name = "friendUsername">';
     ?>
    </form>
    <?php
  }

  echo '<br>';

  //output the list of posts that matches the search input
  $query = "SELECT * FROM posts WHERE text LIKE '%$q%' ";
  $result = mysqli_query($conn, $query);
  while ($textOutput = mysqli_fetch_assoc($result)){
    //Get the blogID for each matching posts
    $blogID = $textOutput['BlogID'];

    //Check if the blog belongs to group blog or individual blog
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
      echo "Post's content : ";
    }

    if ($isGroup == '0') {
      //Find username from user table
      $userQuery = "SELECT * FROM users WHERE UserID = '$OwnerID' ";
      $userResult = mysqli_query($conn, $userQuery);
      while ($userOutput = mysqli_fetch_assoc($userResult)){
        $Username = $userOutput['Username'];
        //Output the post content
        echo $textOutput['text'];
        ?>
        <form method = "POST" action = "profile.php">
        <?php
        //load username value into button
        echo '<input type="submit" value ='.$Username.' name = "friendUsername">';
         ?>
        </form>
        <?php
        echo '<br>';
      }
    } elseif ($isGroup == '1') {
      //Find group name from groups table
      $groupQuery = "SELECT Name FROM groups WHERE GroupID = '$OwnerID' ";
      $groupResult = mysqli_query($conn, $groupQuery);
      while ($output = mysqli_fetch_assoc($groupResult)){
        $groupName = $output['Name'];
        //Output the post content
        echo $textOutput['text'];
        ?>
        <form method = "POST" action = "groupBlog.php">
        <?php
        //load groupname value into button
        echo '<input type="submit" value ='.$groupName.' name = "groupName">';
         ?>
        </form>
        <?php
        echo '<br>';
    }
    echo '<br>';
  }

  }

  echo '<br>';
  //Get the matching Circle
  $groupQuery = "SELECT * FROM groups WHERE Name LIKE '%$q%' ";
  $result = mysqli_query($conn, $groupQuery);
  while ($output = mysqli_fetch_assoc($result)){
    echo "Circles : ";
    $groupName = $output['Name'];
    ?>
    <form method = "POST" action = "groupBlog.php">
    <?php
    //load groupname value into button, passes back to groupBlog.php
    echo '<input type="submit" value ='.$groupName.' name = "groupName">';
     ?>
    </form>
    <?php
  }
}

?>
