<?php
include '../includes/connect.php';
// phpinfo();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

  // username and password sent from form ("posted by form")
$email = $_POST['email'];
echo $email;
$mypassword = $_POST['password'];
echo $mypassword;
 /* 
 Using prepared statements to separate out username & password checking
 avoids sql injections
 See: http://php.net/manual/en/mysqli.quickstart.prepared-statements.php, http://stackoverflow.com/questions/8263371/how-can-prepared-statements-protect-from-sql-injection-attacks
 */

// First, we check the username match with the prepare statement
//  If a match is found, we return the result
// otherwise return error with bool 

// save sql into prepared statement, using link to db
// bind the found username to the one found in the form
// limit 1 => max 1 row return -> no while loop necessary
$stmt = $link->prepare("SELECT * FROM users WHERE Email = ? LIMIT 1");

$stmt->bind_param("s", $email);

// returns bool to indicate whether execute was ok
//$stmt->execute();

// bool check
if ($stmt->execute()) {
    echo "Query to user table successfully performed <br>";
    // need to get a return statement to use in password check below
    $result = $stmt->get_result();

    //checks if the user exists (if the user email exists in the user table)
    if (mysqli_num_rows($result) <=0) {
        $_SESSION['errorMsg'] = "Wrong Email. Please try again. <br>";
            echo $_SESSION['errorMsg'];
            echo "User does not exist in table <br>";
            header("Location: ../public/index.php");
    // if the user does exist in table, check password
    } else {
    // call function with the saved args to check whether there exist any entries
        //if (mysqli_num_rows($result) > 0) {
            // add constant time string constraint to avoid password trial hacking 
            $row = mysqli_fetch_assoc($result);

            echo $row["Password"];
        // Gets hash from database, hashes user input and compares the hashes  
        // http://php.net/manual/de/function.password-verify.php
        // online hash generator: http://www.passwordtool.hu/php5-password-hash-generator -> Marisa
        // ($row["Password"] == $mypassword)
        
            
        // Checks if password is valie
        if  (password_verify($mypassword, $row["Password"])) {
          // registers the session on the specific user
           $_SESSION['LoggedUserID'] = $row['UserID'];
           $_SESSION['FriendUserID'] = $row['UserID'];
            //redirect
            header("Location: ../public/profile.php");
        }else { 
            // don't redirect but display same page with error
           // header("Location: ../public/index.php");
            $_SESSION['errorMsg'] = "Wrong Password. Please try again. <br>";
            echo $_SESSION['errorMsg'];
            header("Location: ../public/index.php");
        }
    }
} else {
    // if query fails
    echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
}


mysqli_close($link);
?>

<?//    if (!password_verify($password, $hash)) {
//    echo 'Invalid password.';
//    exit;
//}?>