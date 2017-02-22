<?php include 'connect.php'?>

<?php 
// to get from session variable
$userID = 105;
?>

<?php
// need to get this from somewhere
//$postID = 61;
?>

<?php
$postID = $_POST["picID"];
echo $postID;
$commentText = $_POST["comment"];
echo $commentText;

$insertComment = "INSERT INTO comments (Text, UserID, PostID) VALUES ('{$commentText}', {$userID}, {$postID})";


// Insert profile picture into pictures
if ($link -> query($insertComment) === TRUE) {
    echo "Inserted comment text and userID into comments table successfully";

} else {
    echo "Error: ". $insertComment . "<br>" . $link->error;
}
        

?>

