<!DOCTYPE html>
  <html>
  <style>
    #mapid {  height: 300px;
      min-height: 40%;}
  </style>
  <head>
    <title>GPS Trace</title>
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

    <link rel="stylesheet" href="/css/Default.css">
			<h1>Maps and Data</h1>
  </head>

  <body>
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <div id="mapid"></div>
      </div>
    </div>
    <div class="col-sm-6">
    <script>
      //Building and placing the leaflet map with attributions
      /*var mymap = L.map('mapid').setView([34.4811761, -83.9371468], 13);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWNraXJiNTg5MyIsImEiOiJjazhtZWhvamMwaW9mM2ZuMm5tM2drM3l3In0.gAPUQPRWd6i1dsCIwBviTg', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
      }).addTo(mymap);

      var popup = L.popup();
      function onMapClick(e) {
        popup
          .setLatLng(e.latlng)
          .setContent("You clicked the map at " + e.latlng.toString())
          .openOn(mymap);
      }
      mymap.on('click', onMapClick);*/
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

        $query = "SELECT * FROM Location ORDER BY timestamp ASC";
        $result = mysqli_query($dbconnect, $query);
        $rowCnt = mysqli_num_rows($result);

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

        }
      ?>
      //Building and placing the leaflet map with attributions
      var mymap = L.map('mapid').setView(([table[0][2], table[0][3]]), 13);
      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWNraXJiNTg5MyIsImEiOiJjazhtZWhvamMwaW9mM2ZuMm5tM2drM3l3In0.gAPUQPRWd6i1dsCIwBviTg', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
      }).addTo(mymap);

      var popup = L.popup();
      function onMapClick(e) {
        popup
          .setLatLng(e.latlng)
          .setContent("You clicked the map at " + e.latlng.toString())
          .openOn(mymap);
      }
      mymap.on('click', onMapClick);
      /*Lat and long are both a ratio distance of roughly 1:69.2 miles
      69.2 miles = 365376 ft
      By setting our treshHold to 5 we are limiting our distance to 1/5th of a lat or long
      this would be a little of 13*/
      //var threshHold = 1/(365376/5);
      var i;
      var stationary = false;
      var noChange = 0;
      var changeBuffer = new Array(3);
      for(var i = 0; i < changeBuffer.length; i++){
      changeBuffer[i] = new Array(3);
      }
      for (i = 0; i < table.length; i++) {
        if(i !== 0){
          //stationary = Boolean(!(noChange < 3));
          var latTest = Boolean((Math.abs(table[i][2]-table[i-1][2])*364352.05674203555) > 5);
          var lat = Math.abs((table[i][2]-table[i-1][2])*64352.05674203555);
          var longTest = Boolean((Math.abs(table[i][3]-table[i-1][3])*364352.05674203555) > 5);
          if((latTest === true || longTest === true) && stationary === false){
            noChange = 0;
            L.marker([table[i][2], table[i][3]]).addTo(mymap)
              .bindPopup(table[i][0]).openPopup();
          }
          else if(latTest === true || longTest === true) {
            noChange--;
            changeBuffer.push([table[i][0], table[i][1], table[i][2]]);
          }
          else{
            noChange++;
            if(Array.isArray(changeBuffer) && changeBuffer.length === 0){
              changeBuffer = new Array(3);
              for(var i = 0; i < changeBuffer.length; i++){
                changeBuffer[i] = new Array(3);
            }
          }
        }
      }
        else {
          L.marker([table[i][2], table[i][3]]).addTo(mymap)
            .bindPopup(table[i][0]).openPopup();
        }
      }

      var myLines = [];
      var names = [];
      var check = false;
      for (var i = 0; i < table.length; i++) {
        check = false;
        var nameTemp = table[i][0];
        if(names.length === 0){
          names.push(nameTemp);
        }
        for (var j = 0; j < names.length; j++) {
          if(nameTemp.localeCompare(names[j])){
            check = true;
          }
        }
        if(check === true){
          names.push(nameTemp);
          check = false;
        }
      }
      for (var i = 0; i < names.length; i++) {
        drawLines(names[i], table);
      }
      function drawLines(name){
        for (var i = 0; i < table.length; i++) {
          if(i !== 0){

            //ar oldID = table[i-1][0] + " " + table[i-1][1];
            //var newID = table[i][0] + " " + table[i][1];
            //if(oldID === newID){
             //document.write(table[i][0] + " and " + name + ": ");
              /*var test = Boolean((table[i][0].toString() == name.toString()));
              document.write(test);*/
              if((table[i][0].toString() == name.toString()) && (table[i][0].toString() == table[i-1][0].toString())){
                  myLines.push({
                    "type": "LineString",
                    "coordinates": [[table[i][3], table[i][2]], [table[i-1][3], table[i-1][2]]]
                  });
               //document.write("INSIDE THE FUNCTION");
              }
              }
            }
          }
   //document.write("Back out of the loop");
      var myStyle = {
          "color": "#ff7800",
          "weight": 5,
          "opacity": 0.65
      };
      L.geoJSON(myLines, {
          style: myStyle
      }).addTo(mymap).bindPopup(table[i][0]).openPopup();

     //document.write("test1");
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(centerV);
        } else {
          x.innerHTML = "Geolocation is not supported by this browser.";
        }
      }
      function centerV(position) {
        mymap.setView(([position.coords.latitude, position.coords.longitude]), 13);
      }
    </script>
    <input type="button" onclick="getLocation()" value="center">
  </div>
  <div class="col-sm-6">

    <script>
    function showUser(str) {
      if (str=="") {
        document.getElementById("txtHint").innerHTML="";
        return;
      }
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("txtHint").innerHTML=this.responseText;
        }
      }
      xmlhttp.open("GET","userlookup.php?q="+str,true);
      xmlhttp.send();
    }
    </script>

    <form>
    <select id="mySelect" name="users" onchange="showUser(this.value)">
    <option value="">Select a person:</option>
    </select>
    </form>
    <br>
    <div id="txtHint"><b>Person info will be listed here.</b></div>

    <script>

      select = document.getElementById('mySelect');

      for (var i = 0; i < names.length; i++) {
          var opt = document.createElement('option');
          opt.value = "" + names[i];
          opt.innerHTML = "" + names[i];
          select.appendChild(opt);
      }
    </script>
  </div>
  </body>
</html>
