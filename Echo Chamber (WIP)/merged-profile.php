<?php

session_start();

include 'includes/connect.php';
include 'includes/functions.php';

$LoggedUserID = 1; // TEST VALUE       $_SESSION["LoggedUserID"];
$user = getUsernameFromID($LoggedUserID, $link);
$FriendUserID = 1; // TEST VALUE       $_SESSION["FriendUserID"];
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
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/custom.css?v=<? echo time(); ?>" rel="stylesheet" type="text/css">

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
                    <li class="active"><a href="#">Feed<span class="sr-only">(current)</span></a></li>
                    <li><a href="friends.php">Friends</a></li>
                    <li><a href="photos.php">Photos</a></li>
                    <li><a href="../Echo Chamber (WIP)/process/logout.php">Logout</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="../ECGitFolder/profile.php">My Profile</a></li>
                    <li><a href="messages.php">My Messages</a></li>
                  </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
        <!-- End navbar -->
        
        <!-- TODO: Add the new post box here -->
        <div class="row">
          <div class="col-sm-2">
            <img src="img/ECLogo1.png" class="profile-pic" alt="<?php echo $CheckFriend; ?>'s profile picture">
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
                SELECT ID FROM blog_wall 
                    WHERE IsGroup = 0 
                    AND OwnerID ='$FriendUserID'";
            $getBlogIDResult = $link->query($getBlogIDQuery);
            while($row = $getBlogIDResult->fetch_assoc()) {
              //Store blogID into a variable
              $BlogID = $row['ID'];
              $_SESSION["ID"] = $BlogID;
            }

            //Store blogID into session variable

            //Check privacy of blog
            $checkPrivacy = "SELECT Privacy FROM blog_wall WHERE ID = '$BlogID'";
            $privacyResult = $link->query($checkPrivacy);
            while($row = $privacyResult->fetch_assoc()) {
              $privacy = $row['Privacy'];
            }
            
            
            // If a user is viewing their own profile, show a textarea
            // for them to make a new post
            if ($user == $CheckFriend) { 
            ?>
              <!-- https://www.w3schools.com/css/css_form.asp -->
              <form method = "POST" action = "../process/blog.php">
                <textarea id = "blogText" name="blogInput" placeholder="Write a new post"></textarea>
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
            
            <div class="feed-item">
              <h5>Zak Walters</h5>
              <p>I'm so excited about doing this databases project</p>
            </div>
            <div class="feed-item">
              <h5>Mabel Chan</h5>
              <p>OMG I hate emojis, they're so lame and tacky</p>
            </div>
            <div class="feed-item feed-photo">
              <h5>Mairi Ng</h5>
              <img src="img/ECLogo1.png" alt="EC Logo">
              <p>Our logo is so cool!!!!!!!!</p>
            </div>
            <div class="feed-item feed-album">
              <h5>Marisa Enhuber</h5>
              <!-- These need to be scaled down... -->
              <img src="img/ECLogo1.png" alt="EC Logo" class="album-thumbnail" height="70px">
              <img src="img/ECLogo1.png" alt="EC Logo" class="album-thumbnail" height="70px">
              <img src="img/ECLogo1.png" alt="EC Logo" class="album-thumbnail" height="70px">
              <h6>Just loads of our logo!</h6>
              <p>This is the only image I have in the local folder so I
              had to use it as every image in the album.</p>
            </div>
          </div>
          
          <!-- Side area (further info, comments, etc) -->
          <div class="col-sm-4" id="comments">
            
            <form method="post">
              <label id="comment-box">
                <textarea placeholder="New Comment..."></textarea>
              </label>
              <label>
                <button type="submit" class="btn btn-default pull-right">Post</button>
              </label>
            </form>
            
            <h5>Comments</h5>
            
            <div class="comment">
              <p><b>Mairi Ng</b></p>
              <p>Whatever this is, I love it!!!</p>
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
              <form class="navbar-form navbar-center" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Go</button>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Recommendations -->
        <div class="row">
          <div class="col-sm-12">
            <h3>Recommended</h3>
          </div>
        </div>
      
      </div>
      
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    
    <!-- control active post -->
    <script>
      function showComments(clickedPost) {
        // TODO: Add stuff to actually update the comments area w/ ajax
        var allPosts = document
                          .getElementById("main-feed")
                          .getElementsByClassName("feed-item");
        for (var i = 0 ; i < allPosts.length ; i++) {
          if (allPosts[i] === clickedPost) {
            allPosts[i].style.background = "linear-gradient(to right, white, #f0f0f0)";
            allPosts[i].style.marginRight = "-3px";
          } else {
            allPosts[i].style = null;
          }
        }
      }
      
      var feed = document.getElementById("main-feed");
      var posts = feed.getElementsByClassName("feed-item");
      for (var i = 0 ; i < posts.length ; i++) {
        posts[i].onclick = function() {
          showComments(this);
          return false;
        }
        posts[i].onfocus = function() {
          showComments(this);
          return false;
        }
      }
    </script>
  </body>
</html>
