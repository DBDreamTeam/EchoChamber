<?php 

include 'header.php'; 
include 'connect.php';

?>

<html>
<head>
<br>
<title> Members</title>
	<link rel='stylesheet' href= 'style.css'/>
<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <!-- Fonts -->
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300'>
    <link rel='stylesheet' type='text/css'
        href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic'>
    <link rel='stylesheet' type='text/css'
        href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,900'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<head>
<body>


<div>


<?php 
	
	$sql = 'SELECT * FROM users';
	$result = $conn->query($sql);
			
	echo '<h3> Members: </h3>';
	while($row = $result->fetch_assoc()) { ?>

	<h1>User : <?php echo $row['Username']; ?></h1>
	<br>
</div>
<?php } ?>


</body>
</html>