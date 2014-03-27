<h1>Distributors <small><?php echo count($distributors);?></small></h1>
<hr/>
<div class="row">
  <form class="form-inline" style="margin: 0;" method="POST" action="" role="form">
    <div class="col-lg-12">
      <div class="form-group">
        <select name="search[status]" class="input-sm form-control" id="status">
          <option>Status</option>
          <option <?php if ((int)$search['status'] == 1){ echo 'selected="selected"';}?> value="1">Active</option>
          <option <?php if ((int)$search['status'] == 2){ echo 'selected="selected"';}?> value="2">Inactive</option>
          <option <?php if ((int)$search['status'] == 3){ echo 'selected="selected"';}?> value="3">Pending</option>
        </select>
      </div>
      <div class="form-group">
        <select name="search[supplier]" class="input-sm form-control" id="suppliers">
          <option>Supplier</option>
          <option value="0">No supplier</option>
            <?php foreach ($suppliers as $s){?>
              <option <?php if ((int)$search['supplier'] == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[groups]" class="input-sm form-control" id="groups">
          <option>Groups</option>
          <option value="0">No group</option>
            <?php foreach ($groups as $g){?>
              <option <?php if ((int)$search['groups'] == $g->id){ echo 'selected="selected"';}?> value="<?php echo $g->id?>"><?php echo $g->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[states]" class="input-sm form-control" id="state">
          <option>State</option>
            <?php foreach ($states as $s){?>
              <option <?php if ((int)$search['states'] == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[regions]" class="input-sm form-control" id="region">
          <option>Region</option>
            <?php foreach ($regions as $r){?>
              <option <?php if ((int)$search['regions'] == $r->id){ echo 'selected="selected"';}?> value="<?php echo $r->id?>"><?php echo $r->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[company_id]" class="input-sm form-control" id="company_id">
          <option>Company Type</option>
          <option value="1" <?php if ((int)$search['company_id'] == 1){ echo 'selected="selected"';}?>>MedicalVitaDiet</option>
          <option value="2" <?php if ((int)$search['company_id'] == 2){ echo 'selected="selected"';}?>>BettyBaxter</option>
          <option value="3" <?php if ((int)$search['company_id'] == 3){ echo 'selected="selected"';}?>>Both</option>
        </select>
      </div>
      <div class="form-group">
        <input class="form-group" type="hidden" id="export" name="search[export]" value="0"/>
        <button id="search-distributors" type="submit" class="btn btn-primary btn-sm">Search</button>
      </div>
    </div>
  </form>
</div>
<hr/>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script>
var map;
var markers = [];

var distributors = [
    <?php
    $i = 0;
    foreach ($distributors as $d){
        $i++;
        echo "[".$d->id.', "'.$d->title.'", '.$d->latitude.", ".$d->longitude.", ".$d->status.', '.$d->company_id.', "'.$d->contact_name.'", "'.$d->address.' '. $d->address2. '", "'.$d->phone.'", "'.$d->zip.'", "'.$states[$d->state_id]->title.'", "'.$d->city.'"]';
        if ($i != count($distributors)){
            echo ", ";
        }
    }
    ?>];

function initialize() {
    var chicago = new google.maps.LatLng(-25.363882,131.044922);
    var infowindow = new google.maps.InfoWindow();

    var mapOptions = {
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: chicago
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    for (var i = 0; i < distributors.length; i++) {
        var distributor = distributors[i];
        var loc = new google.maps.LatLng(distributor[2],distributor[3]);
        var ico;
        if (distributor[5] == 1){
            if(distributor[4] == 1){
                ico = "mvd_active.png";
            }else{
                ico = "mvd_inactive.png";
            }
        }else{
            if(distributor[4] == 1){
                ico = "bb_active.png";
            }else{
                ico = "bb_inactive.png";
            }
        }
        var icon = "http://taursus.com/images/"+ico;
        var marker = new google.maps.Marker({
            position: loc,
            map: map,
            title: distributor[1],
            icon: icon
        });
        marker.setMap(map);

        var content = "<h1>"+distributor[1]+"</h1><p><strong>Address:</strong> "+distributor[7]+"</p><p>"+distributor[11]+", "+distributor[10]+", "+distributor[9]+"</p><p><strong>Phone:</strong> "+distributor[8]+"</p><p><strong>Contact:</strong> "+distributor[6]+"</p><p><a href='/distributors/edit/"+distributor[0]+"'>Edit</a> | <a href='/distributors/view/"+distributor[0]+"'>View</a> | <a href='/distributors/directions/"+distributor[0]+"'>Get Directions</a></p>";
        google.maps.event.addListener(marker, 'click', (function(marker, content) {
            return function() {
                infowindow.setContent(content);
                infowindow.open(map, marker);
            }
        })(marker, content));
    }

    google.maps.event.addListener(map, 'click', function(event) {
            infowindow.close();
        }
    );
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="row">
  <div class="col-lg-12">
      <div class="thumbnail" style="width: 100%; height: 600px;">
          <div id="map-canvas" style="width: 100%; height: 100%"></div>
      </div>
  </div>
</div>