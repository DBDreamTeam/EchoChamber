<?
function getUserAlbumBtns($userID, $conn) {
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
}

function displayAllUserPhotos($userID, $conn) {
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
}

function displayAlbumPhotos($albumID, $conn) {
    $selectAlbumPics = "SELECT pictures.Picture, pictures.PictureID FROM pictures WHERE pictures.AlbumID = {$albumID}";
    
    $albumPicsResult = mysqli_query($conn, $selectAlbumPics);
    $i=1;
    if(mysqli_num_rows($albumPicsResult) > 0) {
        while($row = mysqli_fetch_assoc($albumPicsResult)) {
            echo "<img src = \"../process/" . $row["Picture"] . "\" width=\"200\" height=\"200\"> <br>";
            printComments($row["PictureID"], $conn);
            printCommentForm($row["PictureID"], $i);
            $i++;
        }
    }
}

function printComments($picID, $conn) {
    $selectComments = "SELECT comments.Time, comments.Text, users.Username FROM comments, users WHERE comments.UserID = users.UserID AND comments.PostID = {$picID}";
    
    $commentsResult = mysqli_query($conn, $selectComments);
    
    if(mysqli_num_rows($commentsResult) > 0) {
        while($row = mysqli_fetch_assoc($commentsResult)) {
            echo $row["Time"] . "<br>" . $row["Username"] . "<br>" . $row["Text"] . "<br>";
        }
    }
}

function printCommentForm($picID, $i) { 
    echo "<form action = \"../process/processComment.php\" method = \"post\" id=\"commentForm" . $i . "\">";

    echo "<textarea name = \"comment\" form=\"commentForm" . $i . "\" placeholder=\"Write your comment here\"></textarea><br>";
    
    echo "<input type = \"hidden\" name = \"picID\" value = ". $picID ." \">";

    echo "<input type = \"submit\">";
    echo "</form>";
}
?>