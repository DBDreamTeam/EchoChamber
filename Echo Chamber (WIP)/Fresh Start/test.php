<?php

include("../Alchemy Language Tests/sentiments.php");

echo "Common entities: ";
$result = getCommonEntities(3, 2);

while ($row = $result->fetch_assoc()) {
  print_r($row);
  echo "<br>";
}

?>