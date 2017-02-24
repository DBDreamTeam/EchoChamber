<?php
// phpinfo();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  include 'connect.php';
   session_start();
   //header("location: index.php");

   //if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form ("posted by form")

      // $var saving the "cleaned" input form data
      $myusername = mysqli_real_escape_string($link, $_POST['Username']);
      $mypassword = mysqli_real_escape_string($link, $_POST['Password']);

      // query to get the username that matches the user input (saved in variable)
      // * now contains all rows from user table
      $sql = "SELECT * FROM users
      WHERE Username = '{$myusername}', Password = '{$mypassword}'";
      //save the vars returned from db into $result (variable)
      $result = mysqli_query($link,$sql);

if (mysqli_num_rows($result) > 0) {
  // fetching data from associative array
  while ($row = mysqli_fetch_assoc($result)) {
    if (($row["Username"] == $myusername) && ($row["Password"] == $mypassword)) {
      //registers the session on the specific user
       $_SESSION['userID'] = $row['UserID'];
    }else {
      $error = "Wrong Username or Password. Please try again.";
      echo $error;
    }
  }
  }
      // session set to active
    //  $active = $row['active'];
   // makes it all die
      // or die('Error making select users query' . mysqli_error());
   mysqli_close($link);
     //"unset($_SESSION)";
?>

<!-- <?php
/*
Add whatever you want to show login success here.
We can start by just having it print out the cookie or
session to show that it knows a specific user is signed in.
*/
echo "Post now holds the following values:<br>";
print_r($_POST);
ie();
?>
//
// if (isset($_POST['email']) {
//   echo $_POST('email');
// }
//
// $result = $db->query(SELECT Username FROM user);
//  $connection =
//       mysqli_connect('localhost','example','ucl','Example')
//       // or die('Error connecting to MySQL server.'. mysql_error());


<!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Echo Chamber Login</title>
    <meta charset="utf-8">
    <meta name="author" content="DBDreamTeam">
    <meta name="viewport" content="width=device-width, intial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <!-- Fonts -->
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300'>
    <link rel='stylesheet' type='text/css'
        href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic'>
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,900'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<!-- Header -->
<header>
<div class="jumbotron jumbotron-fluid" id="banner">
<div class="parallax test-centre" style="background-image: url(img/cover.jpg);">
<div class="parallax-pattern-overlay">
    <div class="container text-center" style="height: 60px; padding-top=170px;">
        <a href="#"><img id="site-title" src="img/ECLogo1.png" alt="logo"
            style="display:block; height:70px; display:inline; position:relative; left:-20px; top:-10px"/></a>
        <h1 style="display:inline">EchoChamber</h1>
        <h6 style="display:inline">a social network for people just like you.<h6>
    </div>
</div>
</div>
</header> -->
