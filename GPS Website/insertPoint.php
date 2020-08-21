<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'mobileConn.php';
	createPoint();
}


function createPoint()
{
	global $dbconnect;

	$fName=$_POST['fname'];
	$lName=$_POST['lname'];
	$uName=$_POST['uname'];
	$pass=$_POST['pass'];
	$latitude=$_POST['latitude'];
	$longitude=$_POST['longitude'];
	$cT=$_POST['insertF'];


	$query = "INSERT INTO Location VALUES (NULL, '$fName', '$lName', '$uName', '$pass', $latitude, $longitude, '$cT', NULL)";

	mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));
	mysqli_close($dbconnect);

}

?>
