<?php

session_start();

include 'connect.php';
include 'header.php';
include 'function.php';

//this get the groupName variable from fetch.php
if (!empty($_POST["groupName"])) {
  //echo $_POST["testFriend"];
  $_SESSION["groupName"] = $_POST["groupName"];
}

?>

<html>
<head>
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
<title> Group blog </title>
<link rel='stylesheet' href= 'style.css'/>
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
    <link href="css/bootstrap-3.3.7.css" rel="stylesheet" type="text/css">
<div>

  <?php
  //get the userID of current logged user
    $user = $_SESSION["loggedUser"];
    $getLoggedUserIDSql = "SELECT UserID FROM users WHERE Username ='$user'";
    $getLoggedUserIDResult = $conn->query($getLoggedUserIDSql);
    while($row = $getLoggedUserIDResult->fetch_assoc()) {
      $LoggedUserID = $row['UserID'];
    }

  //get the groupID
  $groupName = $_SESSION["groupName"];
  $getGroupIDSql = "SELECT GroupID FROM groups WHERE Name ='$groupName'";
  $getGroupIDResult = $conn->query($getGroupIDSql);
  while($row = $getGroupIDResult->fetch_assoc()) {
    $GroupID = $row['GroupID'];
  }

  //set session for loggedUser and GroupID
  $_SESSION["GroupID"] = $GroupID;
  $_SESSION["LoggedUserID"] = $LoggedUserID;

  //Query from group table to see if they are part of the group
  $groupMemQuery = "SELECT * FROM group_members WHERE UserID ='$LoggedUserID' AND GroupID = '$GroupID'";
  $isGroupMember = $conn->query($groupMemQuery);

  //find the blogID
  $getBlogIDQuery = "SELECT BlogID FROM blog_wall WHERE IsGroup = '1' AND OwnerID ='$GroupID'";
  $getBlogIDResult = $conn->query($getBlogIDQuery);
  while($row = $getBlogIDResult->fetch_assoc()) {
  //Store blogID into a variable
  $BlogID = $row['BlogID'];
  }

  //Store blogID into session variable
  $_SESSION["BlogID"] = $BlogID;

  //Check privacy of blog
  $checkPrivacy = "SELECT Privacy FROM blog_wall WHERE BlogID = '$BlogID'";
  $privacyResult = $conn->query($checkPrivacy);
    while($row = $privacyResult->fetch_assoc()) {
      $privacy = $row['Privacy'];
    }

  ?>

<!-- Search session -->
<h1>search </h1>
<form method = "POST" action = "fetch.php">
  <input id = "search" type="text" name="searchTxt">
  <input type="submit" value="Submit" name = "submitSearch">
</form>

<br>
<br>
<!-- Blog session -->
<div class = "column blog">

<br>
<br>

<!-- https://www.w3schools.com/css/css_form.asp -->
<form method = "POST" action = "blog.php">
  Blog:
  <br>
  <input id = "blogText" type="text" name="blogInput">
  <br><br>
  <input type="submit" value="Submit" name = "submitBlog">
</form>

<?php

//load the blog wall

if ($privacy == 'Friends') {
  if(mysqli_num_rows($isGroupMember)>=1){
    $loadBlog = "SELECT * FROM posts WHERE BlogID = '$BlogID' ORDER BY Time DESC";
    $loadBlogResult = $conn->query($loadBlog);
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
    $loadBlog1 = "SELECT * FROM posts WHERE BlogID = '$BlogID' ORDER BY Time DESC";
    $loadBlogResult1 = $conn->query($loadBlog1);
    while($row = $loadBlogResult1->fetch_assoc()) {
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
  } else {
    echo "Friends of friends";
  }

?>

</div>


<!-- Side column to load profile -->
<div class = "column profile">

  <br>

  <!-- Welcome message for logged user -->

  Welcome ! <?php echo $user;?>
  <br>
  <br>
  <br>

<?php
//Load username
$loadGroupMem = "SELECT u.Username FROM users u
INNER JOIN group_members g ON u.UserID = g.UserID
WHERE g.GroupID = '$GroupID'";
$loadGroupMemResult = $conn->query($loadGroupMem);

 ?>

<!-- This shows the user's profile that logged user is looking at -->
<h3><?php echo $groupName; ?>'s blog </h3>
	<br>
    <!-- Display logged group's member-->
    <p>Member: </p>
    <?php while($row = $loadGroupMemResult->fetch_assoc()) { ?>
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

   <!-- Check if the logged user is friend with he/she yet-->
    <p> Is member? </p>

	<!-- If he/she is part of the group, a leave button will be shown-->
	<?php if(mysqli_num_rows($isGroupMember)>=1){
		echo "You are part of the group ^_^"; ?>
		<br>
		<br>
		<form method="POST">
			<input type="submit" name = "leaveGroup" class ="remove" value ="Leave">
      <!--Send leave request-->
			<?php
			if(isset($_POST['leaveGroup'])) {
				$leaveQuery = "DELETE FROM group_members WHERE GroupID = '$GroupID' AND UserID = '$LoggedUserID'";
				if ($conn -> query($leaveQuery) === TRUE) {
				  echo "Leave successfully";
 				} else {
					echo "Error: ". $leaveQuery . "<br>" . $conn->error;
        		}
			}
	?>
		</form>
	<!-- If he/she is not part of the group yet, an add button is displayed-->
	<?php } else { ?>
	<?php echo "Wow, you are not part of the group yet!"; ?>

	<form method="POST">
		<input type="submit" name ="joinGroup" class = "add" value = "Join">
		<!--Send join request-->
		<?php
		if(isset($_POST['joinGroup'])) {
			$joinQuery = "INSERT INTO group_members (GroupID, UserID) VALUES ('$GroupID', '$LoggedUserID')";
			if ($conn -> query($joinQuery) === TRUE) {
            echo "Join successfully";
			} else {
            	echo "Error: ". $joinQuery . "<br>" . $conn->error;
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
