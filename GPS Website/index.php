<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/css/Default.css">
	<title>GPS Trace</title>
	<div class="jumbotron jumbotron-fluid">
  	<div class="container">
			<h1>Maps and Data</h1>
		</div>
	</div>
</head>
<body>
<script>
	if (location.protocol != 'https:')
	{
	 location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
	}
</script>
<div class="container-fluid">
  <h1>GPS Point Tracking</h1>
  <p>By entering a name below you will log a point with a best guess at your current location. The goal of this is to take a look into gps data and what we can extract from it.</p>
  <div class="container-fluid">
<div class="col-8">
<form id="myForm" action="/action_page.php">
  First name: <input type="text" name="fname"><br>
  Last name: <input type="text" name="lname"><br><br>
  <input type="hidden" id="latitude" name="latitude" value="">
  <input type="hidden" id="longitude" name="longitude" value="">
	<input type="hidden" id="insertF" name="insertF" value='Website'>
  <input type="button" onclick="getLocation()" value="Submit">
</form>
</div>
<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function setPosition(position) {
	oFormObject = document.forms['myForm'];
	oFormObject.elements["latitude"].value = position.coords.latitude;
	oFormObject.elements["longitude"].value = position.coords.longitude;
	document.getElementById("myForm").submit();
}
</script>

</body>
</html>
