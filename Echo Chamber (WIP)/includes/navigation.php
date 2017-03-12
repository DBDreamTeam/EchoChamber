<?php //session_start(); ?>

<?php // getting session variables
$loggedUser = $_SESSION["LoggedUserID"];
$pageOwner = $_SESSION["FriendUserID"]; ?>

<form action="../process/processNav.php" method="post">

<button type="submit" name="nav" value="profile">Profile</button>
<button type="submit" name="nav" value="photos">Photos</button><br>

<button type="submit" name="nav" value="myFeed">My Feed</button>
<button type="submit" name="nav" value="myProfile">My Profile</button>
<button type="submit" name="nav" value="chat">Chat</button>
<button type="submit" name="nav" value="myAccount">My Account</button>
<button type="submit" name="nav" value="logout">Logout</button>

</form>

<?php

/*
echo 

"<a href = \"landing.php\">";
    if($loggedUser == $pageOwner){ 
        echo "My Profile";
    }else {
        echo "Profile";
    }  
echo "</a>
<a href = \"photos.php\">Photos</a>
<br>
<a href = \"feed.php\">Feed</a>
<a href = \"photos.php\">Chat</a>
<a href = \"myAccount.php\">My Account</a>
<a href = \"logout.php\">Logout</a>"
*/
   
           
?>