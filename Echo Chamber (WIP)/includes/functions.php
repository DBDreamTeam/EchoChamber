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

?>