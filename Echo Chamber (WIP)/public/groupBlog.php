<?php
session_start();

include("../includes/connect.php");
include("../includes/functions.php");
$LoggedUserID = $_SESSION["LoggedUserID"];
$userID = $_SESSION["LoggedUserID"];
$user = getUsernameFromID($LoggedUserID, $link);
$FriendUserID = $_SESSION["FriendUserID"];
$groupID = $_POST['GroupID'];
$groupName = getCircleNameFromID($groupID, $link);

// Check if they have just joined the group
if (isset($_POST['join'])) {
  unset($_POST['join']);
  insertGroupMembers($groupID, array($LoggedUserID), $link);
}

// Check if they have just left the group
if (isset($_POST['leave'])) {
  unset($_POST['leave']);
  $leave_group_sql = "DELETE FROM group_members WHERE GroupID = $groupID AND UserID = $LoggedUserID";
  $link->query($leave_group_sql);
}
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $groupName; ?></title>

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
        

        <!-- Content area -->
        <div class="row">

          <!-- Main area (posts, photos etc) -->
          <div class="col-sm-10 col-sm-offset-1" id="main-feed">

            
            
            
            

            <h3><?php echo $groupName; ?></h3>

            <!-- Check Privacy and show join/leave button -->
            <?php
            $group_privacy = getGroupPrivacySettings($groupID, $link);
            $groupMembers = getCircleMemberIDs($groupID, $link);
            $users_friends = getFriendsArr($LoggedUserID, $link);
            $users_friends_of_friends = getFriendsOfFriends($LoggedUserID, $link);
            $friends_in_group = FALSE;
            foreach ($users_friends as $friend) {
              if (in_array($friend, $groupMembers)) {
                $friends_in_group = TRUE;
                break;
              }
            }
            $fof_in_group = FALSE;
            foreach ($users_friends_of_friends as $friend) {
              if (in_array($friend, $groupMembers)) {
                $fof_in_group = TRUE;
                break;
              }
            }
            if (in_array($LoggedUserID, $groupMembers)) {
              // If they're a member, show a leave group button
              ?>
            <form method="post">
              <input type="hidden" value="<?php echo $groupID; ?>" name="GroupID">
              <input type="submit" class="btn btn-default" name="leave" value="Leave Group">
            </form>
              <?php
            } elseif (
              ($group_privacy == "Friends" && $friends_in_group)
              || ($group_privacy == "FriendsOfFriends" && $fof_in_group)){
              // Show a join group button
              ?>
            <form method="post">
              <input type="hidden" value="<?php echo $groupID; ?>" name="GroupID">
              <input type="submit" class="btn btn-default" name="join" value="Join Group">
            </form>
              <?php
            } else {
              // Tell them they can't join
              ?>
            <p>Sorry, you're not allowed to join this group</p>
              <?php
            }
            ?>

           <h4>Members:</h4>


<?php

for ($i = 0 ; $i < sizeof($groupMembers) ; $i++) {
  // Show each group member
  $userID = $groupMembers[$i];
  
  ?>
  <div class="feed-item">
    <form action="../process/processSeeFriend.php" method="post">
      <input type="hidden" name="friendID" value="<?php echo $userID; ?>">
      <button type="submit" class="profile-link"><b><?php echo getUsernameFromID($userID, $link); ?></b></button>
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

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    
    <!-- control active post -->
    <script src="../js/commentdisplay.js"></script>

  </body>
</html>
