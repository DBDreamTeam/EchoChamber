<?php 
include '../includes/connect.php';
mysqli_query($link, "SET SESSION sql_mode = 'STRICT'");

ini_set('$file_uploads', 'On');

session_start();

// Get variables (the new password) from post
// which we want to hash as well

$hash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
// $hash1 = password_hash($_POST["repeatNewPassword"], PASSWORD_DEFAULT);

// check that both passwords, ie hashes are the same, throw error if not
if ($_POST["newPassword"] != $_POST["repeatNewPassword"]){
    echo "Passwords do not match.";
}else{
    
 $stmt = $link->prepare("UPDATE users SET Password = ? WHERE UserID = ?");
 $stmt->bind_param("si", $hash, $_SESSION['UserID']);
// http://php.net/manual/de/mysqli-stmt.bind-param.php        
        if ($stmt->execute() === TRUE) {
                echo "Password updated successfully";
                // evtl session regenerate
            } else {
                echo "Error: ". $stmt . "<br>" . $link->error;
         }
    
}
         
/* explicit close recommended */
$stmt->close();
$link -> close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Password changed</title>
</head>

<body>
    <p>Well done.</p>
</body>
</html>