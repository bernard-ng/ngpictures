<!DOCTYPE html>
<html>
    <head>
        <title>Localisation | Ngpictures</title>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <?php include(APP . "/Views/includes/default-style.twig"); ?>
        <style>
        #map {
            width: 100%;
            height: 100vh;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    </head>
    <body>
        <map id="map"></map>
        <div class="fixed-action-btn">
            <a href="/maps" class="btn-floating btn-large waves-effect shadow-4">
                <i class="icon icon-location"></i>
            </a>
        </div>
        <script>
            let map;
            let position = {lat: -11.6876026, lng: 27.5026174};

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: position,
                    zoom: 18
                });

                (new google.maps.Marker({position: position, map: map}));
                (new google.maps.Marker({position: position, map: map}));
            }

            /*if (navigator.geolocation) {
                let options = {
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
                handleLocationError(false, infoWindow, map.getCenter());
            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            }*/
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?= MAPS_API_KEY ?>&callback=initMap" async defer></script>
    </body>
</html>