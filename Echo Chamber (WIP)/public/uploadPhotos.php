<?php include 'connect.php'?>

<?php
// to get from session
$userID = 105;
?>

<?
$albumName = $_POST["albumName"];
$albumID = null;
?>

<?
// gets album ID
$selectAlbumID = "SELECT AlbumID FROM albums WHERE albumName = '{$albumName}'";
$result = mysqli_query($link, $selectAlbumID);

if (mysqli_num_rows($result) >0) {
    $row = mysqli_fetch_assoc($result);
    $albumID = $row["AlbumID"];
    echo $albumID . "<br>";
}
?>

<?
// inserts uploaded picture into pictures
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

        $sql2 = "INSERT INTO pictures (Picture, AlbumID) VALUES ('{$target_path}', '{$albumID}')"; 
        $picID = null;
        $userID = null;
        
        // Insert uploaded picture into pictures
        if ($link -> query($sql2) === TRUE) {
            echo "Upload inserted into pictures successfully";
            $picID = mysqli_insert_id($link);
            echo "New pichas id: " . $picID;
        } else {
            echo "Error: ". $sql2 . "<br>" . $link->error;
        }

} else{
   exit("Error While uploading image on the server");
}
}
?>