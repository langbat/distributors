<?php
    $methods = array(
        1 => 'Visited',
        2 => 'Phoned',
        3 => 'Received a call from',
        4 => 'Cold Called'
    );
    $reasons = array(
        1 => 'Training & Merchandising',
        2 => 'Courtesy Call',
        3 => 'Returning Call',
        4 => 'Store phoned office',
        5 => 'Merchandising',
        6 => 'Other',
        7 => 'Cold Call',
        8 => 'Training'
    );
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script src="https://google-maps-utility-library-v3.googlecode.com/svn/trunk/geolocationmarker/src/geolocationmarker-compiled.js"></script>
<link href="/css/ekko-lightbox.css" rel="stylesheet">
<link href="/css/ekko-dark.css" rel="stylesheet">
<script>
    var map, GeoMarker;
    var markers = [];
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var initialLocation;

    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var haightAshbury = new google.maps.LatLng(<?php echo $distributor->latitude?>, <?php echo $distributor->longitude?>);
        var mapOptions = {
            zoom: 12,
            center: haightAshbury,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);



        var loc = new google.maps.LatLng(<?php echo $distributor->latitude?>, <?php echo $distributor->longitude?>);
        var marker = new google.maps.Marker({
            position: loc,
            map: map
        });
        markers.push(marker);



        GeoMarker = new GeolocationMarker();
        GeoMarker.setCircleOptions({fillColor: '#808080'});

        google.maps.event.addListener(GeoMarker, 'geolocation_error', function(e) {
            //alert('There was an error obtaining your position. Message: ' + e.message);
        });

        GeoMarker.setMap(map);

        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            }, function() {});
        }


        directionsDisplay.setMap(map);
    }

    function calcRoute() {
        var start = initialLocation;
        var end = new google.maps.LatLng(<?php echo $distributor->latitude?>, <?php echo $distributor->longitude?>);
        console.log(start);
        console.log(end);
        var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            console.log(status);
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    //calcRoute();
</script>
<h1><?php echo $distributor->title?></h1>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h3><?php echo $distributor->address;?></h3>
        <h3><?php echo $distributor->address2;?></h3>
        <div class="row">
            <div class="col-lg-6">
                <p><strong>Region:</strong> <?php if ($region != '') echo $region->title; ?></p>
            </div>
            <div class="col-lg-6 last">
                <p><strong>State:</strong> <?php echo $state->title; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p><strong>City:</strong> <?php echo $distributor->city; ?></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <p><strong>API #:</strong> <?php echo $distributor->api; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p><strong>Phone:</strong> <?php echo $distributor->phone; ?></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <p><strong>Fax:</strong> <?php echo $distributor->fax; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p><strong>Email:</strong> <a href="mailto:<?php echo $distributor->email; ?>"><?php echo $distributor->email; ?></a></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <p><strong>Professional Group:</strong> <?php if ($pro != '') echo $pro->title; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p><strong>Group:</strong> <?php if ($group != '') echo $group->title; ?></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <p><strong>Supplier:</strong> <?php if ($supplier != '') echo $supplier->title; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p><strong>Owner's Name:</strong> <?php echo $distributor->owner_name; ?></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <p><strong>Contact:</strong> <?php echo $distributor->contact_name; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <?php if (is_array($trading_hours = CJSON::decode($distributor->trading_hours))){?>
                    <p><strong>Trading Hours:</strong></p>
                    <?php foreach ($trading_hours as $key => $value){?>
                        <p><?php echo $key;?>: <?php echo $value['start'];?> - <?php echo $value['end'];?></p>
                    <?php }?>
                <?php }else{?>
                    <p><strong>Trading Hours:</strong> <?php echo nl2br($distributor->trading_hours); ?></p>
                <?php }?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-warning" href="/distributors/edit/<?php echo $distributor->id?>">Edit Distributor</a>
                <a class="btn btn-success" href="/contact/create/<?php echo $distributor->id?>">Create Contact Log</a>
                <a class="btn btn-success" href="/orders/add/<?php echo $distributor->id?>">Create Order</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="thumbnail"><a href="<?php echo $photos[1]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="Outside"><img class="img-rounded" src="<?php echo $photos[1]; ?>"/></a></div>
    </div>
</div>
<div id="photos" class="row" style="margin-top: 30px;">
    <h2>Photos</h2>
    <div class="row-fluid">
        <div style="width: 20%; float: left;">
            <div align="center"><strong>Before</strong></div>
            <a class="thumbnail" href="<?php echo $photos[2]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="Before" style="margin-right: 10px;"><img class="img-rounded" src="<?php echo $photos[2]; ?>"/></a>
        </div>
        <div style="width: 20%; float: left;">
            <div align="center"><strong>After</strong></div>
            <a class="thumbnail" href="<?php echo $photos[3]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="After" style="margin-right: 10px;"><img class="img-rounded" src="<?php echo $photos[3]; ?>"/></a>
        </div>
        <div style="width: 20%; float: left;">
            <div align="center"><strong>Display 1</strong></div>
            <a class="thumbnail" href="<?php echo $photos[4]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="Display 1" style="margin-right: 10px;"><img class="img-rounded" src="<?php echo $photos[4]; ?>"/></a>
        </div>
        <div style="width: 20%; float: left;">
            <div align="center"><strong>Optional</strong></div>
            <a class="thumbnail" href="<?php echo $photos[5]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="Optional" style="margin-right: 10px;"><img class="img-rounded" src="<?php echo $photos[5]; ?>"/></a>
        </div>
        <div style="width: 20%; float: left;">
            <div align="center"><strong>Staff</strong></div>
            <a class="thumbnail" href="<?php echo $photos[6]; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="Staff"><img class="img-rounded" src="<?php echo $photos[6]; ?>"/></a>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 30px;">
    <div class="col-lg-12">
        <h2>Contact Logs</h2>
        <table class="table table-striped table-hover" style="width: 100%;">
            <thead>
            <tr>
                <th>Date</th>
                <th>Representative</th>
                <th>Contact method</th>
                <th>Contact reason</th>
                <th>Comment</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($contact_logs){?>
                <?php foreach ($contact_logs as $log){?>
                    <tr>
                        <td style="text-align: center;"><?php echo date("d", strtotime($log->log_date)); ?><br/><?php echo date("F ", strtotime($log->log_date)); ?><br/><?php echo date("Y ", strtotime($log->log_date)); ?></td>
                        <td><a href="/users/profile/<?php echo $log->user_id?>"><?php echo $users[$log->user_id]; ?></a></td>
                        <td><?php echo $methods[$log->contact_method]; ?></td>
                        <td><?php echo $reasons[$log->contact_reason]; ?></td>
                        <td><?php echo $log->contact_comment; ?></td>
                        <td style="text-align: right;">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Actions
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="text-align: left;">
                                    <li><a href="/contact/view/<?php echo $log->id?>" id="view"><i class="icon-eye-open"></i> View</a></li>
                                    <li><a href="/contact/edit/<?php echo $log->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                                    <li><a href="/contact/delete/<?php echo $log->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<div class="row" style="margin-top: 30px;">
    <div class="col-lg-12">
        <h2>Orders</h2>
        <table class="table table-striped table-hover" style="width: 100%;">
            <thead>
            <tr>
                <th>Status</th>
                <th>Date</th>
                <th>Store</th>
                <th>Representative</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($orders){?>
                <?php foreach ($orders as $order){?>
                    <tr>
                        <td>
                          <?php if($order->status == 1){
                              echo '<span class="label label-success">Processed</span>';
                          }else{
                              echo '<span class="label label-info">Pending</span>';
                          }
                          ?>
                        </td>
                        <td style="text-align: left;"><?php echo date("d", strtotime($order->date)); ?> - <?php echo date("F ", strtotime($order->date)); ?> - <?php echo date("Y ", strtotime($order->date)); ?></td>
                        <td>
                            <a href="/distributors/view/<?php echo $order->distributor_id?>"><?php echo $distributor->title;?></a>
                        </td>
                        <td><a href="/users/profile/<?php echo $order->user_id?>"><?php echo $users[$order->user_id]; ?></a></td>
                        <td>$<?php echo $order->total?></td>
                        <td style="text-align: right;">
                            <div class="btn-group">
                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                    Actions
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="text-align: left;">
                                    <li><a href="/orders/view/<?php echo $order->id?>" id="view"><i class="icon-eye-open"></i> View</a></li>
                                    <li><a href="/orders/delete/<?php echo $order->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<div class="row" style="margin-top: 30px; margin-bottom: 30px;">
    <div class="col-lg-12">
        <h2>Map and directions</h2>
        <div class="thumbnail">
            <div id="map-canvas" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>

<script src="/js/ekko-lightbox.js"></script>

<script type="text/javascript">
    $(document).ready(function ($) {
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox();
        });
    });
</script>