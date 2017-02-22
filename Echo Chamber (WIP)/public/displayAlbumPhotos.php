<?php include 'connect.php'?>
<?php
ini_set('$file_uploads', 'On');
?>

<?php
// to get from session variable
$userID = 105;
?>

<?php
$albumName = $_POST["albumName"];
//echo $albumName . "<br>";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $albumName ?> - Photo Album</title>
</head>

<body>

<h1><?php echo $albumName ?> - Photo Album</h1>

<?

$selectAlbumID = "SELECT AlbumID FROM albums WHERE albumName = '{$albumName}' AND OwnerID = {$userID}";
$result = mysqli_query($link, $selectAlbumID);

if (mysqli_num_rows($result) >0) {
    $row = mysqli_fetch_assoc($result);
    $albumID = $row["AlbumID"];
    //echo $albumID . "<br>";
    
    $selectPics = "SELECT DISTINCT pictures.Picture, pictures.AlbumID FROM pictures, albums WHERE pictures.AlbumID = {$albumID} AND albums.OwnerID = {$userID}";
    
    $picResult = mysqli_query($link, $selectPics);

    if (mysqli_num_rows($picResult) > 0) {
        while ($row3 = mysqli_fetch_assoc($picResult)) {
            echo "<img src = \"" . $row3["Picture"] . "\">";
        }
    }
}
?>


</body>
</html>