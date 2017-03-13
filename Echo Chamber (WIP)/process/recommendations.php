<?php

function get_friend_recommendations($user_id) {
  
  require_once("local-connect.php");
  
  
  // Get list of users that are not their friends already
  // This must also exclude people they have pending friend requests with
  $non_friends_sql = "
      SELECT * FROM users 
          WHERE UserID <> $user_id
          AND UserID NOT IN
              (
              SELECT UserTwo FROM friendships
                  WHERE UserOne = $user_id
              )
          AND UserID NOT IN
              (
              SELECT user_to FROM friend_requests
                  WHERE user_from = $user_id
              )";
  
  $common_entities_sql = "
      SELECT s1.Entity FROM sentiments AS s1
          JOIN sentiments AS s2
          ON s1.Entity = s2.Entity
          WHERE s1.Sentiment = s2.Sentiment
          AND s1.UserID <> s2.UserID
          AND s1.UserID = $user_id
          AND s2.UserID = $user_two";
  
  $sql = "
      SELECT * FROM users 
          WHERE UserID NOT IN ($non_friends_sql)
          ORDER BY 
              ($no_of_common_entities) DESC,
              ($no_of_common_friends) DESC,
              ($no_of_common_circles) DESC";
  
  $result = mysqli_query($conn, $non_friends_sql);
  
  return $result;
  
}

?>