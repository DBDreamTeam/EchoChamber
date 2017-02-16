<?php
/*
Add whatever you want to show login success here.
We can start by just having it print out the cookie or
session to show that it knows a specific user is signed in.
*/

session_start();

echo "Session now holds the following values:<br>";
print_r($_SESSION);

die();

?>
