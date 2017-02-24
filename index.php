<?php
include 'connect.php';
?>

<!-- <?php
// phpinfo();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

   include 'connect.php';
   session_start();
   header("location: login-destination.php");

   //if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form ("posted by form")

      // $var saving the "cleaned" input form data
      $myusername = mysqli_real_escape_string($_POST['Username']);
      $mypassword = mysqli_real_escape_string($_POST['Password']);

      // query to get the username that matches the user input (saved in variable)
      // * now contains all rows from user table
      $sql = "SELECT * FROM users
      WHERE Username = '{$myusername}', Password = '{$mypassword}'";
      //save the vars returned from db into $result (variable)
      $result = mysqli_query($db,$sql);

$count = mysqli_num_rows($result);
if ($count > 0) {// fetching data from associative array
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
?> -->

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

<!-- Wrapper Start -->
<div class="wrapper" id="wrapper">

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
</header>

<!-- About Us Section -->
<section class="aboutus" id="aboutus">
<div class="container">
    <div class="row" style="padding-top:30px">
        <div class="col-md-6">
            <!--
            <div class="heading text-center">
            <img class="dividerline" src="img/sep.png" alt="">
            <h2>About EchoChamber</h2>
            <img class="dividerline" src="img/sep.png" alt="">
            -->
            <p> <b>EchoChamber</b> is the social network for the modern day.
                Here, you can avoid seeing any views with which you disagree,
                and bask in just how fabulously <b>right</b> you are about
                everything. Join groups of like-minded people and while
                away your days patting each other on the back, reaffirming
                the views you came here with, and generally just reminding
                yourself how superior you are to all those other idiots out
                there. <b>Have fun!</b>
            <p>
        </div>
        <div class="col-md-6 text-right">
            <p style="position:relative; right:10px"><b>Log In</b></p>
            <form action="login-destination.php" method="post">
                <label>
                    Email:
                    <input type="Username" name="Username">
                </label>
                <label>
                    Password:
                    <input type="Password" name="Password">
                </label>
                <label>
                    <input type="submit" value="Log In">
                </label>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>
</section>

<!-- Features Section -->
<section class="features" id="features">
<div class="container">
    <div class="row">
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        </div>
    </div>
</div>
</section>

<!-- Contact Section -->
<section class="contact" id="contact">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>
</div>
</section>

<!-- Footer -->
<section class="footer" id="footer">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>
</div>
</section>

<!-- Wrapper End -->
</div>
