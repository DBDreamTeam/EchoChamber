<?php

session_start();

include("../includes/connect.php");
include("../process/sentiments.php");

$blogInput = $_POST["blogInput"];
//get the BlogID of current profile
$LoggedUserID = $_SESSION["LoggedUserID"];
$BlogID = $_POST["BlogID"];
$isGroup = $_SESSION["isGroup"];

if ($isGroup == '0') {
  header("Location: ../public/profile.php");
  echo "individual";
  //echo '<script type="text/javascript">window.location = "http://localhost:8888/ECHOCHAMBER/public/profile.php";</script>';
} else {
  header("Location: ../public/groupBlog.php");
  echo "group";
  //echo '<script type="text/javascript">window.location = "http://localhost:8888/groupBlog.php";</script>';
}

$insertBlog = "INSERT INTO posts (BlogID, text, AlbumID) VALUES ('$BlogID','$blogInput', NULL)";
echo "<br>" . $insertBlog;
if ($link->query($insertBlog) === TRUE) {
} else {
  echo "Error: ". $insertBlog . "<br>" . $link->error;
}



// Update sentiments table with new data
$text_from_posts_sql = "
    SELECT text FROM posts
        JOIN blog_wall
        ON posts.BlogID = blog_wall.ID
        WHERE blog_wall.IsGroup = 0
        AND blog_wall.OwnerID = $LoggedUserID";
$text_from_posts_result = $link->query($text_from_posts_sql);
$text_from_posts_array = mysqli_fetch_array($text_from_posts_result, MYSQLI_NUM);
$all_text_from_posts = implode(". ", $text_from_posts_array);

$text_from_comments_sql = "
    SELECT Text FROM comments
        WHERE UserID = $LoggedUserID";
$text_from_comments_result = $link->query($text_from_comments_sql);
$text_from_comments_array = mysqli_fetch_array($text_from_comments_result, MYSQLI_NUM);
$all_text_from_comments = implode(". ", $text_from_comments_array);

$entity_sentiments = getEntitySentiments($all_text_from_posts . ". " . $all_text_from_comments);

foreach ($entity_sentiments as $entity => $sentiments) {
  $update_sentiments_sql = "
      REPLACE INTO sentiments (UserID, Entity, Sentiment)
          VALUES ($LoggedUserID, $entity, $sentiment)";
  $link->query($entity_sentiments_sql);
}


?>
