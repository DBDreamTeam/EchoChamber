<?php

session_start();

include("../includes/connect.php");
include("../process/sentiments.php");
include("../includes/functions.php");

header("Location: ../public/profile.php");

$blogInput = $_POST["blogInput"];
echo $blogInput;
//get the BlogID of current profile
$FriendUserID = $_SESSION["FriendUserID"];
$LoggedUserID = $_SESSION["LoggedUserID"];
$BlogID = getBlogID($FriendUserID, 0, $link);
$isGroup = 0;

$picID = "NULL";

// if an image has been uploaded
if(!empty($_FILES["uploadedimage"]["name"])){
    // checks if album of name "Blog Pictures" already exists"
    $doesAlbumExist = doesAlbumNameExist("Blog Pictures", $LoggedUserID, $link);
    
    if($doesAlbumExist == 1) {
        // if a "Blog Pictures" album does exist, get the albumID and add the new blog picture to it
        $albumID = getAlbumIDFromName('Blog Pictures', $LoggedUserID, $link);
        $picID = insertImageNew($albumID, "uploadedimage", $link);
        echo "Album exist <br> $picID";
    } else {
        // if the album does not already exist, create it and add the picture to it
        $albumID = insertAlbum('Blog Pictures', $LoggedUserID, 'Friends', $link);
        $picID = insertImageNew($albumID, "uploadedimage", $link);
      echo "Album does not exist $picID";
      
    }
}

$insertBlog = "INSERT INTO posts (BlogID, text, PictureID) VALUES ($BlogID,'$blogInput', $picID)";
if ($link -> query($insertBlog) === TRUE) {
} else {
  echo "Error: ". $insertBlog . "<br>" . $link->error;
}



// Update sentiments table with new data
$text_from_posts_sql = "
    SELECT text FROM posts
        JOIN blog_wall
        ON posts.BlogID = blog_wall.BlogID
        WHERE blog_wall.OwnerID = $LoggedUserID";
$text_from_posts_result = $link->query($text_from_posts_sql);
$text_from_posts_array = array();
while ($row = $text_from_posts_result->fetch_assoc()) {
  $text_from_posts_array[] = $row['text'];
}
$all_text_from_posts = implode(". ", $text_from_posts_array);

$text_from_comments_sql = "
    SELECT Text FROM comments
        WHERE UserID = $LoggedUserID";
$text_from_comments_result = $link->query($text_from_comments_sql);
$text_from_comments_array = array();
while ($row = $text_from_comments_result->fetch_assoc()) {
  $text_from_comments_array[] = $row['Text'];
}
$all_text_from_comments = implode(". ", $text_from_comments_array);

$entity_sentiments = getEntitySentiments($all_text_from_posts . ". " . $all_text_from_comments);

foreach ($entity_sentiments as $entity => $sentiments) {
  $update_sentiments_sql = "
      REPLACE INTO sentiments (UserID, Entity, Sentiment)
          VALUES ($LoggedUserID, $entity, $sentiment)";
  if ($link->query($entity_sentiments_sql)) {
    echo $update_sentiments_sql . " - inserted successfully<br>";
  }
}


?>