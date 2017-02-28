<?php

session_start();

include 'connect.php';
include 'header.php';
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
<title> Profile </title>
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
<head>
<body>


<?php
// Set session variables
$_SESSION["loggedUser"] = $_GET["name"];
$_SESSION["friend2"] = $_GET["FriendName"];
echo "Session variables are set.";
?>

<?php

//get the userID of current logged user
  $user = $_GET["name"];
  $getLoggedUserIDSql = "SELECT UserID FROM users WHERE Username ='$user'";
  $getLoggedUserIDResult = $conn->query($getLoggedUserIDSql);
	if($conn->connect_error){
		$message = $conn->connect_error;
	}
  while($row = $getLoggedUserIDResult->fetch_assoc()) {
    $LoggedUserID = $row['UserID'];
  }

//get the details of friend
	$CheckFriend = $_GET["FriendName"];
	$getFriendUserIDSql = "SELECT UserID FROM users WHERE Username ='$CheckFriend'";
  $getFriendUserIDResult = $conn->query($getFriendUserIDSql);

	if($conn->connect_error){
		$message = $conn->connect_error;
	}
  while($row = $getFriendUserIDResult->fetch_assoc()) {
    $FriendUserID = $row['UserID'];
  }

//
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else{

//Check from friendship table to see if they are friends
$FreindshipTableSql = "SELECT * FROM friendships WHERE UserTwo ='$FriendUserID'";


//fetch the username from user table
//$TestSQL = "SELECT Username FROM users WHERE 'UserID' IN (
//  SELECT UserTwo FROM friendships WHERE 'UserOne' = $FriendUserID)";
//$TestSQLResult = $conn->query($TestSQL);

//while($row = $TestSQLResult->fetch_assoc()) {
//  $test = $row['UserID'];
//  echo "123";
//  echo $test;
//}

$UserTableSql = "SELECT * FROM users WHERE Username ='$CheckFriend'";

$FreindshipResult = $conn->query($FreindshipTableSql);
$UserTableResult = $conn->query($UserTableSql);
if($conn->connect_error){
	$message = $conn->connect_error;
	}
}
?>
<br>

<!-- Welcome message for logged user -->

Welcome ! <?php echo $user; ?>
<br>
<br>
<br>

<!-- This shows the user's profile that logged user is looking at -->
<h3><?php echo $CheckFriend; ?>'s profile </h3>
	<br>
    <!-- Display logged user's friends-->
    <p><?php echo $CheckFriend; ?>'s friends UserID: </p>
    <?php while($row = $FreindshipResult->fetch_assoc()) { ?>
	<p> </p>
	<?php echo $row['UserOne']; ?>
    <?php
	} ?>

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

   <!-- Check if the logged user is friend with he/she yet-->
    <p> Is friend? </p>
    <?php

	//Query from friendship table to see if two users are friend or not
	$FreindshipQuery = "SELECT * FROM friendships WHERE UserOne ='$LoggedUserID' AND UserTwo = '$FriendUserID'";

	$isFriend = $conn->query($FreindshipQuery);

	?>

	<!-- He/she is friends, a remove button will be shown-->
	<?php if(mysqli_num_rows($isFriend)>=1){
		echo "You are already friends ^_^"; ?>
		<br>
		<br>
		<form method="POST">
			<input type="submit" name = "removeFriend" class ="remove" value ="Remove">
			<!-- Remove button will -->
			<?php

			if(isset($_POST['removeFriend'])) {
				$removeFriendQuery = "DELETE FROM friendships WHERE UserOne = '$LoggedUserID' AND UserTwo = '$FriendUserID'";

				$removeFriend2 = "DELETE FROM friendships WHERE UserTwo = '$LoggedUserID' AND UserOne = '$FriendUserID'";

				if ($conn -> query($removeFriendQuery) === TRUE) {
				echo " ";
 				} else {
					echo "Error: ". $removeFriendQuery . "<br>" . $conn->error;
        		}

				if ($conn -> query($removeFriend2) === TRUE) {
						echo "Remove successfully";
						} else {
							echo "Error: ". $removeFriend2 . "<br>" . $conn->error;
				}
			}


	?>
		</form>

	<!-- He/she is not friends yet, an add button is displayed-->
	<?php } else { ?>
	<?php echo "Wow, you are not friends yet!"; ?>

	<form method="POST">
		<input type="submit" name ="addFriend" class = "add" value = "Add">
		<!--Send friend request-->
		<?php
		if(isset($_POST['addFriend'])) {
			$addFriendQuery = "INSERT INTO friend_request (id,user_from, user_to) VALUES (NULL,'$user', '$CheckFriend')";
			if ($conn -> query($addFriendQuery) === TRUE) {
            echo "Request sent successfully";

			} else {
            	echo "Error: ". $addFriendQuery . "<br>" . $conn->error;
        	}
		}


	?>
	</form>


	<?php } //end of if loop ?>




    <!-- add fd-->


    <br>
    <br>



</body>
</html>
