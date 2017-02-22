<?php include 'connect.php'?>
<?php
ini_set('$file_uploads', 'On');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Photos</title>

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="image-picker/image-picker.min.js"></script>

<link rel="stylesheet" type="text/css" href ="image-picker/image-picker.css">


</head>

</head>

<body>

<h1>My Photos</h1>

<?php 
// in reality, get user id from sessions
$userID = 105;
?>

<?php
$selectAlbums = "SELECT AlbumName FROM albums WHERE OwnerID = {$userID}";
?>


<h2>Create an Album!</h2>

<form action = "createAlbum.php" method="post">

Album Name: <br>
<input type="text" name="albumName" placeholder="Enter a name for your album!" required><br>

Who can see your album? <br>
<select name ="privacy">
    <option value = "friends">Friends</option>
    <option value = "circles">Circles</option>
    <option value = "friendsOfFriends">Friends of Friends</option>
</select><br>

<input type="submit" value = "Create Album!">

</form>


<h2>Upload Photos!</h2>

<form action="uploadPhotos.php" method="post" enctype="multipart/form-data">

Select an Image: <br>
<input type="file" name = "uploadedimage"><br>

Choose an album for your image: <br>

<select name = "albumName">;

<?php
$albumNames = mysqli_query($link, $selectAlbums);
    if (mysqli_num_rows($albumNames) > 0) {     
        while ($row2 = mysqli_fetch_assoc($albumNames)) {
            echo "<option value = \"". $row2["AlbumName"] . "\">" . $row2["AlbumName"] . "</option><br>";
        }
    } else {
        echo "No albums";
    }
?>

</select><br>


<!--<option value = "profilePics">Profile Pictures</option>
    <option value = "books">Books</option>-->


<input type = "submit" value = "Upload Now!"><br>

</form>

<h2>My albums</h2>

<?php
// Selects all albums owned by current user and displays their names
$albumNames = mysqli_query($link, $selectAlbums);
//$result = $link->query($selectAlbums);

if (mysqli_num_rows($albumNames) > 0) {     
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($albumNames)) {
        echo "<li>" . $row["AlbumName"] . "<br>"; 
    };
    echo "</ul>";


} else {
    echo "No albums";
}
?>

<h2> See photos from an album of your choice! </h2>

<form action = "displayAlbumPhotos.php" method="post">

<input type="submit" name="albumName" value="Books2">
<input type = "submit" name ="albumName" value = "For3">

</form>

<h2> Comment on photos! </h2>

<!--
<form action = "comment.php" method = "post" id="commentForm">

<textarea name = "comment" form="commentForm" placeholder="Write your comment here"></textarea><br>

<input type = "submit">
</form>-->


<h2>All Your Beautiful Photos! (and all the rest as well)</h2>

<?php

$selectPics = "SELECT pictures.Picture, pictures.AlbumID, pictures.PictureID FROM pictures, albums WHERE pictures.AlbumID = albums.AlbumID AND albums.OwnerID = {$userID}";

$picResult = mysqli_query($link, $selectPics);
?>


<?php
$i=1;
if (mysqli_num_rows($picResult) > 0) {
    while ($row3 = mysqli_fetch_assoc($picResult)) {
        // print photo
        echo "<img src = \"" . $row3["Picture"] . "\" width=\"200\" height=\"200\" id=\"" . $row3["PictureID"] . "\"> <br>";
        
?>

    <form action = "comment.php" method = "post" id="commentForm<? echo $i; ?>">

    <textarea name = "comment" form="commentForm<? echo $i;?>" placeholder="Write your comment here" value=" "></textarea><br>
    
    <input type = "hidden" name = "picID" value = "<?php echo $row3["PictureID"]; ?>">

    <input type = "submit">
    </form>

<?
        //print comments
        $thisPicID = $row3["PictureID"];
        
        $selectComments = "SELECT comments.Time, comments.Text, users.Username FROM comments, users WHERE comments.UserID = users.UserID AND comments.PostID = {$thisPicID}";

        $commentsResult = mysqli_query($link, $selectComments);

        if (mysqli_num_rows($commentsResult) > 0) {
            while ($row4 = mysqli_fetch_assoc($commentsResult)) {
                echo $row4["Time"] . "<br>" . $row4["Username"] . "<br>" . $row4["Text"] . "<br>";
            }
        }
    $i++;
    }
}
?>



<?php
mysqli_close($link);
?>
</body>
</html>