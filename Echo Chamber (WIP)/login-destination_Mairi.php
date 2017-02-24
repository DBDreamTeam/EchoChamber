<?php
include 'connect.php';
// phpinfo();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
WHERE Username = '{$myusername}' AND Password = '{$mypassword}'";
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
//mysqli_close($link);
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
//ie();
?>
