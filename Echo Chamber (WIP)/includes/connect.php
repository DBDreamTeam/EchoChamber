<?php
  // 1. Create a database connection
    // 1b. Connecting with MAMP
    // Instructions from "http://localhost:8888/MAMP/?language=English" for PHP>=5.6.x
    $user = 'root';
    $password = 'root';
    $db = 'echo';
    $host = 'localhost';
    $port = 8889;
    
    $link = mysqli_init();
    $success = mysqli_real_connect(    
        $link, 
        $host,
        $user,
        $password,
        $db,
        $port
    );
    
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>