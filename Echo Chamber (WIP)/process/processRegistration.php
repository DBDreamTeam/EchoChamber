<?php 
include '../includes/connect.php';
include '../includes/functions.php';
include '../includes/newFunctions.php';

session_start();

mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");
ini_set('$file_uploads', 'On');
?>

<?php
// STILL TO DO HEADER FOR REDIRECT TO PROFILE/BLOG PAGE
header('Location: ../public/choose-your-chamber.php'); 
?>

<?php
// Get variables from post
$username = $_POST["firstname"] . " " . $_POST["lastname"];
$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$email = $_POST["email"];
$birthday = $_POST["dob"];
//$password = $_POST["email"];

//$birthday = $_POST["year"] . $_POST["month"] . $_POST["day"];
/*$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$birthday = $year . "-" . $month . "-" . $day;*/


// Insert user info into users
$userID = createUser($username, $hash, $email, $birthday, null, $link);
// Creates a blog for the new user
$blogID = createBlog(false, 'Profile Pictures', 'Friends', $userID, $link);

// If an image has been uploaded, does the following:

if(!empty($_FILES["uploadedimage"]["name"])) {
    // Creates an album for the new user and assigns the album ID to $albumID
    $albumID = insertAlbum('Profile Pictures', $userID, 'Friends', $link);
    // Inserts the uploaded image into the new album
    $picID = insertImageNew($albumID, "uploadedimage", $link);
    // Puts the picID into the users table for the new user
    updateUsrPicID($userID, $picID, $link);
}

// Set session variable
$_SESSION["LoggedUserID"] = $userID;
$_SESSION["FriendUserID"] = $userID;
$_SESSION["isGroup"] = 0;
$_SESSION["BlogID"] = $blogID;
//echo $_SESSION["LoggedUserID"];

$link -> close();
?>