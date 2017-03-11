<?php include '../includes/phptop.php';?>
<?php include '../includes/functions.php';?>

<?php 
// In practice, to be set at login
$_SESSION["userID"] = 105;
?>

<?php
$userID = $_SESSION["userID"];
$albumID = $_SESSION["albumID"]; // $albumID should be set to "allAlbums" at start of session
//echo $albumID;

?>

<?php 
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
    echo "Albums for user {$userID} <br>:";
    print_r($userAlbums);
    echo "<br>";
    return $userAlbums;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Photos</title>

<head>
</head>

</head>

<?php
function getAlbumPrivacySettings($albumID, $conn) {
    $privacy = null;
    
    $stmt = $conn->prepare("SELECT Privacy FROM albums WHERE AlbumID = ?");
    $stmt->bind_param("i", $albumID);
    
    if($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result) >0) {
            $row = mysqli_fetch_assoc($result);
            $privacy = $row["Privacy"];
            echo $privacy;
        }
    } else {
        echo "Error: ". $stmt. "<br>" . $conn->error;
    }
    return $privacy;
}
?>

<body>

<?php
getAlbumPrivacySettings(1, $link);
?>

<h1>Manage Photos</h1>

<h2>Manage Existing Albums</h2>
<h3>Delete or Rename your Albums, or Adjust Privacy Settings</h3>

<?
$privacies = ['Friends', 'Circles', 'FriendsOfFriends', 'Public'];
$userAlbums = getUserAlbumsArr($userID, $link);

for($i=0; $i<count($userAlbums); $i++) {
    $albumName = getAlbumNameFromID($userAlbums[$i], $link); 
    echo $albumName;
    $privArray = array();
    $privArray[0] = getAlbumPrivacySettings($userAlbums[$i], $link);
    ?>
    <form action = "../process/processDeleteAlbum.php" method="post">
        <button type="delete" value="<?php echo $userAlbums[$i];?>" name="albumID">Delete</button>
    </form>
    <form action = "../process/processRenameAlbum.php" method="post">
        <input type="text" placeholder = "Enter a new name for your album" name="newAlbumName">
        <input type="hidden" value="<?php echo $userAlbums[$i];?>" name="albumID">
        <input type="submit" value="Apply Rename">
    </form>
    <form action = "../process/processChangeAlbumPrivacy.php" method="post">
        <select name ="privacy">
        <option value = "Friends">Friends</option>
        <option value = "Circles">Circles</option>
        <option value = "FriendsOfFriends">Friends of Friends</option>
        <option value = "Public">Public</option>
        </select>
        <input type="hidden" value="<?php echo $userAlbums[$i];?>" name="albumID">
        <input type = "submit" value = "Apply privacy settings changes">
    </form>
        
<?php
echo "<br>";
}
?>

<?php
mysqli_close($link);
?>

</body>
</html>