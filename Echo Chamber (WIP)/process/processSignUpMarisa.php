<?php include 'connect.php'?>
<?php
$username = $_POST["email"];
//$password = $_POST["email"];

$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$birthday = $_POST["year"] . $_POST["month"] . $_POST["day"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$date = $year . "-" . $month . "-" . $day;
function GetImageExtension($imagetype) {
    if(empty($imagetype)) return false;
    switch($imagetype) {
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}
if (!empty($_FILES["uploadedimage"]["name"])) {
echo "here";
    $file_name=$_FILES["uploadedimage"]["name"];
    echo $file_name . "<br>";
    $temp_name=$_FILES["uploadedimage"]["tmp_name"];
    $imgtype=$_FILES["uploadedimage"]["type"];
    $ext= GetImageExtension($imgtype);
    $imagename= $_FILES["uploadedimage"]["name"];
    $target_path = "images/".$imagename;
    echo $target_path . "<br>";
    if(move_uploaded_file($temp_name, $target_path)) {
        $sql2 = "INSERT INTO pictures (Picture) VALUES ('{$target_path}')"; 
        $picID = null;
        $userID = null;
        
        // Insert profile picture into pictures
        if ($link -> query($sql2) === TRUE) {
            echo "Upload inserted into pictures successfully";
            $picID = mysqli_insert_id($link);
            echo "New profile pic has id: " . $picID;
        } else {
            echo "Error: ". $sql2 . "<br>" . $link->error;
        }
        
        // Insert user info into users
        
        $stmt = $link->prepare("INSERT INTO users (Username, Password, Birthday, PictureID) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $username, $hash, $date, $picID);
        
       // $sql = "INSERT INTO users (Username, Password, Birthday, PictureID) VALUES ( '{$username}', '{$hash}', '{$date}', '{$picID}')";
        
        if ($stmt->execute() === TRUE) {
                echo "Record inserted into users successfully";
                $userID = mysqli_insert_id($link);
                echo "New user has id: " . $userID;
            } else {
                echo "Error: ". $sql . "<br>" . $link->error;
         }
         
         // Insert profile picture into photo album
         $albumInsert = "INSERT INTO albums (OwnerID, AlbumName) VALUE ('{$userID}', 'Profile Pictures')";
         
         if ($link -> query($albumInsert) === TRUE) {
                echo "Record inserted into albums successfully";
            } else {
                echo "Error: ". $albumInsert . "<br>" . $link->error;
         } 
      
} else{
   exit("Error While uploading image on the server");
}
}
?>
<?
/* explicit close recommended */
//$stmt->close();
$link -> close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
</head>

<body>
Welcome <?php echo $_POST["email"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
</body>
</html>