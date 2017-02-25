<?php
// Gets extension of uploaded image
// REF: ....
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

function insertImagePlus($albumID, $conn) {
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
}

// inserts an image into the pictures table and returns the PictureID
function insertImage($imagePath, $albumID, $conn) {
    $imageID = null;
    
    $insertImage = "INSERT INTO pictures (Picture, AlbumID) VALUE ('{$imagePath}', {$albumID})";
    
    if($conn-> query($insertImage) === TRUE) {
        echo "New image successfullly inserted into pictures <br>";
        $imageID = mysqli_insert_id($conn);
    } else {
        echo "Error: ". $insertImage. "<br>". $conn->error;
    }
    return $imageID;
}

// gets the target path of an uploaded image
// REF: TO REFIND
function getTargetPath() {
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
}

// get the temp name of the uploaded image
// REF: TO FIND AGAIN
function getTempName() {
    $tempName = null;
    if (!empty($_FILES["uploadedimage"]["name"])) {
        $tempName=$_FILES["uploadedimage"]["tmp_name"];
    }
    echo $tempName;
    return $tempName;
}

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

// Inserts new entry into groups table
function insertGroup ($idBlog, $groupName, $groupPicID, $groupPrivacy, $conn) {
    $groupID = null;

    $insertGroup = "INSERT INTO groups (BlogID, Name, PictureID, Privacy) VALUE ({$idBlog}, '{$groupName}', {$groupPicID},'{$groupPrivacy}')";
    
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
            echo "Group members successfully inserted into group_members <br>";
        } else {
            echo "Error: ". $insertGroupMembers . "<br>" . $conn->error;
        }
    }
}

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

// gets Album IDs for users albums
function getUserAlbumIDs($userID, $conn) {
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
}

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

// Inserts message into message table
function insertMessage($ChatID, $UserID, $MsgContent, $MsgPic, $conn) {
    $messageInsert = "INSERT INTO message (ChatID, UserID, Text, Photo) VALUE ({$ChatID}, {$UserID}, '{$MsgContent}', '{$MsgPic}')";

    if ($conn -> query($messageInsert) === TRUE) {
        echo "Message inserted into messages successfully";
    } else {
        echo "Error: ". $messageInsert . "<br>" . $conn->error;
    }
}

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

// gets all albums belonging to user with $userID, and echoes a combo box containing these albums
function getUserAlbumsCB($userID, $conn) {

    $selectAlbums = "SELECT AlbumName FROM albums WHERE OwnerID = {$userID}";
    
    $albumsResult = mysqli_query($conn, $selectAlbums);

    if(mysqli_num_rows($albumsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumsResult)) {
            echo "<option value = \"". $row["AlbumName"] . "\">" . $row["AlbumName"] . "</option><br>";
        }
    } else {
        echo "No albums yet.";
    }
    
}

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

?>