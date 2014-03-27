<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
		var map;
		var markers = [];

		function initialize() {
		  var haightAshbury = new google.maps.LatLng(-25.363882, 131.044922);
		  var mapOptions = {
		    zoom: 4,
		    center: haightAshbury,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  map = new google.maps.Map(document.getElementById('map-canvas'),
		      mapOptions);
			<?php if ($d->longitude != '' && $d->latitude != ''){?>
				var loc = new google.maps.LatLng(<?php echo $d->latitude?>, <?php echo $d->longitude?>);
				var marker = new google.maps.Marker({
				    position: loc,
				    map: map
				});
				markers.push(marker); 
			<?php }?>

		  google.maps.event.addListener(map, 'click', function(event) {
			deleteMarkers();
		    addMarker(event.latLng);
		    document.getElementById('lat').value = event.latLng.ob;
		    document.getElementById('long').value = event.latLng.pb;
		    document.getElementById('status').innerHTML = "Coordinates are set successfully!";
		    var d = document.getElementById('status');
			d.className = d.className + " alert-success";
		  });
		}

		// Add a marker to the map and push to the array.
		function addMarker(location) {
		  var marker = new google.maps.Marker({
		    position: location,
		    map: map
		  });
		  markers.push(marker);
		}

		// Sets the map on all markers in the array.
		function setAllMap(map) {
		  for (var i = 0; i < markers.length; i++) {
		    markers[i].setMap(map);
		  }
		}

		// Removes the markers from the map, but keeps them in the array.
		function clearMarkers() {
		  setAllMap(null);
		}


		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
		  clearMarkers();
		  markers = [];
		}

		google.maps.event.addDomListener(window, 'load', initialize);

		$(window).ready(function(){
        $('#submit').on('click', function(e){
            e.preventDefault();
            findLocation(true);
        });
		$('#inputAddress').focusout(function(){
			findLocation();
		});
		$('#inputAddress2').focusout(function(){
			findLocation();
		});
		$('#inputTown').focusout(function(){
			findLocation();
		});
	});

	function findLocation(submit){
		var address = $('#inputAddress').val() + ' ' + $('#inputAddress2').val();
		var town = $('#inputTown').val();
		var state = $('#inputState option:selected').text();

		if (address != '' && town != ''){
			var request = address + ', ' + town +', ' + state + ', AU';
			$.ajax({
			  type: "POST",
			  url: "/distributors/ajax",
			  data: { name: "geo", request: request },
			  dataType: "JSON",
			  success: function(data){
			  	console.log(data);
			  	var geo_lat = data.results[0].geometry.location.lat;
			  	var geo_lng = data.results[0].geometry.location.lng;
			  	var found_loc = new google.maps.LatLng(geo_lat, geo_lng);
				deleteMarkers();
			    addMarker(found_loc);
			    map.setCenter(found_loc);
			    map.setZoom(19);
			    $('#lat').val(geo_lat);
			    $('#long').val(geo_lng);
			    $('#status').addClass('alert-success').html("Coordinates are set successfully!");
                if (submit == true){
                    $('form').submit();
                }
			  }
			});
		}
	}
</script>

<h1>Add new Distributor</h1>
<div class="span5">
	<h2>Setup base information</h2>
	<form class="form-horizontal" action="" method="POST">
    <div class="control-group">
      <label class="control-label" for="inputStatus">Status</label>
      <div class="controls">
        <select name="data[status]" id="inputStatus">
          <option <?php if ($d->status == 1){ echo 'selected="selected"';}?> value="1">Active</option>
          <option <?php if ($d->status == 2){ echo 'selected="selected"';}?> value="2">Inactive</option>
          <option <?php if ($d->status == 3){ echo 'selected="selected"';}?> value="3">Pending</option>
        </select>
      </div>
    </div>
	  <div class="control-group">
	    <label class="control-label" for="inputPro">Professional Category</label>
	    <div class="controls">
	      <select name="data[pro]" id="inputPro">
	      	<option value="0">No professional category</option>
          <?php foreach ($professional as $pro){?>
            <option <?php if ($d->professional_id == $pro->id){ echo 'selected="selected"';}?> value="<?php echo $pro->id?>"><?php echo $pro->title;?></option>
          <?php }?>
	      </select>
	      <a href="/distributors/professional" class="btn btn-primary btn-mini">+</a>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputSupplier">Supplier of Stockist</label>
	    <div class="controls">
	      <select name="data[supplier]" id="inputSupplier">
	      	<option value="0">No supplier</option>
          <?php foreach ($suppliers as $s){?>
            <option <?php if ($d->supplier_id == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
          <?php }?>
	      </select>
	      <a href="/distributors/suppliers" class="btn btn-primary btn-mini">+</a>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputGroup">Group Name</label>
	    <div class="controls">
	      <select name="data[group]" id="inputGroup">
	      	<option value="0">No group</option>
          <?php foreach ($groups as $g){?>
            <option <?php if ($d->group_id == $g->id){ echo 'selected="selected"';}?> value="<?php echo $g->id?>"><?php echo $g->title;?></option>
          <?php }?>
	      </select>
	      <a href="/distributors/groups" class="btn btn-primary btn-mini">+</a>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputName">Store Name</label>
	    <div class="controls">
	      <input name="data[name]" type="text" id="inputName" value="<?php echo $d->title?>" placeholder="Store Name" required>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputOwner">Owner's Name</label>
	    <div class="controls">
	      <input name="data[oname]" type="text" id="inputOwner" value="<?php echo $d->owner_name?>" placeholder="Owner's Name">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputContact">Contact Name</label>
	    <div class="controls">
	      <input name="data[cname]" type="text" id="inputContact" value="<?php echo $d->contact_name?>" placeholder="Contact Name">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputAddress">Address</label>
	    <div class="controls">
	      <input name="data[address]" type="text" id="inputAddress" value="<?php echo $d->address?>" placeholder="Address" required>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputAddress">Address 2</label>
	    <div class="controls">
	      <input name="data[address2]" type="text" id="inputAddress2" value="<?php echo $d->address2?>" placeholder="Address 2">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputTown">Suburb/Town</label>
	    <div class="controls">
	      <input name="data[town]" type="text" id="inputTown" value="<?php echo $d->city?>" placeholder="Suburb/Town" required>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputState">State</label>
	    <div class="controls">
	      <select name="data[state]" id="inputState">
	      	<?php foreach ($states as $s){?>
            <option <?php if ($d->state_id == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
          <?php }?>
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputRegion">Region</label>
	    <div class="controls">
	      <select name="data[region]" id="inputRegion">
          <?php foreach ($regions as $r){?>
            <option <?php if ($d->region_id == $r->id){ echo 'selected="selected"';}?> value="<?php echo $r->id?>"><?php echo $r->title;?></option>
          <?php }?>
	      </select>
	      <a href="/distributors/regions" class="btn btn-primary btn-mini">+</a>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputPostcode">Postcode</label>
	    <div class="controls">
	      <input name="data[postcode]" type="text" id="inputPostcode" value="<?php echo $d->zip?>" placeholder="Postcode">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputEmail">Email</label>
	    <div class="controls">
	      <input name="data[email]" type="text" id="inputEmail" value="<?php echo $d->email?>" placeholder="Email" required>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputPhone">Phone</label>
	    <div class="controls">
	      <input name="data[phone]" type="text" id="inputPhone" value="<?php echo $d->phone?>" placeholder="Phone" required>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputFax">Fax</label>
	    <div class="controls">
	      <input name="data[fax]" type="text" id="inputFax" value="<?php echo $d->fax?>" placeholder="Fax">
	    </div>
	  </div>
    <div class="control-group">
      <label class="control-label" for="inputApi">API Number</label>
      <div class="controls">
        <input name="data[api]" type="text" id="inputApi" value="<?php echo $d->api?>" placeholder="API Number" required>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="inputCtype">Company Type</label>
      <div class="controls">
        <select name="data[company_id]" id="inputCtype">
          <option <?php if ($d->company_id == 1){ echo 'selected="selected"'; }?> value="1">MedicalVitaDiet</option>
          <option <?php if ($d->company_id == 2){ echo 'selected="selected"'; }?> value="2">BettyBaxter</option>
          <option <?php if ($d->company_id == 3){ echo 'selected="selected"'; }?> value="3">Both</option>
        </select>
      </div>
    </div>
	  <div class="control-group">
	    <div class="controls">
	      <a href="#" id="submit" class="btn">Save Changes</a>
	      <a style="margin-left: 28px" href="/distributors/list" class="btn">Cancel</a>
	    </div>
	  </div>

	  <!-- Coordinates -->
	  <input type="hidden" name="data[lat]" value="<?php echo $d->latitude?>" id="lat" />
	  <input type="hidden" name="data[long]" value="<?php echo $d->longitude?>" id="long" />
	</form>
</div>
<div class="span6">
	<h2>Setup location</h2>
	<ul class="thumbnails">
		<li class="thumbnail" style="width: 100%;">
			<div id="map-canvas" style="width: 100%; height: 470px;"></div>
		</li>
	</ul>
	<span id="status" style="width: 100%;" class="alert <?php if ($d->longitude != '' && $d->latitude != ''){?>alert-success<?php }?>"><?php if ($d->longitude != '' && $d->latitude != ''){?>Coordinates are set successfully!<?php }else{?>Coordinates are not set.<?php }?></span>
</div>

