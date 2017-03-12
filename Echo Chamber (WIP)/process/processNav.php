<?php
include '../includes/connect.php';
session_start();
?>

<?php
$location = $_POST["nav"];
echo $location;


if($location == "myFeed" || $location == "myProfile" || $location == "chat" || $location == "myAccount" || $location == "logout") {
    $_SESSION["FriendUserID"] = $_SESSION["LoggedUserID"];
} 

if($location == "profile") {
    header('Location: ../public/landing.php');
} elseif($location == "photos"){
    $_SESSION['albumID'] = "allPhotos";
    header('Location: ../public/photos.php');
} elseif($location == "myFeed"){
    header('Location: ../public/feed.php');
} elseif($location == "myProfile"){
    header('Location: ../public/landing.php');
} elseif($location == "chat"){
    header('Location: ../public/chat.php');
} elseif($location == "myAccount"){
    header('Location: ../public/manageAccount.php');
} elseif($location == "logout"){
    header('Location: ../public/index.php');
}



?>