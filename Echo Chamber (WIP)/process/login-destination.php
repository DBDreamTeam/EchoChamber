<?php
include '../includes/connect.php';
mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");

ini_set('$file_uploads', 'On');

 /* 
 Using prepared statements to separate out username & password checking
 avoids sql injections
 See: http://php.net/manual/en/mysqli.quickstart.prepared-statements.php, http://stackoverflow.com/questions/8263371/how-can-prepared-statements-protect-from-sql-injection-attacks
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

  // username and password sent from form ("posted by form")
$myusername = $_POST['Username'];
$mypassword = $_POST['Password'];

// First, we check the username match with the prepare statement
//  If a match is found, we return the result
// otherwise return error with bool 

// save sql into prepared statement, using link to db
// bind the found username to the one found in the form
// limit 1 => max 1 row return -> no while loop necessary
$stmt = $link->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1");

$stmt->bind_param("s", $myusername);

// returns bool to indicate whether execute was ok
// $stmt->execute();

// bool check
if (!($stmt->execute())) {
    echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
}

// need to get a return statement to use in password check below
$result = $stmt->get_result();

/* explicit close recommended */
// $stmt->close();

// call function with the saved args to check whether there exist any entries
if (mysqli_num_rows($result) > 0) {
    
    // add constant time string constraint to avoid password trial hacking 
    $row = mysqli_fetch_assoc($result);

// Gets hash from database, hashes user input and compares the hashes  
// http://php.net/manual/de/function.password-verify.php
// online hash generator: http://www.passwordtool.hu/php5-password-hash-generator
   
        if  (password_verify($mypassword, $row["Password"])) {
          // registers the session on the specific user
           $_SESSION['UserID'] = $row['UserID'];
            //redirect
            header("Location: https://www.youtube.com/");
        }else { 
            // don't redirect but display same page with error
            header("Location: index.php");
            echo $_SESSION['errorMsg'] = "Wrong Username or Password. Please try again.";
        }
    }

mysqli_close($link);

// value check, need to delete when testing finished
echo "Post now holds the following values:<br>";
print_r($_POST);
?>