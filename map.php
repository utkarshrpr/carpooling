<?php
	session_start();
if(!isset($_SESSION['id'])){
	header("Location:index.php");
}
if(!isset($_GET)){
	echo 'ERROR - 404';
	die();
}
if(!isset($_GET['source']) || !isset($_GET['via']) || !isset($_GET['destination'])){
	echo 'ERROR - 404';
	die();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>GMAPS</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #origin-input,
      #via-input,
      #destination-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
      }

      #origin-input:focus,
      #destination-input:focus {
        border-color: #4d90fe;
      }

      #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
      }

      #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

    </style>
  </head>
  <body>

    <div id="map"></div>

    <script>
      var directionsService, directionsDisplay;

      function initMap() {
        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer;

        var map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          center: {lat: 30.9755, lng: 76.5395},
          zoom: 10
        });

        directionsDisplay.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsDisplay);
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        origin = <?php echo '"'.urldecode($_GET['source']).'"' ?>;
        destination = <?php echo '"'.urldecode($_GET['destination']).'"' ?>;
        via = <?php echo '"'.urldecode($_GET['via']).'"' ?>;
        var waypts = [{
              location: via,
              stopover: true
            }];

        directionsService.route({
          origin: origin,
          destination: destination,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB82qWTjFYGu9xkvmWGFIkpcXnOjmwO6hM&libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>