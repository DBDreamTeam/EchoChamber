<?php 

include 'connect.php';

session_start();

mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");

ini_set('$file_uploads', 'On');

?>