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
    <title><?php echo $CheckFriend; ?></title>

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
            <img src="<?php echo getProfilePicPath($FriendUserID, $link); ?>" class="profile-pic">
          </div>
          <div class="col-sm-10" id="new-post">
            
            <h3><?php echo $CheckFriend; ?></h3>
            <h4><a href="photos.php">See Photos</a></h4>
            
            
            
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
                    WHERE IsGroup = 0 
                    AND OwnerID ='$FriendUserID'";
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
            $blog_id = getBlogID($FriendUserID, 0, $link);
            $blog_privacy = getBlogPrivacySettings($blog_id, $link);
            
            if ( ($LoggedUserID == $FriendUserID)
              || ($blog_privacy == "Friends" && isFriends($LoggedUserID, $FriendUserID, $link))
              || ($blog_privacy == "Circles" && inSameCircle($LoggedUserID, $FriendUserID, $link))
              || ($blog_privacy == "FriendsOfFriends" && isFriendOfFriend($LoggedUserID, $FriendUserID, $link))
              || ($blog_privacy == "Public")
              ) {
              
              $users_posts_sql = "
                SELECT PostID FROM posts
                    JOIN blog_wall
                    ON posts.BlogID = blog_wall.BlogID
                    WHERE blog_wall.OwnerID = $FriendUserID
                    AND blog_wall.IsGroup = 0";
              $users_posts_result = $link->query($users_posts_sql);
              while ($row = $users_posts_result->fetch_assoc()) {
                $postID = $row['PostID'];
                getFeedItemHTML($postID, $link);
              } 
            } else {
              ?>
              <h4>Sorry, you are not allowed to view these posts.</h4>
              <?php
            }
            
            
            
            ?>
            
          
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
          ?>

          <div class="col-sm-12 recommendation-section">
            <h4><?php echo $CheckFriend; ?>'s Friends</h4>
            <?php
            $friends = getFriendsArr($FriendUserID, $link);
            foreach ($friends as $friend) {
              ?>
                <form action="../process/processSeeFriend.php" method="post">
                  <input type="hidden" name="friendID" value="<?php echo $friend; ?>">
                  <button type="submit" class="profile-link"><b><?php echo getUsernameFromID($friend, $link); ?></b></button>
                </form>
              <?php
            }
            ?>
          </div>
          
          <div class="col-sm-12 recommendation-section">
            <h4><?php echo $CheckFriend; ?>'s Groups</h4>
            <?php
            $circles = getUserCircleIDs($FriendUserID, $link);
            foreach ($circles as $circle) {
              ?>
                <form action="../process/processSeeFriend.php" method="post">
                  <input type="hidden" name="GroupID" value="<?php echo $group; ?>">
                  <button type="submit" class="profile-link"><b><?php echo getCircleNameFromID($circle, $link); ?></b></button>
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
