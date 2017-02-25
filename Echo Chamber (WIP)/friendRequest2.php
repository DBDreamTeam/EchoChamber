<?php

session_start();

include 'connect.php';
include 'header.php';


	$currentUser = $_GET["name"];

?>


<html>  
<head>
	

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
</head>
<body>

<!-- display list of friend request -->
Friend request for <?php echo "$currentUser" ?> : 
<br>
<br>

<table style = "width: 100%">
    
    <!-- tr is the row -->
    <!-- table cell is td -->
    <!-- th is the header -->
    
    

    <tr>
        <th> Request From </th>
        <th> Accept friend </th>
        <th> Reject friend </th>
    </tr>
<?php

//Display list of friend request for current user
$sql = "SELECT * FROM friend_request WHERE user_to = '$currentUser'";
    $result = $conn->query($sql);
    if (!$result) {
        echo "failed";
    } else {
        while ($row = $result->fetch_assoc()) {
			$user_from = $row['user_from'];
			$user_to = $row['user_to']; ?>
           
      
           	<tr>
            <?php echo '  <td>' . $user_from . '</td>'; ?>
        
            <td><form action="handleFriendRequest.php" method="get">
            <button type="submit" class="acceptFriend" name = "accept">Accept
           	</button>
			<?php 
			echo '  <input type="hidden" name="user_to" value="' . $user_to . '">';
			echo '  <input type="hidden" name="user_from" value="' . $user_from . '">';
			echo '  <input type="hidden" name="reject" value="no">'; 
			echo '  <input type="hidden" name="accept" value= "yes">';	
				?>
           	
           	</form></td>
           	
           	
            <td><form action="handleFriendRequest.php" method="get">
			<button type="submit" class="rejectFriend" name = "reject">Reject</button>
			<?php 
			echo '  <input type="hidden" name="user_from" value="' . $user_from . '">';
			echo '  <input type="hidden" name="user_to" value="' . $user_to . '">'; 
			echo '  <input type="hidden" name="reject" value="yes">'; 
			echo '  <input type="hidden" name="accept" value= "no">';	
				?>
           </form></td>
            
			</tr>
       <?php } ?>
<?php } ?>
  
</table>


</body>
</html>