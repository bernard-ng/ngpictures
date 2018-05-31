<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
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
    </style>
</head>
<body>
<div id="map"></div>
<script>
    let map;
    let marker;
    let position = {lat: -11.6876026, lng: 27.5026174};
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: position,
            zoom: 18
        });
        marker = new google.maps.Marker({position: position, map: map});
    }


    //recupere la position d'un user
        /*if (navigator.geolocation) {
        var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };

        function success(pos) {
            let position = {
                lat: pos.cords.latitude,
                lng: pos.coords.longitude
            };

            infoWindow.setPosition(position);
            infoWindow.setContent('Location found.');
            map.setCenter(position);
        };

        function error(err) {
            handleLocationError(true, infoWindow, map.getCenter());
        };

        navigator.geolocation.getCurrentPosition(success, error, options);
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }*/
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= MAPS_API_KEY ?>&callback=initMap"
        async defer></script>
</body>
</html>