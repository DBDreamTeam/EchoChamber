<?php

require_once("unirest-php/src/Unirest.php");

function getEntitySentiments($text) {
  
  /*
  Takes a body of text, extracts entities from it, and determines
  the sentiment towards each entity within the text.
  Returns an array, where the indexes are the entity names in lower
  case, and the values are the sentiments (-1 for most negative, 
  0 for neutral, 1 for most positive)
  */
  
  // Extract entities
  
  // Base URL is required for the API call - use the current page
  $base = $_SERVER["REQUEST_URI"];
  
  // API call for entity extraction. Input is passed in as part of the URL.
  $response = Unirest\Request::get(
    "https://alchemy.p.mashape.com/text/TextGetRankedNamedEntities"
         . "?"
         . "baseUrl=$base"
         . "&coreference=false"
         . "&disambiguate=false"
         . "&linkedData=false"
         . "&maxRetrieve=100"
         . "&outputMode=json"
         . "&text=$text",
    array(
      "X-Mashape-Key" => "bjDTtWE63PmshZp9HRCcFOvtWH9wp1ym2L5jsnvXy8Di9VpN28",
      "Accept" => "application/json"
      )
  );
  
  // Get the relevant part of the response
  $entities = $response->body->entities;
  
  // Get an array of only those entites with sufficient relevance
  $relevant_entities = array();
  foreach ($entities as $entity) {
    if ($entity->relevance > 0.25) {
      // If an entity has high relevance, add it to the array
      $relevant_entities[] = $entity->text;
    }
  }
  
  // Get entity sentiment
  
  $entity_sentiments = array();
  
  // For each entity, query the text for the sentiment towards it
  foreach ($relevant_entities as $term) {
    // API call. Target is passed in as URL parameter.
    $response = Unirest\Request::get("https://alchemy.p.mashape.com/text/TextGetTargetedSentiment"
                                 . "?"
                                 . "outputMode=json"
                                 . "&target=$term"
                                 . "&text=$text",
      array(
          "X-Mashape-Key" => "bjDTtWE63PmshZp9HRCcFOvtWH9wp1ym2L5jsnvXy8Di9VpN28",
          "Accept" => "text/plain"
        )
    );
    
    // Get the sentiment type
    $sentiment_type = $response->body->docSentiment->type;
    
    if ($sentiment_type == "neutral") {
      // If it's neutral, add it to the array with sentiment 0
      $entity_sentiments[strtolower($term)] = 0;
    } else {
      // Get the sentiment value
      $sentiment_value = (float) $response->body->docSentiment->score;
      // Add it to the array
      $entity_sentiments[strtolower($term)] = $sentiment_value;
    }
    
  }
  
  // Return the array
  return $entity_sentiments;
  
}

?>