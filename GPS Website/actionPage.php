<?php
header("Location: https://gpstraceaz.com/MapsAndData.php", true, 301);
exit();
?>
<?php
	$host_name = 'db5000295091.hosting-data.io';
	$database = 'dbs288271';
	$user_name = 'dbu133295';
	$password = 'BouncingPetalFallWater!7';

	$dbconnect=mysqli_connect($host_name,$user_name,$password,$database);

	if ($dbconnect->connect_error) {
	  die("Database connection failed: " . $dbconnect->connect_error);
	}

	$fName=$_GET['fname'];
	$lName=$_GET['lname'];
	$latitude=$_GET['latitude'];
	$longitude=$_GET['longitude'];
	$cT=$_GET['insertF'];


	$query = "INSERT INTO Location VALUES (NULL, '$fName', '$lName', $latitude, $longitude, '$cT', NULL)";
	echo $query;
	if (!mysqli_query($dbconnect, $query)) {
		if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
		}
			/*echo("Error description: " . $mysqli -> error);
      die('An error occurred when submitting your review.');*/
    }
		else {
      echo "Insert Successful";
}

?>
