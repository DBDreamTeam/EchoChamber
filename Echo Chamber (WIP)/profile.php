<?php

session_start();

include '../includes/connect.php';
include '../includes/navigation.php';
include '../includes/functions.php';

?>

<?
$LoggedUserID = $_SESSION["LoggedUserID"];
$user = getUsernameFromID($LoggedUserID, $link);
$FriendUserID = $_SESSION["FriendUserID"];
$CheckFriend = getUsernameFromID($FriendUserID, $link);

echo $LoggedUserID; 
echo $user;
echo $FriendUserID;
echo $CheckFriend;
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>EchoChamber</title>

    <!-- Bootstrap -->
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<body>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Profile </title>
<link rel='stylesheet' href= 'css/style.css'/>
<!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/custom.css">
<!-- Fonts -->
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300'>
    <link rel='stylesheet' type='text/css'
        href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic'>
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,900'>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<div>





  <?php
  //get the userID of current logged user
    /*$user = $_SESSION["loggedUser"];
    $getLoggedUserIDSql = "SELECT UserID FROM users WHERE Username ='$user'";
    $getLoggedUserIDResult = $link->query($getLoggedUserIDSql);
    while($row = $getLoggedUserIDResult->fetch_assoc()) {
      $LoggedUserID = $row['UserID'];
    }*/

  //get the details of friend
 /* 	$CheckFriend = $_SESSION["friend2"];
  	$getFriendUserIDSql = "SELECT UserID FROM users WHERE Username ='$CheckFriend'";
    $getFriendUserIDResult = $link->query($getFriendUserIDSql);
    while($row = $getFriendUserIDResult->fetch_assoc()) {
      $FriendUserID = $row['UserID'];
    }*/

  //Check from friendship table to see if they are friends
  $FreindshipTableSql = "SELECT * FROM friendships WHERE UserTwo ='$FriendUserID'";
  $UserTableSql = "SELECT * FROM users WHERE Username ='$CheckFriend'";
  $FreindshipResult = $link->query($FreindshipTableSql);
  $UserTableResult = $link->query($UserTableSql);
  ?>

  <?php
  //set session ID for loggedUser and Friend
  //$_SESSION["FriendUserID"] = $FriendUserID;
  //$_SESSION["LoggedUserID"] = $LoggedUserID;
  


  //Query from friendship table to see if two users are friend or not
	$FreindshipQuery = "SELECT * FROM friendships WHERE UserOne ='$LoggedUserID' AND UserTwo = '$FriendUserID'";
	$isFriend = $link->query($FreindshipQuery);


  //find the blogID
    $getBlogIDQuery = "SELECT BlogID FROM blog_wall WHERE IsGroup = '0' AND OwnerID ='$FriendUserID'";
    $getBlogIDResult = $link->query($getBlogIDQuery);
    while($row = $getBlogIDResult->fetch_assoc()) {
      //Store blogID into a variable
      $BlogID = $row['BlogID'];
      $_SESSION["BlogID"] = $BlogID;
  }

  //Store blogID into session variable


  //Check privacy of blog
  $checkPrivacy = "SELECT Privacy FROM blog_wall WHERE BlogID = '$BlogID'";
  $privacyResult = $link->query($checkPrivacy);
    while($row = $privacyResult->fetch_assoc()) {
      $privacy = $row['Privacy'];
    }
   ?>


<!-- Blog session -->
<div class = "column blog">

<br>
<br>

<?php

  if ($user == $CheckFriend) { ?>
    <!-- https://www.w3schools.com/css/css_form.asp -->
    <form method = "POST" action = "../process/blog.php">
      Blog:
      <br>
      <input id = "blogText" type="text" name="blogInput">
      <br><br>
      <input type="submit" value="Submit" name = "submitBlog">
    </form>
<?php  } ?>


<?php


//load the blog wall
if ($user == $CheckFriend) {
    $loadBlog = "SELECT * FROM posts WHERE BlogID = '$BlogID' ORDER BY Time DESC";
    $loadBlogResult = $link->query($loadBlog);
    while($row = $loadBlogResult->fetch_assoc()) {
      echo "Previous Blog: ";
      echo '<br>';
      echo "Time : ";
      echo $row['Time'];
      echo '<br>';
      echo $row['text'];
      echo '<br>';
    }
  }

if ($privacy == 'Friends') {
  if(mysqli_num_rows($isFriend)>=1){
    $loadBlog = "SELECT * FROM posts WHERE BlogID = '$BlogID' ORDER BY Time DESC";
    $loadBlogResult = $link->query($loadBlog);
    while($row = $loadBlogResult->fetch_assoc()) {
      echo "Previous Blog: ";
      echo '<br>';
      echo "Time : ";
      echo $row['Time'];
      echo '<br>';
      echo $row['text'];
      echo '<br>';
    }
  }
} elseif ($privacy == 'Public') {
    $loadBlog = "SELECT * FROM posts WHERE BlogID = '$BlogID' ORDER BY Time DESC";
    $loadBlogResult = $link->query($loadBlog);
    while($row = $loadBlogResult->fetch_assoc()) {
      echo "Previous Blog: ";
      echo '<br>';
      echo "Time : ";
      echo $row['Time'];
      echo '<br>';
      echo $row['text'];
      echo '<br>';
    }
  } elseif ($privacy == 'Circles') {
    echo "circle";
  } elseif ($privacy == 'FriendsOfFriends') {
    echo "Friends of friends";
  }

?>


</div>


<!-- Side column to load profile -->
<div class = "column profile">

  <br>

  <!-- Welcome message for logged user -->

  Welcome ! <?php echo $user; ?>
  <br>
  <br>
  <br>

<?php
$loadMem = "SELECT u.Username FROM users u INNER JOIN friendships f
ON u.UserID = f.UserOne
WHERE UserTwo ='$FriendUserID'";
$loadMemResult = $link->query($loadMem);

 ?>
<!-- This shows the user's profile that logged user is looking at -->
<h3><?php echo $CheckFriend; ?>'s profile </h3>
	<br>
    <!-- Display logged user's friends-->
    <p>Friends: </p>
    <?php while($row = $loadMemResult->fetch_assoc()) { ?>
	<p> </p>
	<?php echo $row['Username']; ?>
    <?php
	} ?>
  <br>
  <br>
  <br>
  <br>
  <?php
  echo "Visible to :  ";
  echo $privacy;
  echo '<br>';
?>
    <br>
    <br>
    <br>
    <br>

    <!-- Display logged user's birthday-->
    <p> Birthday: </p>
    <?php while($row = $UserTableResult->fetch_assoc()) { ?>
	<p> </p>
	<?php echo $row['Birthday']; ?>
    <?php } ?>

    <br>
    <br>
    <br>
    <br>

	<!-- He/she is friends, a remove button will be shown-->
	<?php if((mysqli_num_rows($isFriend)>=1)&& $user !== $CheckFriend){ ?>
    <p> Is friend? </p>
		<?php echo "You are already friends ^_^"; ?>
		<br>
		<br>
		<form method="POST">
			<input type="submit" name = "removeFriend" class ="remove" value ="Remove">
			<!-- Remove button will -->
			<?php
			if(isset($_POST['removeFriend'])) {
				$removeFriendQuery = "DELETE FROM friendships WHERE UserOne = '$LoggedUserID' AND UserTwo = '$FriendUserID'";

				$removeFriend2 = "DELETE FROM friendships WHERE UserTwo = '$LoggedUserID' AND UserOne = '$FriendUserID'";

				if ($link -> query($removeFriendQuery) === TRUE) {
				echo " ";
 				} else {
					echo "Error: ". $removeFriendQuery . "<br>" . $link->error;
        		}
				if ($link -> query($removeFriend2) === TRUE) {
						echo "Remove successfully";
						} else {
							echo "Error: ". $removeFriend2 . "<br>" . $link->error;
				}
			}

	?>
		</form>
	<!-- He/she is not friends yet, an add button is displayed-->
	<?php } elseif ((mysqli_num_rows($isFriend)<=0)&& $user !== $CheckFriend) { ?>
    <p> Is friend? </p>
	<?php echo "Wow, you are not friends yet!"; ?>

	<form method="POST">
		<input type="submit" name ="addFriend" class = "add" value = "Add">
		<!--Send friend request-->
		<?php
		if(isset($_POST['addFriend'])) {
			$addFriendQuery = "INSERT INTO friend_request (id,user_from, user_to) VALUES (NULL,'$user', '$CheckFriend')";
			if ($link -> query($addFriendQuery) === TRUE) {
            echo "Request sent successfully";

			} else {
            	echo "Error: ". $addFriendQuery . "<br>" . $link->error;
        	}
		}
	   ?>
	</form>
</div>

</div>
	<?php } //end of if loop ?>
</body>
</head>
</html>
