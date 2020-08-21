<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = strval($_GET['q']);

$host_name = 'db5000295091.hosting-data.io';
$database = 'dbs288271';
$user_name = 'dbu133295';
$password = 'BouncingPetalFallWater!7';

$dbconnect=mysqli_connect($host_name,$user_name,$password,$database);
if (!$dbconnect) {
    die('Could not connect: ' . mysqli_error($dbconnect));
}

$query = "SELECT * FROM Location WHERE FirstName = '".$q."'";
echo $query;
$result = mysqli_query($dbconnect, $query);

echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Timestamp</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Latitude'] . "</td>";
    echo "<td>" . $row['Longitude'] . "</td>";
    echo "<td>" . $row['timestamp'] . "</td>";
    echo "</tr>";
}
/*$totalDistanceLat = 0;
$totalDistancelong = 0;
$count = 0;
while($row = mysqli_fetch_array($result)) {
  $totalDistanceLat = $totalDistanceLat + $row['Latitude'];
  $totalDistancelong = $totalDistancelong + $row['Longitude'];
  $count = $count + 1;
}
$avgDistLat = $totalDistanceLat / $count;
$avgDistlong = $totalDistancelong / $count;
  echo "</table>";
  echo "<div class=\"col-sm-6\">";
  echo "<p>Total distance in latitude: " + $totalDistanceLat + "</p>";
  echo "<p>Total distance in longitude: " + $totalDistanceLong + "</p>";
  echo "<p>Average distance in latitude of points: " + $avgDistLat + "</p>";
  echo "<p>Average distance in Longitude of points: " + $avgDistLong + "</p>";
  echo "</div>";*/
mysqli_close($dbconnect);
?>
</body>
</html>
