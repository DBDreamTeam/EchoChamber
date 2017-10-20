<?php

session_start();

include('../includes/connect.php');
include('../includes/functions.php');

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
    <title>Your Chamber</title>

    <!-- Bootstrap -->
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/custom.css" rel="stylesheet" type="text/css">

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

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                    <li><a><button type="submit" name="nav" value="myFeed" class="nav-link" form="nav-form">My Feed</button></a></li>
                    <li><a><button type="submit" name="nav" value="myProfile" class="nav-link" form="nav-form">My Profile</button></a></li>
                    <li><a><button type="submit" name="nav" value="photos" class="nav-link" form="nav-form">My Photos</button></a></li>
                    <li><a><button type="submit" name="nav" value="chat" class="nav-link" form="nav-form">Chat</button></a></li>
                    <li><a><button type="submit" name="nav" value="myAccount" class="nav-link" form="nav-form">My Account</button></a></li>
                    <li><a><button type="submit" name="nav" value="logout" class="nav-link" form="nav-form">Log Out</button></a></li>
                  </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
        <!-- End navbar -->
        
        <!-- TODO: Add the new post box here -->
        <div class="row">
          <div class="col-sm-2">
            <?php 
            $profile_pic_sql = "SELECT PictureID FROM users WHERE UserID = $LoggedUserID";
            $profile_pic_result = $link->query($profile_pic_sql);
            if ($pic_id = $profile_pic_result->fetch_assoc()['PictureID']) { ?>
            <img src="<?php echo getProfilePicPath($FriendUserID, $link); ?>" class="profile-pic" alt="<?php echo $CheckFriend; ?>'s profile picture">
            <?php } ?>
          </div>
          <div class="col-sm-10" id="new-post">
            
            <h3><?php echo $CheckFriend; ?></h3>
            
            
            
            <!-- START OF MABEL'S STUFF -->
            
            <?php
            
            //Check from friendship table to see if they are friends
            $FriendshipTableSql = "
                SELECT * FROM friendships 
                    WHERE UserTwo ='$FriendUserID'";
            $UserTableSql = "
                SELECT * FROM users 
                    WHERE Username ='$CheckFriend'";
            $FriendshipResult = $link->query($FriendshipTableSql);
            $UserTableResult = $link->query($UserTableSql);
            
            //Query from friendship table to see if two users are friend or not
            $FriendshipQuery = "
                SELECT * FROM friendships 
                    WHERE UserOne ='$LoggedUserID' 
                    AND UserTwo = '$FriendUserID'";
            $isFriend = $link->query($FriendshipQuery);

            //find the blogID
            $getBlogIDQuery = "
                SELECT BlogID FROM blog_wall 
                    WHERE OwnerID ='$FriendUserID'";
            $getBlogIDResult = $link->query($getBlogIDQuery);
            $BlogID = null;
            while($row = $getBlogIDResult->fetch_assoc()) {
              //Store blogID into a variable
              $BlogID = $row['BlogID'];
              $_SESSION['BlogID'] = $BlogID;
            }

            //Store blogID into session variable

            //Check privacy of blog
            $checkPrivacy = "SELECT Privacy FROM blog_wall WHERE BlogID = '$BlogID'";
            $privacyResult = $link->query($checkPrivacy);
            while($row = $privacyResult->fetch_assoc()) {
              $privacy = $row['Privacy'];
            }
            
            
            // If a user is viewing their own profile, show a textarea
            // for them to make a new post
            if ($user == $CheckFriend) { 
            ?>
              <!-- https://www.w3schools.com/css/css_form.asp -->
              <form method = "POST" action = "../process/blog.php" enctype="multipart/form-data">
                <input type="hidden" name="BlogID" value="<?php
                $sql = "SELECT BlogID FROM blog_wall
                            WHERE OwnerID = $LoggedUserID";
                $result = $link->query($sql);
                if ($result) {
                  echo $result->fetch_assoc()['BlogID'];
                }
                ?>">
                <textarea id = "blogText" name="blogInput" placeholder="Write a new post"></textarea>
                <input type="file" name="uploadedimage">
                <input type="submit" class="btn btn-default pull-right" value="Post" name="submitBlog">
              </form>
            <?php  
            }
            ?>
            
            
            <!-- END OF MABEL'S STUFF -->
            
          </div>
        </div>
        
        <!-- Content area -->
        <div class="row">
          
          <!-- Main area (posts, photos etc) -->
          <div class="col-sm-8" id="main-feed">
            
            <?php
            
            $feed_posts_sql = "
                SELECT PostID FROM posts
                    JOIN blog_wall
                    ON posts.BlogID = blog_wall.blogID
                    WHERE OwnerID IN
                        (
                        SELECT UserTwo FROM friendships
                            WHERE UserOne = $LoggedUserID
                        )
                    OR OwnerID = $LoggedUserID
                    ORDER BY Time DESC";
            $feed_posts_result = $link->query($feed_posts_sql);
            while ($row = $feed_posts_result->fetch_assoc()) {
              getFeedItemHTML($row['PostID'], $link);
            }
            
            
            ?>
            

          </div>
          
          <!-- Side area (further info, comments, etc) -->
          <div class="col-sm-4" id="comments" hidden="hidden">
            
            <form method="post" action="../process/processNewPost.php">
              <label id="comment-box">
                <textarea placeholder="New Comment..."></textarea>
              </label>
              <label>
                <input type="submit" class="btn btn-default pull-right" value="Post">
              </label>
            </form>
            
            <h5>Comments</h5>
            
          </div>
          
        </div>
      
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
                  <form action="../process/processSeeFriend.php" method="post">
                    <input type="hidden" name="friendID" value="<?php echo $row['UserID']; ?>">
                    <button type="submit" class="profile-link"><b><?php echo $row['Username']; ?></b></button>
                  </form>
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
            <?php
            $suggested_groups = getGroupRecommendations($LoggedUserID, $link);
            foreach ($suggested_groups as $group_id) {
              $group_name = getCircleNameFromID($group_id, $link);
              ?>
            <form action="../public/groupBlog.php" method="post">
              <input type="hidden" name="GroupID" value="<?php echo $group_id; ?>">
              <button type="submit" class="profile-link"><b><?php echo $group_name; ?></b></button>
            </form>
              <?php
            }
            ?>
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
