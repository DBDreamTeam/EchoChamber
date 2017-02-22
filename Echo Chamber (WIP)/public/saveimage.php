<?php include 'connect.php';

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
echo " also here <br>";

$test = 'kl';
//$sql ="INSERT INTO `pictures` (Time) VALUES ('rt')";

$sql2 = "INSERT INTO `pictures` (Picture) VALUES ('{$target_path}')";

$test = mysqli_insert_id;

echo $test;

    
/*if ($link -> query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: ". $sql . "<br>" . $link->error;
}*/

if ($link -> query($sql2) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: ". $sql2 . "<br>" . $link->error;
}


/*$test = '1';


    $query_upload="INSERT into pictures (Time) VALUES
        ('{$test}')";*/


} else{
   exit("Error While uploading image on the server");
}
}

?>

