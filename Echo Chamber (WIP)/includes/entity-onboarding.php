<?php
/*
This contains functions to control the serving of entities during onboarding
on choose-your-chamber.php. It will load 5 entities in order, based on 
the ones with the most overlap with the user's sentiments so far.
*/
require_once('../includes/connect.php');
function get_entity() {
  
  // Make the DB linkection available inside the function
  global $link;
  
  // Check if this is the first entity they need to be served
  if (!isset($_SESSION['onboarding_entities']) ||
     count($_SESSION['onboarding_entities']) == 0) {
    // Add variable to POST
    $_SESSION['onboarding_entities'] = array();
    // Get the most popular entities
    $limit = 10;
    $sql = "SELECT Entity, COUNT(Entity) AS Count 
              FROM sentiments 
              JOIN entity 
              ON entity.EntityID = sentiments.EntityID
              GROUP BY Entity 
              ORDER BY Count DESC
              LIMIT $limit";
    $result = mysqli_query($link, $sql);
    // Choose one of these at random to be the first entity
    $no_of_popular_entities = min($limit, mysqli_num_rows($result));
    $result->data_seek(rand(0, $no_of_popular_entities));
    // Return the name of the entity as a string
    $entity = $result->fetch_assoc()['Entity'];
    return $entity;
  } else {
    // Get entities that will maximise matches based on last response
    // ref: https://secure.php.net/manual/en/function.array-keys.php#59892
    $seen_entities = array_keys($_SESSION['onboarding_entities']);
    // The above line makes a copy so pop does not affect the array in SESSION
    $last_entity = array_pop($seen_entities);
    $last_sentiment = $_SESSION['onboarding_entities'][$last_entity];
    // Get a string of the entities they've already seen in a format that
    // can be used in a SQL query
    $seen_entities_sql = "'" . implode("', '", array_keys($_SESSION['onboarding_entities'])) . "'";
    $sql = "SELECT Entity, COUNT(Entity) AS Count
              FROM sentiments
              JOIN entity 
              ON entity.EntityID = sentiments.EntityID
              WHERE UserID IN 
                  (
                  SELECT DISTINCT UserID FROM sentiments
                      WHERE Entity = '$last_entity'
                      AND Sentiment = '$last_sentiment'
                  )
              AND Entity NOT IN ($seen_entities_sql)
              GROUP BY Entity
              ORDER BY Count
              LIMIT 1";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) != 0) {
      // If an entity is found with this method, return it as a string
      $entity = $result->fetch_assoc()['Entity'];
      return $entity;
    } else {
      // If there are good entities using the method above, choose a random one
      // that the user hasn't seen yet
      $sql = "SELECT Entity, COUNT(Entity) AS Count 
                  FROM sentiments 
                  JOIN entity 
                  ON entity.EntityID = sentiments.EntityID
                  WHERE Entity NOT IN ($seen_entities_sql)
                  GROUP BY Entity 
                  ORDER BY Count DESC";
      $result = mysqli_query($link, $sql);
      $result->data_seek(rand(0, mysqli_num_rows($result)));
      // Return this entity as a string
      $entity = $result->fetch_assoc()['Entity'];
      return $entity;
    }
  }
}
?>