<?php include 'connect.php'?>

<?php
$sql = "INSERT INTO users (Username, Password, Birthday)
        VALUES ( 'test', 'test', '2017-06-04')";

$test = 'kl';

$query_upload="INSERT INTO `pictures` (Time, Picture) VALUES ('hk')";

        

if ($link -> query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: ". $sql . "<br>" . $link->error;
}

if ($link -> query($query_upload) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: ". $query_upload . "<br>" . $link->error;
}

?>

