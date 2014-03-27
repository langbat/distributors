<h1>Routes map</h1>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var chicago = new google.maps.LatLng(-25.363882,131.044922);
        var mapOptions = {
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: chicago
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        directionsDisplay.setMap(map);
    }

    var route_array = [<?php
        $i = 0;
        foreach ($result as $r){
            $i++;
            echo "[";
            $j = 0;
            $count_d = count($r['distributors']);
            foreach ($r['distributors'] as $d){
                $j++;
                echo "[".$d->latitude.", ".$d->longitude."]";
                if ($count_d != $j){
                    echo ', ';
                }
            }
            if ($count == $i){
                echo "]";
            }else{
                echo "], ";
            }
        }?>];
    $(window).ready(function(){
        var start;
        var end;
        route_array.forEach(function(route, route_index, route_array){
            var waypoints = [];
            route.forEach(function(distributor, distributor_index, distributor_array){
                var lt;
                distributor.forEach(function(coordinate, coordinate_index, coordinate_array){
                    var point;
                    if(coordinate_index == 0){
                        lt = coordinate;
                    }else{
                        var loc = new google.maps.LatLng(lt,coordinate);
                        point = {
                            location: loc
                        };

                        if (distributor_index == 0){
                            start = loc;
                        }else if(distributor_index == route.length-1){
                            end = loc;
                        }else{
                            waypoints.push(point);
                        }
                    }
                });
            });
            //console.log(start); console.log(end);
            calcRoute(start, end, waypoints);
            //console.log(waypoints);
        });
    });





    function calcRoute(start, end, waypts) {
        var request = {
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<ul class="thumbnails">
    <li class="thumbnail" style="width: 1158px; height: 600px;">
        <div id="map-canvas" style="width: 100%; height: 100%"></div>
    </li>
</ul>