<?php
session_start();
if (isset($_SESSION['userID'])) {
     $_SESSION = array();
  session_destroy();
}
header("Location:../public/index.php");
?>