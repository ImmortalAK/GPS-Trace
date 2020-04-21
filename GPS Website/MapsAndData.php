<!DOCTYPE html>
  <html>
  <style>
    #mapid {  height: 300px;
      min-height: 40%;}
  </style>
  <head>
    <title>GPS Trace</title>
    <link rel="stylesheet" href="/css/Default.css">
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>
    <!--bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <div class="jumbotron jumbotron-fluid">
    	<div class="container">
  			<h1>Plot a Point</h1>
  		</div>
  	</div>
  </head>

  <body>
    <div class="col-sm-10">
      <div id="mapid"></div>
    </div>
    <div class="col-sm-6">
    <script>
      document.write("Test");
      //Building and placing the leaflet map with attributions
      var mymap = L.map('mapid').setView([34.4811761, -83.9371468], 13);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWNraXJiNTg5MyIsImEiOiJjazhtZWhvamMwaW9mM2ZuMm5tM2drM3l3In0.gAPUQPRWd6i1dsCIwBviTg', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
      }).addTo(mymap);

      document.write("Test1");
      var popup = L.popup();
      function onMapClick(e) {
        popup
          .setLatLng(e.latlng)
          .setContent("You clicked the map at " + e.latlng.toString())
          .openOn(mymap);
      }
      document.write("Test2");
      mymap.on('click', onMapClick);
      <?php

        //connection to location database
      	$host_name = 'db5000295091.hosting-data.io';
      	$database = 'dbs288271';
      	$user_name = 'dbu133295';
      	$password = 'BouncingPetalFallWater!7';

      	$dbconnect=mysqli_connect($host_name,$user_name,$password,$database);

      	if ($dbconnect->connect_error) {
      	  die("Database connection failed: " . $dbconnect->connect_error);
      	}

        $query = "SELECT * FROM Location";
        $result = mysqli_query($dbconnect, $query);
        $rowCnt = mysqli_num_rows($result);

        echo "document.write(\"Test3\");";

        echo "var table = new Array(" . $rowCnt . ");
                for(var i = 0; i < table.length; i++){
                table[i] = new Array(6);}";
        $count = 0;
        //passing variables from php into javascript for ploting on the map
        while($row = mysqli_fetch_array($result)) {
          echo "table[" . $count . "][0] = '" . $row['FirstName'] . "'; ";
          echo "table[" . $count . "][1] = '" . $row['LastName'] . "'; ";
          echo "table[" . $count . "][2] = '" . $row['Latitude'] . "'; ";
          echo "table[" . $count . "][3] = '" . $row['Longitude'] . "'; ";
          echo "table[" . $count . "][4] = '" . $row['ConnType'] . "'; ";
          echo "table[" . $count . "][5] = '" . $row['timestamp'] . "'; ";
          $count = $count + 1;
          /*echo "points.push(['" . $row['FirstName'] . "', '" . $row['LastName'] . "', '" . $row['Latitude'] . "', '" . $row['Longitude'] . "', '"
           . $row['ConnType'] . "', '" . $row['timestamp'] . "']); ";*/
        }
        echo "document.write(\"Test4\");";
        echo "document.write(table[4][5]);";
      ?>
      var i;
      for (i = 0; i < table.length; i++) {
        L.marker([table[i][2], table[i][3]]).addTo(mymap)
          .bindPopup(table[i][0]).openPopup();
      }
    </script>
  </div>
  </body>
</html>
