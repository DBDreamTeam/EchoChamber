<?php
session_start();

if (!empty($_POST['searchTxt'])) {
  
  include("../includes/connect.php");
  include("../includes/functions.php");
  
  $LoggedUserID = $_SESSION["LoggedUserID"];
  $user = getUsernameFromID($LoggedUserID, $link);
  $FriendUserID = $_SESSION["FriendUserID"];
  $CheckFriend = getUsernameFromID($FriendUserID, $link);
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Search Results</title>

    <!-- Bootstrap -->
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/custom.css?v=<? echo time(); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <header>
      <h1><span>Echo</span>Chamber</h1>
    </header>
    
    <div class="row">
      
      <!-- Main display area -->
      <div class="col-sm-9">
        
        <!-- Navbar -->
        <!-- ref: https://getbootstrap.com/components/ -->
        <form action="../process/processNav.php" method="post" id="nav-form"></form>
        <div class="row">
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li><a><button type="submit" name="nav" value="profile" class="nav-link" form="nav-form">Profile</button></a></li>
                    <li><a><button type="submit" name="nav" value="photos" class="nav-link" form="nav-form">Photos</button></a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a><button type="submit" name="nav" value="myFeed" class="nav-link" form="nav-form">My Feed</button></a></li>
                    <li><a><button type="submit" name="nav" value="myProfile" class="nav-link" form="nav-form">My Profile</button></a></li>
                    <li><a><button type="submit" name="nav" value="chat" class="nav-link" form="nav-form">Chat</button></a></li>
                    <li><a><button type="submit" name="nav" value="myAccount" class="nav-link" form="nav-form">My Account</button></a></li>
                    <li><a><button type="submit" name="nav" value="logout" class="nav-link" form="nav-form">Log Out</button></a></li>
                  </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
        <!-- End navbar -->
        

        <!-- Content area -->
        <div class="row">

          <!-- Main area (posts, photos etc) -->
          <div class="col-sm-10 col-sm-offset-1" id="main-feed">


<?php

  
  
  echo '<h2>Search Results</h2>';

  //getting input from search.php
  $q = $_POST['searchTxt'];
  
  echo "<h3>You searched for: $q</h3>";

  //Get the matching username based on search input
  $query = "SELECT * FROM users WHERE Username LIKE '%$q%' ";
  $result = mysqli_query($link, $query);

  //output the list of users that matches the search input
  while ($output = mysqli_fetch_assoc($result)){
    ?> <div class="feed-item"> <?php
    echo 'User: ';
    $Username = $output['Username']; ?>
      
    <form action="../process/processSeeFriend.php" method="post">
      <input type="hidden" name="friendID" value="<?php echo $output['UserID']; ?>">
      <button type="submit" class="profile-link"><b><?php echo $Username; ?></b></button>
    </form>
    </div>
    <?php
  }


  //output the list of posts that matches the search input
  $query = "SELECT * FROM posts WHERE text LIKE '%$q%' ";
  $result = mysqli_query($link, $query);
  while ($textOutput = mysqli_fetch_assoc($result)){
    //Get the blogID for each matching posts
    $blogID = $textOutput['BlogID'];

    //Check if the blog belongs to group blog or individual blog
    $isGroupQuery = "SELECT IsGroup FROM blog_wall WHERE ID = '$blogID' ";
    $isGroupresult = mysqli_query($link, $isGroupQuery);
    $isGroup = $isGroupresult->fetch_assoc()['IsGroup'];

    //Find the matching OwnerID from blog_wall
    $OwnerIDquery = "SELECT OwnerID FROM blog_wall WHERE ID = '$blogID' ";
    $OwnerIDresult = mysqli_query($link, $OwnerIDquery);
    while($row = $OwnerIDresult->fetch_assoc()) {
      $OwnerID = $row['OwnerID'];
      ?> <div class="feed-item"> <?php
      echo "Post's content : ";
    }

    if ($isGroup == '0') {
      //Find username from user table
      $userQuery = "SELECT * FROM users WHERE UserID = '$OwnerID' ";
      $userResult = mysqli_query($link, $userQuery);
      while ($userOutput = mysqli_fetch_assoc($userResult)){
        $Username = $userOutput['Username'];
        //Output the post content
        echo $textOutput['text'];
        ?>

        <form action="../process/processSeeFriend.php" method="post">
          <input type="hidden" name="friendID" value="<?php echo $userOutput['UserID']; ?>">
          <button type="submit" class="profile-link">View Profile: <b><?php echo $Username; ?></b></button>
        </form>
        </div>

        <?php
      }
    } elseif ($isGroup == '1') {
      //Find group name from groups table
      $groupQuery = "SELECT Name FROM groups WHERE GroupID = '$OwnerID' ";
      $groupResult = mysqli_query($link, $groupQuery);
      while ($output = mysqli_fetch_assoc($groupResult)){
        $groupName = $output['Name'];
        //Output the post content
        echo $textOutput['text'];
        ?>

        <form action="../public/groupBlog.php" method="post">
          <input type="hidden" name="friendID" value="<?php echo $output['GroupID']; ?>">
          <button type="submit" class="profile-link"><b><?php echo $groupName; ?></b></button>
        </form>
        </div>

        <?php
    }
  }

  }
  //Get the matching Circle
  $groupQuery = "SELECT * FROM groups WHERE Name LIKE '%$q%' ";
  $result = mysqli_query($link, $groupQuery);
  while ($output = mysqli_fetch_assoc($result)){
    ?> <div class="feed-item"> <?php
    echo "Circle: ";
    $groupName = $output['Name'];
    ?>

    <form action="../public/groupBlog.php" method="post">
      <input type="hidden" name="friendID" value="<?php echo $output['GroupID']; ?>">
      <button type="submit" class="profile-link"><b><?php echo $groupName; ?></b></button>
    </form>
    </div>

    <?php
  }
  ?>



        
      
        </div><!-- End main feed col -->
      
      </div><!-- End main feed row -->
      </div>
      
      <!-- Right sidebar/recommendations area -->
      <div class="col-sm-3">
        
        <!-- Search -->
        <div class="row">
          <div class="col-sm-12">
            <div class="container">
              <form class="navbar-form navbar-center" role="search" action="../process/fetch.php" method="post">
                <div class="form-group">
                  <input type="text" id="search" name="searchTxt" class="form-control" placeholder="Search">
                </div>
                <button type="submit" name="submitSearch" class="btn btn-default">Go</button>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Recommendations -->
        <div class="row">
          <!-- If they have Friend Requests, show them -->
        <?php
        $currentUserID = $_SESSION["LoggedUserID"];
        $currentUser = getUsernameFromID($currentUserID, $link);

        //Display list of friend request for current user
        $sql = "SELECT  * FROM friend_requests WHERE user_to = '$currentUserID'";
        $result = $link->query($sql);
        $no_of_friend_requests = mysqli_num_rows($result);
        if ($no_of_friend_requests > 0) {
          ?>
          <div class="col-sm-12 recommendation-section">
            <h4>Friend Requests</h4>
            <table style = "width: 100%">
              <?php
        }

        

            if (!$result) {
                echo "failed";
            } else {
              while ($row = $result->fetch_assoc()) {
                    $user_from = $row['user_from'];
                    $user_to = $row['user_to'];
                    //Get username for requestFrom
                    $sql2 = "SELECT Username FROM users WHERE UserID = '$user_from'";
                    $result2 = $link->query($sql2);
                        if (!$result2) {
                        echo "failed";
                    } else {
                      while ($row = $result2->fetch_assoc()) {
                            $userFromUsername = $row['Username'];
                        }
                    }
                    ?>
                    <tr>
                    <?php echo '  <td>' . $userFromUsername . '</td>'; ?>
                    <td><form action="../process/handleFriendRequest.php" method="get">
                    <button type="submit" class="acceptFriend btn btn-default" name = "accept">Accept
                    </button>
                    <?php
                    echo '  <input type="hidden" name="user_to" value="' . $user_to . '">';
                    echo '  <input type="hidden" name="user_from" value="' . $user_from . '">';
                    echo '  <input type="hidden" name="reject" value="no">';
                    echo '  <input type="hidden" name="accept" value= "yes">';
                        ?>

                    </form></td>


                    <td><form action="../process/handleFriendRequest.php" method="get">
                    <button type="submit" class="rejectFriend btn btn-default" name = "reject">Reject</button>
                    <?php
                    echo '  <input type="hidden" name="user_from" value="' . $user_from . '">';
                    echo '  <input type="hidden" name="user_to" value="' . $user_to . '">';
                    echo '  <input type="hidden" name="reject" value="yes">';
                    echo '  <input type="hidden" name="accept" value= "no">';
                        ?>
                   </form></td>

                    </tr>
               <?php } ?>
        <?php }
          
          if ($no_of_friend_requests > 0) {
            ?>
        </table>
          </div>
          <?php } ?>
          <div class="col-sm-12 recommendation-section">
            <h4>Suggested Friends</h4>
            <?php 
            // Get the ranked list of suggestions
            $suggestedFriends = getFriendRecommendations($LoggedUserID, $link);
            // Show the top 5
            $noToShow = min(5, sizeof($suggestedFriends));
            for ($i = 0 ; $i < $noToShow ; $i++) {
              $userID = $suggestedFriends[$i];
              $sql = "
                  SELECT * FROM users
                      WHERE UserID = $userID";
              $result = $link->query($sql);
              if ($result) {
                $row = $result->fetch_assoc();
                ?>
                <!-- show the friend's name and an add friend button -->
                <div class="suggestion">
                  <button class="profile-link"><b><?php echo $row['Username']; ?></b></button>
                  	<form method="POST">
                      <input <?php 
                        if (isset($_POST['add' . $row['UserID']])) { 
                             ?> type="hidden" <?php 
                        } else { 
                             ?> type="submit" <?php 
                        } ?> name="add<?php echo $row['UserID']; ?>" class="add btn btn-default" value="Add">
                      <!--Send friend request-->
                      <?php
                      if(isset($_POST['add' . $row['UserID']])) {
                          $friendID = $row['UserID'];
                          $addFriendQuery = "
                              INSERT INTO friend_requests 
                                  (user_from, user_to) 
                                  VALUES 
                                  ('$LoggedUserID', '$friendID')";
                          if ($link->query($addFriendQuery)) {
                          echo "Request sent successfully";

                          } else {
                              echo "Error: ". $addFriendQuery . "<br>" . $link->error;
                          }
                      }
                     ?>
                  </form>
                </div>
                <?php
              }
            }
            ?>
          </div>
          <div class="col-sm-12 recommendation-section">
            <h4>Suggested Groups</h4>
          </div>
        </div>
      
      </div>
      
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    
    <!-- control active post -->
    <script src="../js/commentdisplay.js"></script>

  </body>
</html>
  
<?php
} else {
  header("Location: ../public/profile.php");
}

?>
