<?php
// INSERT FUNCTIONS
// inserts new chat into the chat table and 
function createNewChat($chatName, $conn) {
    $chatID = 0;
    $insertChat = "INSERT into chat (ChatTitle) VALUES ('{$chatName}')";
    
    if($conn -> query($insertChat) === TRUE) {
        echo "New chat inserted into chat table successfully <br>";
        $chatID = mysqli_insert_id($conn);
    } else {
        echo "Error: ". $insertChat. "<br>" . $conn->error;
    }
    return $chatID;
}

// inserts members of specified chat ID into chat_members table, WHERE $chatMemberIDs is an array
function insertChatMembers($chatID, $chatMemberIDs, $conn) {
    for($i=0; $i<count($chatMemberIDs); $i++) {
        $insertChatMembers = "INSERT INTO chat_members (ChatID, UserID) VALUES ({$chatID}, {$chatMemberIDs[$i]})";
        
        if($conn -> query($insertChatMembers) === TRUE) {
            echo "Chat members inserted into chat_members successfully <br>";
        } else { 
            echo "Error: " .$insertChatMembers . "<br>" . $conn->error;
        }
    }
}

// inserts an album into the albums table and returns the albumID
function insertAlbum($albumName, $ownerID, $privacy, $conn) {
    $albumID = null;
    
    $insertAlbum = "INSERT INTO albums (AlbumName, OwnerID, Privacy) VALUE ('{$albumName}', {$ownerID}, '{$privacy}')";
    
    if($conn -> query($insertAlbum) === TRUE) {
        echo "New album inserted into albums successfully <br>";
        $albumID = mysqli_insert_id($conn);
    } else {
        echo "Error: ". $insertAlbum. "<br>". $conn->error;
    }
    return $albumID;
}

// Inserts message into message table
function insertMessage($ChatID, $UserID, $MsgContent, $MsgPic, $conn) {
    $messageInsert = "INSERT INTO message (ChatID, UserID, Text, Photo) VALUE ({$ChatID}, {$UserID}, '{$MsgContent}', '{$MsgPic}')";

    if ($conn -> query($messageInsert) === TRUE) {
        echo "Message inserted into messages successfully";
    } else {
        echo "Error: ". $messageInsert . "<br>" . $conn->error;
    }
}

// Inserts new entry into groups table
function insertGroup ($groupName, $groupPicID, $groupPrivacy, $conn) {
    $groupID = null;

    $insertGroup = "INSERT INTO groups (Name, PictureID, Privacy) VALUE ('{$groupName}', {$groupPicID},'{$groupPrivacy}')";
    
    if($conn -> query($insertGroup) === TRUE) {
        echo "New circle inserted into groups sucessfully <br>";
        $groupID = mysqli_insert_id($conn);
        //echo "New group id: " . $groupID . "<br>";
    } else {
        echo "Error: ". $insertGroup. "<br>". $conn->error;
    }
    return $groupID;
}


// Inserts group members into group_members table
function insertGroupMembers ($idGroup, $groupMembers, $conn) {
    for($i = 0; $i < count ($groupMembers); $i++) {
        $insertGroupMembers = "INSERT INTO group_members(GroupID, UserID) VALUE ({$idGroup}, {$groupMembers[$i]})";
        
        if ($conn -> query($insertGroupMembers) === TRUE) {
        } else {
            echo "Error: ". $insertGroupMembers . "<br>" . $conn->error;
        }
    }
}

// FUNCTIONS TO GET NAME FROM ID

// Gets the username corresponding to the user ID given
function getUsernameFromID($idUser, $conn) {
    $username = null;
    
    $selectUsername = "SELECT Username FROM users WHERE UserID = {$idUser}";
    
    $usernameResult = mysqli_query($conn, $selectUsername);
    
    if(mysqli_num_rows($usernameResult) > 0) {
        while($row = mysqli_fetch_assoc($usernameResult)) {
            $username = $row["Username"];
        }
    }
    return $username;
}

// gets an album name from its ID
function getAlbumNameFromID($albumID, $conn) {
    $albumName = null;
    
    $selectAlbumName = "SELECT AlbumName FROM albums WHERE AlbumID = {$albumID}";
    
    $albumNameResult = mysqli_query($conn, $selectAlbumName);
    
    if(mysqli_num_rows($albumNameResult) >0) {
        while($row = mysqli_fetch_assoc($albumNameResult)) {
            $albumName = $row["AlbumName"];
        }
    }
    return $albumName;
}

// Get album name from album ID - UNUSED
/*function getAlbumName($albumID, $conn) {
    $albumName = null;
    $selectAlbumName = "SELECT AlbumName FROM albums WHERE albumID = '{$albumID}'";
    
    $albumNameResult = mysqli_query($conn, $selectAlbumName);
    
    if(mysqli_num_rows($albumNameResult) >0) {
        $row = mysqli_fetch_assoc($albumNameResult);
        $albumName = $row["AlbumName"];
    }
    return $albumName;
}*/

// gets the name of a chat from its ID
function getChatNameFromID($chatID, $conn) {
    $chatName = null;
    
    $selectChatName = "SELECT ChatTitle FROM chat WHERE ChatID = {$chatID}";
    
    $chatNameResult = mysqli_query($conn, $selectChatName);
    
    if(mysqli_num_rows($chatNameResult) > 0) {
        while($row = mysqli_fetch_assoc($chatNameResult)) {
            $chatName = $row["ChatTitle"];
        }
    }
    return $chatName;
}



// gets circle name from its ID
function getCircleNamefromID($circleID, $conn) {
    $circleName = null;
    $getCircleNames = "SELECT Name FROM groups WHERE GroupID = {$circleID}";
    
    $circleNameResult = mysqli_query($conn, $getCircleNames);
    
    if (mysqli_num_rows($circleNameResult) > 0) {
        while ($row = mysqli_fetch_assoc($circleNameResult)) {
            $circleName = $row["Name"];
        }
    }
    return $circleName;
}

// used within another function
function getImagePathFromID($imageID, $conn) {
    $imagePath = null;
    $selectImagePath = "SELECT Picture FROM pictures WHERE PictureID = {$imageID}";
    
    $imagePathResult = mysqli_query($conn, $selectImagePath);
    
    if(mysqli_num_rows($imagePathResult) > 0) {
        while($row = mysqli_fetch_assoc($imagePathResult)) {
            $imagePath = $row["Picture"];
        }
    }
    return $imagePath;
}

// FUNCTIONS TO GET USER FRIENDS, CIRCLES, ETC
// selects all friends of the specified user and returns and array of the user IDs of these friends
function getFriendIDs($idUser, $conn) {
    $friendArray = array();
    $i = 0;
    
    $selectFriends = "SELECT friendships.UserTwo FROM friendships, users WHERE friendships.UserOne = {$idUser} AND users.UserID = friendships.UserTwo";
    
    $friendsResult = mysqli_query($conn, $selectFriends);
    
    if (mysqli_num_rows($friendsResult) > 0) {
        while ($row = mysqli_fetch_assoc($friendsResult)) {
            $friendArray[$i] = $row["UserTwo"];
            $i++;
        }
    }
    return $friendArray;
}

// Lists all friends of user with id $idUser
function getFriends($idUser, $conn) {
    $selectFriends = "SELECT friendships.UserTwo, users.Username FROM friendships, users WHERE friendships.UserOne = {$idUser} AND users.UserID = friendships.UserTwo";
    
    $friendsResult = mysqli_query($conn, $selectFriends);
    
    if (mysqli_num_rows($friendsResult) > 0) {
        while ($row = mysqli_fetch_assoc($friendsResult)) {
             echo "<input type=\"checkbox\" name=\"circleMember[]\" value=\" " . $row["UserTwo"] . "\">" . $row["Username"] . "<br>";
        }
    }
}


// gets the circles the user belongs to and returns an array of their IDs
function getUserCircleIDs($userID, $conn) {
    $circleArray = array();
    $i = 0;
    
    $getCircles = "SELECT GroupID FROM group_members WHERE UserID = {$userID}";
    
    $circlesResult = mysqli_query($conn, $getCircles);
    
    if (mysqli_num_rows($circlesResult) > 0) {
        while ($row = mysqli_fetch_assoc($circlesResult)) {
            $circleArray[$i] = $row["GroupID"];
            $i++;
        }
    }
    return $circleArray;
}

// gets all albums belonging to user with $userID, and echoes a combo box containing these albums
function getUserAlbumsCB($userID, $conn) {

    $selectAlbums = "SELECT AlbumName FROM albums WHERE OwnerID = {$userID}";
    
    $albumsResult = mysqli_query($conn, $selectAlbums);

    if(mysqli_num_rows($albumsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumsResult)) {
            echo "<option value = \"". $row["AlbumName"] . "\">" . $row["AlbumName"] . "</option>";
        }
    } else {
        echo "No albums yet.";
    }
    
}

// gets the chats the user currently belongs to and returns an array of the IDs of these chats
function getUserChatIDs($userID, $conn) {
    $chatArray = array();
    $i=0;
    
    $selectChats = "SELECT ChatID FROM chat_members WHERE UserID = {$userID}";
    
    $chatResult = mysqli_query($conn, $selectChats);
    
    if(mysqli_num_rows($chatResult) > 0) {
        while ($row = mysqli_fetch_assoc($chatResult)) {
           $chatArray[$i] = $row["ChatID"];
           $i++;
        }
    }
    return $chatArray;
}

// gets Album IDs for users albums - NOT USED
/*function getUserAlbumIDs($userID, $conn) {
    $userAlbumArray = array();
    $i = 0;
    
    $selectAlbums = "SELECT AlbumID FROM albums WHERE OwnerID = {$userID}";

    $albumsResult = mysqli_query($conn, $selectAlbums);
    
    if(mysqli_num_rows($albumsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumsResult)) {
            $userAlbumArray[$i] = $row["AlbumID"];
            $i++;
        }
    }
    return $userAlbumArray;
}*/

// gets all the circles the specified user belongs to displays them as links (to the circle blog or profile page - tbc) onto the page
function getCircles($idUser, $conn) {

    $getCircles = "SELECT groups.Name FROM groups, users WHERE users.UserID = {$idUser}";
    
    $circlesResult = mysqli_query($conn, $getCircles);
    
    if (mysqli_num_rows($circlesResult) > 0) {
        while ($row = mysqli_fetch_assoc($circlesResult)) {
            echo "<a href = \"completeLater.php\">" . $row["Name"] . "</a> <br>";
        }
    }
}

// -- NOT USED --//
/*function getUserAlbumBtns($userID, $conn) {
    $selectAlbums = "SELECT AlbumName, AlbumID FROM albums WHERE OwnerID = {$userID}";

    $albumsResult = mysqli_query($conn, $selectAlbums);
    
     echo "<button type = \"submit\" value= \"allAlbums\"> All Albums </button>";

    if(mysqli_num_rows($albumsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumsResult)) {
        
            echo "<button type = \"submit\" value= \"" . $row["AlbumID"] . "\" name=\"albumID\"> ". $row["AlbumName"] . "</button>";
        }
    } else {
        echo "No albums yet.";
    }
}*/

// -- NOT USED -- //
/*function displayAllUserPhotos($userID, $conn) {
    $selectAllPics = "SELECT pictures.Picture, pictures.AlbumID, pictures.PictureID FROM pictures, albums WHERE pictures.AlbumID = albums.AlbumID AND albums.OwnerID = {$userID}";
    
    $allPicsResult = mysqli_query($conn, $selectAllPics);
    
    $i=1;
    
    if(mysqli_num_rows($allPicsResult) > 0) {
        while($row = mysqli_fetch_assoc($allPicsResult)) {
            echo "<img src = \"../process/" . $row["Picture"] . "\" width=\"200\" height=\"200\" id=\"" . $row["PictureID"] . "\"> <br>";
            printComments($row["PictureID"], $conn);
            printCommentForm($row["PictureID"], $i);
            $i++;
        }
    }
}*/

function displayAlbumPhotos($albumID, $conn) {
    $selectAlbumPics = "SELECT pictures.Picture, pictures.PictureID FROM pictures WHERE pictures.AlbumID = {$albumID}";
    
    $albumPicsResult = mysqli_query($conn, $selectAlbumPics);
    $i=1;
    if(mysqli_num_rows($albumPicsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumPicsResult)) {
            echo "<img src = \"" . $row["Picture"] . "\" class=\"feed-photo\"> <br>";
            printComments($row["PictureID"], $conn);
            printCommentForm($row["PictureID"], $i);
            $i++;
        }
    }
}

// FUNCTIONS TO GET ID FROM OTHER INFO

// get album id from name
function getAlbumIDFromName($albumName, $ownerID, $conn) {
    $albumID = null;
    
    $selectAlbumName = "SELECT AlbumID FROM albums WHERE AlbumName = '{$albumName}' AND OwnerID = {$ownerID}";
    
    $selectNameResult = mysqli_query($conn, $selectAlbumName);
    
    if(mysqli_num_rows($selectNameResult)>0) {
        while($row = mysqli_fetch_assoc($selectNameResult)) {
            $albumID = $row["AlbumID"];
        }
    }
    return $albumID;
}

// FUNCTIONS TO CHECK FOR EXISTENCE

// checks if user already has an album of the specified name
function doesAlbumNameExist($albumName, $ownerID, $conn) {
    $albumState = false;
    $selectAlbum = "SELECT AlbumName FROM albums WHERE AlbumName = '{$albumName}' AND OwnerID = {$ownerID}";
    
    $selectAlbumResult = mysqli_query($conn, $selectAlbum);
    
    if(mysqli_num_rows($selectAlbumResult) > 0) {
        $albumState = true;
    } else {
        $albumState = false;
    }
    return $albumState;
}

// FUNCTIONS TO GET NON-USER SPECIFIC INFO
// gets all public circles
function getPublicCircles($conn) {
    $getPublicCircles = "SELECT Name FROM groups WHERE Privacy = 'Public'";
    
    $publicCirclesResult = mysqli_query($conn, $getPublicCircles);
    
    if (mysqli_num_rows($publicCirclesResult) > 0) {
        while ($row = mysqli_fetch_assoc($publicCirclesResult)) {
            echo "<a href = \"completeLater.php\">" . $row["Name"] . "</a> <br>";
        }
    }
    
}

function printComments($picID, $conn) {
    $selectComments = "SELECT comments.Time, comments.Text, users.Username FROM comments, users WHERE comments.UserID = users.UserID AND comments.PostID = {$picID}";
    
    $commentsResult = mysqli_query($conn, $selectComments);
    
    if(mysqli_num_rows($commentsResult) > 0) {
        while($row = mysqli_fetch_assoc($commentsResult)) {
            ?>
          <div class="comment">
            <p><b><?php echo $row["Username"]; ?></b></p>
            <p><?php echo $row["Text"]; ?></p>
            <p><?php echo $row["Time"]; ?></p>
          </div>
            <?php
        }
    }
}

function printCommentForm($picID, $i) { 
    echo "<form action = \"../process/processComment.php\" method = \"post\" id=\"commentForm" . $i . "\">";

    echo "<textarea name = \"comment\" form=\"commentForm" . $i . "\" placeholder=\"Write your comment here\"></textarea><br>";
    
    echo "<input type = \"hidden\" name = \"picID\" value = ". $picID ." \">";

    echo "<input type = \"submit\" class=\"btn btn-default\">";
    echo "</form>";
}


// gets the user IDs of the members of the specified circle ID (an array) and returns an array of these IDs
function getCircleMemberIDs($circleIDs, $conn) {
    $circleMembers = array();
    
    if (gettype($circleIDs) == gettype(array())) {
        foreach ($circleIDs as $circleID) {
            $selectCircleIDs = "SELECT UserID FROM group_members WHERE GroupID = {$circleID}";

            $circleIDsResult = mysqli_query($conn, $selectCircleIDs);

            while($row = mysqli_fetch_assoc($circleIDsResult)) {
                $circleMembers[] = $row["UserID"];
            }
        }
    } else {
        $circleID = $circleIDs;
        $selectCircleIDs = "SELECT UserID FROM group_members WHERE GroupID = {$circleID}"; 

        $circleIDsResult = mysqli_query($conn, $selectCircleIDs);

        while($row = mysqli_fetch_assoc($circleIDsResult)) {
            $circleMembers[] = $row["UserID"];
        }
    }

    return $circleMembers;
}

// returns an array of all members of a chat, both individual members and those of any circles included in the chat
function combineAllChatMembers($indIDs, $circleIDs, $userID) {
    $chatMembers = array();
    $i = 0;
    
    // Insert individuals into $chatMembers array
    for($i=0; $i<count($indIDs); $i++) {
        $chatMembers[$i] = $indIDs[$i];
    }
    echo "Value of counter: " . $i . "<br>";
    
    echo "Chat members after inserting individual: <br>";
    print_r($chatMembers);
    echo "<br>";
    
    // Insert members of circle into chat members array
    for($j=0; $j<count($circleIDs); $j++) {
        if(!(in_array($circleIDs[$j], $chatMembers))){
        $chatMembers[$i] = $circleIDs[$j];
        $i++;
        }
    }
    
    echo "Value of counter: " . $i . "<br>";
    
    echo "Chat Members after inserting groups: <br>";
    print_r($chatMembers);
    echo "<br>";
    
    // Insert user into chat members array
    if (!(in_array($userID, $chatMembers))) {
        $chatMembers[$i] = $userID;
    }
    
    echo "Chat Members after inserting user <br>";
    print_r($chatMembers);
    echo "<br>";

    return $chatMembers;
}




// FUNCTIONS TO UPLOAD AN IMAGE (TO BE REWRITTEN)

// Gets extension of uploaded image -- used within another function
function GetImageExtension($imagetype) {
    if(empty($imagetype)) return false;
    switch($imagetype) {
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}


// inserts an uploaded image into the pictures table
function insertImageNew($albumID, $uploadName, $conn) {
    $imageID = 0;
        
    if (!empty($_FILES[$uploadName]["name"])) {

        $file_name=$_FILES[$uploadName]["name"];
        $tempName=$_FILES[$uploadName]["tmp_name"];
        $tempName=$_FILES[$uploadName]["tmp_name"];
        $imgtype=$_FILES[$uploadName]["type"];
        $ext= GetImageExtension($imgtype);
        $imagename= $_FILES[$uploadName]["name"];
        $targetPath = "../public/images/".$imagename;
        //echo $targetPath . "<br>";
    
        // uploades image
        if(move_uploaded_file($tempName, $targetPath)) {
            $insertImage = "INSERT INTO pictures (Picture, AlbumID) VALUE ('{$targetPath}', {$albumID})";

            if($conn-> query($insertImage) === TRUE) {
                echo "New image successfullly inserted into pictures <br>";
                $imageID = mysqli_insert_id($conn);
            } else {
                echo "Error: ". $insertImage. "<br>". $conn->error;
            }
        } else {
            exit("Error while uplaoding image on server");
        }
    }
    return $imageID;
}
    
// -- NOT USED - replaced by insertImageNew() -- //
/* function insertImagePlus($albumID, $conn) {
    $imageID = null;
    $tempName = getTempName();
    echo $tempName;
    $targetPath = getTargetPath();
    echo $targetPath;
    
    if(move_uploaded_file($tempName, $targetPath)) {
        $imageID = insertImage($targetPath, $albumID, $conn);
    } else {
        exit("Error while uplaoding image on server");
    }
    return $imageID;
}*/

// -- NOT USED - replaced by insertImageNew() --//
// inserts an image into the pictures table and returns the PictureID
/*function insertImage($imagePath, $albumID, $conn) {
    $imageID = null;
    
    $insertImage = "INSERT INTO pictures (Picture, AlbumID) VALUE ('{$imagePath}', {$albumID})";
    
    if($conn-> query($insertImage) === TRUE) {
        echo "New image successfullly inserted into pictures <br>";
        $imageID = mysqli_insert_id($conn);
    } else {
        echo "Error: ". $insertImage. "<br>". $conn->error;
    }
    return $imageID;
}*/

// -- NOT USED - replaced by insertImageNew() --//
// gets the target path of an uploaded image
/*function getTargetPath() {
    $targetPath = null;
    if (!empty($_FILES["uploadedimage"]["name"])) {

        $file_name=$_FILES["uploadedimage"]["name"];
        echo $file_name . "<br>";
        $tempName=$_FILES["uploadedimage"]["tmp_name"];
        $imgtype=$_FILES["uploadedimage"]["type"];
        $ext= GetImageExtension($imgtype);
        $imagename= $_FILES["uploadedimage"]["name"];
        $targetPath = "images/".$imagename;
        echo $targetPath . "<br>";
    }
    return $targetPath;
}*/

// -- NOT USED -- replaced by insertImageNew() --//
// get the temp name of the uploaded image
function getTempName() {
    $tempName = null;
    if (!empty($_FILES["uploadedimage"]["name"])) {
        $tempName=$_FILES["uploadedimage"]["tmp_name"];
    }
    echo $tempName;
    return $tempName;
}

// Displays all members of the chat with specified id 
function displayChatMembers($IDforChat, $userID, $conn) {

    $selectChatMembers = "SELECT users.UserName, users.UserID, chat_members.ChatID FROM users, chat_members WHERE chat_members.ChatID = {$IDforChat} AND users.UserID = chat_members.UserID";
    
    $chatMembersResult = mysqli_query($conn, $selectChatMembers);
    
    if(mysqli_num_rows($chatMembersResult) > 0) {
        while($row = mysqli_fetch_assoc($chatMembersResult)) {
            if($row["UserID"] != $userID) {
              ?>
              <form action="../process/processSeeFriend.php" method="post">
                <input type="hidden" name="friendID" value="<?php echo $row["UserID"]; ?>">
                <button type="submit" class="profile-link" style="display: inline"><b><?php echo $row['UserName']; ?></b></button>
              </form>
              <?php
            }
        }
    }
}

// Retrieves messsages for chat id specified 
function retrieveMessages($idChat, $conn) {
    $msgArray = array();
    $i = 0;

    $selectMsgs = "SELECT UserID, Text, Photo, DateTime FROM message WHERE ChatID = {$idChat} ORDER BY DateTime DESC";
    
    $msgsResult = mysqli_query($conn, $selectMsgs);
    
    if(mysqli_num_rows($msgsResult) > 0) {
        while($row = mysqli_fetch_assoc($msgsResult)) {
          ?>
          <div class="feed-item">
            <p><b><?php echo getUsernameFromID($row["UserID"], $conn); ?></b></p>
            <p><?php echo $row["Text"]; ?></p>
            <p><?php echo $row["DateTime"]; ?></p>
          <?php
            
            if($row["Photo"] != null) {
                echo "<img src = \"../process/" . getImagePathFromID($row["Photo"], $conn) . "\" width=\"200\" height=\"200\"> <br>";
            }
            ?>
            </div>
            <?php
        }
    }
    //print_r($msgArray);
    return $msgArray;
}

function getAllUsers($conn) {
    $allUsersArr= array();
    $i = 0;
    
    $allUsers = "SELECT UserID FROM users";
    $result = mysqli_query($conn, $allUsers);
    
    if(mysqli_num_rows($result)>0) {
        while($row = mysqli_fetch_assoc($result)) {
            $allUsersArr[$i] = $row["UserID"];
            $i++;
        }
    }
    //print_r($allUsersArr);
    return $allUsersArr;
}

// returns an array containing the album IDs of the specified user
function getUserAlbumsArr($userID, $conn) {
    $userAlbums = array();
    $i=0;
    
    $stmt = $conn->prepare("SELECT AlbumID FROM albums WHERE OwnerID = ?");
    $stmt->bind_param("i", $userID);
    
    if($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $userAlbums[$i] = $row['AlbumID'];
            $i++;
        }
    }
    return $userAlbums;
}

/*
Takes a blogID and returns its privacy level
*/
function getBlogPrivacySettings($blogID, $link) {
  $sql = "SELECT Privacy FROM blog_wall WHERE BlogID = $blogID";
  $result = $link->query($sql);
  return $result->fetch_assoc()['Privacy'];
}

function getAlbumPrivacySettings($albumID, $conn) {
    $privacy = null;
    
    $stmt = $conn->prepare("SELECT Privacy FROM albums WHERE AlbumID = ?");
    $stmt->bind_param("i", $albumID);
    
    if($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result) >0) {
            $row = mysqli_fetch_assoc($result);
            $privacy = $row["Privacy"];
        }
    } else {
        echo "Error: ". $stmt. "<br>" . $conn->error;
    }
    return $privacy;
}

function getGroupPrivacySettings($groupID, $link) {
  $sql = "SELECT Privacy FROM groups WHERE GroupID = $groupID";
  $result = $link->query($sql);
  if ($row = $result->fetch_assoc()) {
    return $row['Privacy'];
  }
}

// gets Album IDs for users albums
function getAccessibleAlbumIDs($loggedUser, $pageOwner, $conn) {
    $albumArray = array();
    $i = 0;

    // check user relationship
    $isPageOwner = isPageOwner($loggedUser, $pageOwner, $conn);
    //echo "page owner: " . $isPageOwner . "<br>";
    $isFriends = isFriends($loggedUser, $pageOwner, $conn);
   // echo "is friends: " . $isPageOwner . "<br>";
    $isFriendOfFriend = isFriendOfFriend($loggedUser, $pageOwner, $conn);
    //echo "isFriendOfFriend" . $isFriendOfFriend . "<br>";
    $inSameCircle = inSameCircle($loggedUser, $pageOwner, $conn);
    
    $selectAlbums = "SELECT AlbumID, Privacy FROM albums WHERE OwnerID = {$pageOwner}";
    
    $albumsResult = mysqli_query($conn, $selectAlbums);
    
    if(mysqli_num_rows($albumsResult)>0) {
        while($row= mysqli_fetch_assoc($albumsResult)) {
        
            //echo "Album privacy: " . $row["Privacy"] . "<br>";
            if(($isPageOwner == 1) 
                || (($row["Privacy"] == "Circles") && ($inSameCircle == 1))
                || (($row["Privacy"] == "FriendsOfFriends") && (($isFriendOfFriend == 1)|| ($isFriends == 1)))
                || (($row["Privacy"] == "Friends") && ($isFriends == 1))
                || ($row["Privacy"] == "Public")){
                    
                $albumArray[$i] = $row["AlbumID"];
                $i++;
                //echo "AlbumID added to album <br>";
            } else {
               // $i++;
            }
        }
    }
    //echo "Accessible albums: <br>";
    //print_r($albumArray);
    //echo "<br>";
    return $albumArray;
}

function displayAllAccessiblePhotos($loggedUser, $pageOwner, $conn) {
    $i = 0;

    // checks relationship between users
    $isPageOwner = isPageOwner($loggedUser, $pageOwner, $conn);
    //echo "page owner: " . $isPageOwner . "<br>";
    $isFriends = isFriends($loggedUser, $pageOwner, $conn);
    //echo "is friends: " . $isPageOwner . "<br>";
    $isFriendOfFriend = isFriendOfFriend($loggedUser, $pageOwner, $conn);
    //echo "isFriendOfFriend" . $isFriendOfFriend . "<br>";
    $inSameCirlce = inSameCircle($loggedUser, $pageOwner, $conn);

    // gets pics from db
    $selectAllPics = "SELECT pictures.Picture, pictures.AlbumID, pictures.PictureID, albums.Privacy FROM pictures, albums WHERE pictures.AlbumID = albums.AlbumID AND albums.OwnerID = {$pageOwner}";

    $allPicsResult = mysqli_query($conn, $selectAllPics);
    
    if(mysqli_num_rows($allPicsResult) > 0) {
        while($row = mysqli_fetch_assoc($allPicsResult)) {
             if(($isPageOwner == 1) 
                || ($row["Privacy"] == "Public") 
                || (($row["Privacy"] == "Friends") AND ($isFriends == 1))
                || (($row["Privacy"] == "FriendsOfFriends") && ($isFriendOfFriend == 1))
                || (($row["Privacy"] == "Circle") && ($inSameCircle == 1))) {
               
                        ?>
                        <div class="feed-item">
                          <img src ="<?php echo $row["Picture"]; ?>" id="<?php echo $row["PictureID"]; ?>" class="feed-photo">
                        <?php
                        printComments($row["PictureID"], $conn);
                        printCommentForm($row["PictureID"], $i);
                        echo "</div>";
                        $i++;
            }
        }
    }
}

function insertComment($userID, $commentText, $postID, $conn) {
    $insertComment = "INSERT INTO comments (Text, UserID, PostID) VALUES ('{$commentText}', {$userID}, {$postID})";

    if ($conn -> query($insertComment) === TRUE) {
        echo "Inserted comment text and userID into comments table successfully";

    } else {
        echo "Error: ". $insertComment . "<br>" . $conn->error;
    }
}
// creates new blog for user or group
function createBlog($privacy, $ownerID, $conn) {
    
    $insertBlog = "INSERT INTO blog_wall (Privacy, OwnerID) VALUES ('{$privacy}', {$ownerID})";
    
     if ($conn -> query($insertBlog) === TRUE) {
        echo "Message inserted into messages successfully <br>";
    } else {
        echo "Error: ". $insertBlog . "<br>" . $conn->error;
    }
}

// inserts user into users table
function createUser($username, $hash, $email, $birthday, $picID, $conn) {
    $userID = 0;
    $stmt = $conn->prepare("INSERT INTO users (Username, Password, Email, Birthday, PictureID) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $username, $hash, $email, $birthday, $picID);

    if ($stmt->execute() === TRUE) {
            echo "Record inserted into users successfully <br>";
            $userID = mysqli_insert_id($conn);
            echo "New user has id: {$userID} <br>" ;
        } else {
            echo "Error: ". $stmt . "<br>" . $conn->error;
     }
     return $userID;
}

// updates id of user profile pic
function updateUsrPicID($userID, $picID, $conn) {

    $stmt = $conn->prepare("UPDATE users SET PictureID = ? WHERE UserID = ?");
    $stmt->bind_param("ii", $picID, $userID);
    
    
    if($stmt->execute() === TRUE) {
        echo "User picID successfully updated <br>";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}

function deleteAlbum($albumID, $conn) {

    // delete all images in specified album (i.e. delete all images from pictures with album ID specified)
    $deleteImg = $conn->prepare("DELETE FROM pictures WHERE AlbumID = ?");
    $deleteImg->bind_param("i", $albumID);
    
    if ($deleteImg->execute() === TRUE) {
            echo "Pictures from {$albumID} successfully deleted from pictures <br>";
        } else {
            echo "Error: ". $deleteImg . "<br>" . $conn->error;
     }
     
    // deletes album of specified ID from albums
    $stmt = $conn->prepare("DELETE FROM albums WHERE AlbumID = ?");
    $stmt->bind_param("i", $albumID);
    
    if ($stmt->execute() === TRUE) {
            echo "Album {$albumID} successfully deleted from albums <br>";
        } else {
            echo "Error: ". $stmt . "<br>" . $conn->error;
     }
}

// updatees the new of an album
function updateAlbumName($albumID, $newAlbumName, $conn) {
    $stmt = $conn->prepare("UPDATE albums SET AlbumName = ? WHERE AlbumID = ?");
    $stmt->bind_param("si", $newAlbumName, $albumID);
    
    if($stmt->execute() === TRUE) {
        echo "Album name for {$albumID} successfully changed";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}

// updates the privacy value of an album
function updateAlbumPrivacy($albumID, $newPrivacy, $conn) {

    $stmt = $conn->prepare("UPDATE albums SET Privacy = ? WHERE AlbumID = ?");
    $stmt->bind_param("si", $newPrivacy, $albumID);
    
    if($stmt->execute() === TRUE) {
        echo "Privacy of album {$albumID} successfully updated <br>";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }
}


// Gets friends of friends of user of specified ID and returns an array of user IDs of these friends of friends
function getFriendsOfFriends($userID, $conn) {
    $friendsOfFriends = array();
    $j= 0;
    
    $friends = getFriendsArr($userID, $conn);

    for($i=0; $i<count($friends); $i++) {
        $selectFOfF = "SELECT UserTwo FROM friendships WHERE UserOne = {$friends[$i]}";
        
        $fOfFResult = mysqli_query($conn, $selectFOfF);
        
        if(mysqli_num_rows($fOfFResult) > 0) {
            while($row=mysqli_fetch_assoc($fOfFResult)) {
                $friendsOfFriends[$j] = $row["UserTwo"];
                $j++;
            }
        }
    }
    //echo "Friends of friends: <br>";
    //print_r($friendsOfFriends);
    //echo "<br>";
    return $friendsOfFriends;
}

// Gets all friends of user of specified ID and returns an array of the user IDs of these friends
function getFriendsArr($userID, $conn) {
    $friendsArray = array();
    $i = 0;

    $selectFriends = "SELECT friendships.UserTwo, users.Username FROM friendships, users WHERE friendships.UserOne = {$userID} AND users.UserID = friendships.UserTwo";
    
    $friendsResult = mysqli_query($conn, $selectFriends);
    
    if(mysqli_num_rows($friendsResult) > 0) {
        while ($row = mysqli_fetch_assoc($friendsResult)) {
            $friendsArray[$i] = $row["UserTwo"];
            $i++;
        }
    }
    return $friendsArray;
}

function getFOfFCircles($userID, $conn) {
    $fOfFCirclesArr = array();
    $i = 0;
    
    // gets array of friends of friends of the user
    $friendsOfFriends = getFriendsOfFriends($userID, $conn);
    
    for($j=0; $j<count($friendsOfFriends); $j++) {
        // gets IDs of circles of each friend of friends
        $fOfFCircles = getUserCircleIDs($friendsOfFriends[$j], $conn);
        //echo "Friends of friends circles: <br>";
        //print_r($fOfFCircles);
        //echo "<br>";
        
        for($k=0; $k<count($fOfFCircles); $k++) {
        
            $getFFCircles = "SELECT GroupID FROM groups WHERE Privacy = 'FriendsOfFriends' AND GroupID = {$fOfFCircles[$k]}";
        
            $getFFCirclesResult = mysqli_query($conn, $getFFCircles);
        
            if(mysqli_num_rows($getFFCirclesResult) >0) {
                while ($row = mysqli_fetch_assoc($getFFCirclesResult)) {
                    if(!(in_array($row["GroupID"], $fOfFCirclesArr))){
                        $fOfFCirclesArr[$i] = $row["GroupID"];
                        $i++;
                    }
                }
            }
        }
    }
   // echo "Friends of friends circles <br>";
   // print_r($fOfFCirclesArr);
   // echo "<br>";
    return $fOfFCirclesArr;
}

function getFriendsCircles($userID, $conn) {
    $friendsCirclesArray = array();
    $i = 0;
    
    $friends = getFriendsArr($userID, $conn);
    //echo "User's friends: <br>";
    //print_r($friends);
    //echo "<br>";
    
    for($j=0; $j<count($friends); $j++) {
    
        $friendCircles = getUserCircleIDs($friends[$j], $conn);
        //echo "friend's circles {$j} <br>";
        //print_r($friendCircles);
        //echo "<br>";
        
        for($k=0; $k<count($friendCircles); $k++) {
        
            $getFriendCircles = "SELECT GroupID FROM groups WHERE Privacy = 'Friends' AND GroupID = {$friendCircles[$k]}";
            
            $result = mysqli_query($conn, $getFriendCircles);
            
            if(mysqli_num_rows($result) >0) {
                while($row = mysqli_fetch_assoc($result)) {
                    if(!(in_array($row["GroupID"], $friendsCirclesArray))){
                        $friendsCirclesArray[$i] = $row["GroupID"];
                        $i++;
                    }
                }
            }
        }
    }
    //echo "Arrays with privacy friends <br>";
    //print_r($friendsCirclesArray);
    //echo "<br>";
    return $friendsCirclesArray;  
}

// -- NOT SURE IF THIS IS USED --//
function getAllAccCircles($userID, $conn) {
    $allCircles = array();
    $i = 0;
    
    $friendsOfFriendsC = getFOfFCircles($userID, $conn);
    $friendsC = getFriendsCircles($userID, $conn);
    
    for($j=0; $j<count($friendsOfFriendsC); $j++) {
        $allCircles[$i] = $friendsOfFriendsC[$j];
        $i++;
    }
    
    for($k=0; $k<count($friendsC); $k++) {
        if(!(in_array($friendsC[$k], $allCircles))) {
            $allCircles[$i] = $friendsC[$k];
            $i++;
        }
    }
    //echo "All circles <br>";
    //print_r($allCircles);
   // echo "<br>";
    return $allCircles;
}

// =============FUNCTIONS CHECKING RELATIONSHIP BETWEEN USERS=================== //

function isFriends($loggedUser, $pageOwner, $conn) {
    $isFriends = false;
    $stmt = $conn->prepare("SELECT UserOne, UserTwo FROM friendships WHERE UserOne = ? AND UserTwo = ?");
    $stmt->bind_param("ii", $loggedUser, $pageOwner);
    
    if($stmt->execute()) {
        //echo "Query to friendships tables successfully performed <br>";
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result) <= 0) {
            $isFriends = false;
        } else{
            $isFriends = true;
        }
    }
    return $isFriends;
}

function inSameCircle($loggedUser, $pageOwner, $conn) {
    $inSameCircle = false;
    
    $loggedUserCircles = getUserCircleIDs($loggedUser, $conn);
    
    for($i=0; $i<count($loggedUserCircles); $i++) {
        $getMembers = "SELECT UserID FROM group_members WHERE GroupID = {$loggedUserCircles[$i]}";
        
        $result = mysqli_query($conn, $getMembers);
                
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                if($row["UserID"] == $pageOwner) {
                    $inSameCircle = true;
                    break;
                }
            }
        }
    }
    //cho "is in same circe?". $inSameCircle . "end <br>";
    return $inSameCircle;
}

function isPageOwner($loggedUser, $pageOwner) {
    $isPageOwner = false;
    if($loggedUser === $pageOwner) {
        $isPageOwner = true;
    }
    return $isPageOwner;
}

function isFriendOfFriend($loggedUser, $pageOwner, $conn) {
    $isFriendOfFriend = false;
    
    // returns an array of all friends of the logged user
    $loggedUserFriends = getFriendsArr($loggedUser, $conn);
    
    // runs through each friend of the friends in the logged user's friends
    for($i=0; $i<count($loggedUserFriends); $i++) {
        $selectFOfF = "SELECT UserTwo FROM friendships WHERE UserOne = {$loggedUserFriends[$i]}";
        
        $fOfResult = mysqli_query($conn, $selectFOfF);
        
        if(mysqli_num_rows($fOfResult) > 0) {
            while($row = mysqli_fetch_assoc($fOfResult)) {
                if($row["UserTwo"] === $pageOwner) {
                    $isFriendOfFriend = true;
                    break;
                }
            }
        }
    }
    return $isFriendOfFriend;
}

function getBlogID($ownerID, $isGroup, $conn) {
    $blogID = 0;
    
    $stmt=$conn->prepare("SELECT BlogID FROM blog_wall WHERE OwnerID = ?");
    $stmt->bind_param("i", $ownerID);
    
    if($stmt->execute()) {
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            $blogID = $row["BlogID"];
        }
    }
    return $blogID;
}
    
    
function updateBlogPrivacy($blogID, $newPrivacy, $conn) {

    $stmt=$conn->prepare("UPDATE blog_wall SET Privacy = ? WHERE BlogID = ?");
    $stmt->bind_param("si", $newPrivacy, $blogID);
    
    if($stmt->execute() === TRUE){
        echo "Privacy of blog {$blogID} successfully updated <br>";
    } else {
        echo "Error: ". $stmt. "<br>" . $conn->error;
    }
}

function updateEmail($userID, $newEmail, $conn) {

    $stmt=$conn->prepare("UPDATE users SET EMAIL = ? WHERE UserID = ?");
    $stmt->bind_param("si", $newEmail, $userID);
    
    if($stmt->execute() === TRUE) {
        echo "User email successfully updated <br>";
    } else {
        echo "Error: ". $stmt. "<br>". $conn->error;
    }
}

/*
Gets a list of UserIDs for recommended friends, ordered from best recommnedation to 
worst, based on the number of common sentiments, mutual friends, and common groups
between the user passed in, $user_id, and each user in the list.
*/
function getFriendRecommendations($user_id, $conn) {
  
  /*
  Gets a list of the users friends, and those with whom they have a pending
  friend request. Should be a shorter list to check than a list of non-friends,
  and thus better for performance at scale.
  */
  $friends_sql = "
      SELECT UserID FROM users 
          WHERE UserID = $user_id
          OR UserID IN
              (
              SELECT UserTwo FROM friendships
                  WHERE UserOne = $user_id
              )
          OR UserID IN
              (
              SELECT user_to FROM friend_requests
                  WHERE user_from = $user_id
              )";
  
  /*
  Gets an ordered list of users who are not the user's friend, and who
  share the same sentiment about the same entities
  */
  $common_sentiments_sql = "
      SELECT s2.UserID, COUNT(s1.EntityID) AS count FROM sentiments AS s1
          JOIN sentiments AS s2
          ON s1.EntityID = s2.EntityID
          WHERE s1.Sentiment = s2.Sentiment
          AND s1.UserID <> s2.UserID
          AND s1.UserID = $user_id
          AND s2.UserID NOT IN ($friends_sql)
          GROUP BY s2.UserID
          ORDER BY count DESC";
  
  $common_sentiments_result = $conn->query($common_sentiments_sql);
  
  /*
  Gets an ordered list of users who are not the user's friend, and who
  have mutual friends with the user
  */
  $mutual_friends_sql = "
      SELECT f2.UserTwo AS UserID, COUNT(f2.UserTwo) AS count FROM friendships AS f1
          JOIN friendships AS f2
          ON f1.UserTwo = f2.UserOne
          WHERE f1.UserOne = $user_id
          AND f1.UserOne <> f2.UserTwo
          AND f2.UserTwo NOT IN ($friends_sql)
          GROUP BY f2.UserTwo
          ORDER BY count";
  
  $mutual_friends_result = $conn->query($mutual_friends_sql);
  
  /*
  Gets an ordered list of users who are not the user's friend, and who
  are members of the same groups as the user
  */
  $common_circles_sql = "
      SELECT g2.UserID, COUNT(g2.UserID) AS count FROM group_members AS g1
          JOIN group_members AS g2
          ON g1.GroupID = g2.GroupID
          WHERE g1.UserID = $user_id
          AND g1.UserID <> g2.UserID
          AND g2.UserID NOT IN ($friends_sql)
          GROUP BY g2.UserID
          ORDER BY count DESC";
  
  $common_circles_result = $conn->query($common_circles_sql);
  
  /*
  Creates an array with UserIDs as keys, and a value representing how
  good a recommendation they are as values. These values are based on the
  number of common sentiments, mutual friends, and common circles.
  */
  $recommended_friends = array();
  // Add values for common entities
  if ($common_sentiments_result) {
    while ($row = $common_sentiments_result->fetch_assoc()) {
      $recommended_friends[$row['UserID']] = $row['count'] * 10;
    }
  }
  // Add values for mutual friends
  if ($mutual_friends_result) {
    while ($row = $mutual_friends_result->fetch_assoc()) {
      if (isset($recommended_friends[$row['UserID']])) {
        $recommended_friends[$row['UserID']] += $row['count'];
      } else {
        $recommended_friends[$row['UserID']] = $row['count'];
      }
    }
  }
  // Add values for common circles
  if ($common_circles_result) {
    while ($row = $common_circles_result->fetch_assoc()) {
      if (isset($recommended_friends[$row['UserID']])) {
        $recommended_friends[$row['UserID']] += $row['count'];
      } else {
        $recommended_friends[$row['UserID']] = $row['count'];
      }
    }
  }
  
  // Sort the array according to the final values
  arsort($recommended_friends);
  
  // Return the ordered list of UserIDs
  return array_keys($recommended_friends);
  
}

// returns path to user's profile picture
function getProfilePicPath($userID, $conn) {
    $imagePath = null;
    
    $getPicID = "SELECT PictureID FROM users WHERE UserID = {$userID}";
    
    $result = mysqli_query($conn, $getPicID);
    
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $picID = $row["PictureID"];
            $imagePath = getImagePathFromID($picID, $conn);
            break;
        }
    }
    return $imagePath;
 }

/*
Gets a list of GroupIDs to recommend to a given user, ordered
by the number of their friends who are members of the group
*/
function getGroupRecommendations($user_id, $conn) {
  
  /*
  Subquery to get a list of groups that the user already belongs to
  */
  $groups_user_is_in_sql = "
      SELECT GroupID FROM group_members
          WHERE UserID = $user_id";
  
  /*
  Gets an ordered list of groups the user doesn't belond to based on 
  how many of their friends are in the group
  */
  $friends_in_group_sql = "
      SELECT GroupID, COUNT(UserID) AS count FROM group_members
          WHERE GroupID NOT IN ($groups_user_is_in_sql)
          AND UserID IN (
              SELECT UserTwo FROM friendships
                  WHERE UserOne = $user_id
              )
          GROUP BY GroupID
          ORDER BY count DESC";
  
  $result = $conn->query($friends_in_group_sql);
  
  // Create an array of the GroupIDs to return
  $recommended_groups = array();
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $recommended_groups[] = $row['GroupID'];
    }
  }
  
  return $recommended_groups;
  
}
    
/*
Takes a PostID and prints the html to display that post in a feed
*/
function getFeedItemHTML($post_id, $link) {
  
  $sql = "
      SELECT * FROM posts 
          JOIN blog_wall
          ON posts.BlogID = blog_wall.BlogID
          WHERE PostID = $post_id";
  $result = $link->query($sql);
  if ($row = $result->fetch_assoc()) { 
    
    ?>

    <div class="feed-item" id="<?php echo $post_id; ?>">
      <h5><?php echo getUsernameFromID($row['OwnerID'], $link); //Group/User's name goes here ?></h5>
      <p><?php echo $row['text']; ?></p>
      
    <?php
      if ($row['PictureID']) {
        // Show the photo
        ?>
      <img src="<? echo getImagePathFromID($row['PictureID'], $link); ?>" class="feed-photo">
        <?php
      }
    ?>
      
      <p><?php echo $row['Time']; ?></p>
    </div>
    
    <?php
  }
}


?>
