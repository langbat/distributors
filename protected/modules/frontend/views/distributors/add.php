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
		$('#inputAddress').focusout(function(){
			findLocation();
		});
		$('#inputAddress2').focusout(function(){
			findLocation();
		});
		$('#inputTown').focusout(function(){
			findLocation();
		});

		$('#worktime input[type="checkbox"]').on('click', function(){
			if ($(this).is(':checked')){
				//alert('checked');
				$(this).parent('div').find('input[type="text"]').prop('disabled', false);
			}else{
				//alert('unchecked');
				$(this).parent('div').find('input[type="text"]').prop('disabled', true);
			}
		});
	});

	function findLocation(){
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
			  	var geo_lat = data.results[0].geometry.location.lat;
			  	var geo_lng = data.results[0].geometry.location.lng; 
			  	console.log(data);
			  	var found_loc = new google.maps.LatLng(geo_lat, geo_lng);
				deleteMarkers();
			    addMarker(found_loc);
			    map.setCenter(found_loc);
			    map.setZoom(19);
			    $('#lat').val(geo_lat);
			    $('#long').val(geo_lng);
			    $('#status').addClass('alert-success').html("Coordinates are set successfully!");
			  }
			});
		}
	}
</script>
<form class="form-horizontal" role="form" action="" method="POST">
	<h1>Add new Distributor</h1>
	<div class="col-lg-5">
		<h2>Setup base information</h2>
	    <div class="form-group">
	      <label class="col-sm-5 control-label" for="inputStatus">Status</label>
	      <div class="col-sm-7">
	        <select class="form-control" name="data[status]" id="inputStatus">
	          <option value="1">Active</option>
	          <option value="2">Inactive</option>
	          <option value="3">Pending</option>
	        </select>
	      </div>
	    </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputPro">Professional Category</label>
		    <div class="col-sm-7">
		      <select class="form-control" name="data[pro]" id="inputPro">
		      	<option value="0">No professional category</option>
	          <?php foreach ($professional as $pro){?>
	            <option value="<?php echo $pro->id?>"><?php echo $pro->title;?></option>
	          <?php }?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputSupplier">Supplier of Stockist</label>
		    <div class="col-sm-7">
		      <select class="form-control" name="data[supplier]" id="inputSupplier">
		      	<option value="0">No supplier</option>
	          <?php foreach ($suppliers as $s){?>
	            <option value="<?php echo $s->id?>"><?php echo $s->title;?></option>
	          <?php }?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputGroup">Group Name</label>
		    <div class="col-sm-7">
		      <select class="form-control" name="data[group]" id="inputGroup">
		      	<option value="0">No group</option>
	          <?php foreach ($groups as $g){?>
	            <option value="<?php echo $g->id?>"><?php echo $g->title;?></option>
	          <?php }?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputName">Store Name</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[name]" type="text" id="inputName" placeholder="Store Name" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputOwner">Owner's Name</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[oname]" type="text" id="inputOwner" placeholder="Owner's Name">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputContact">Contact Name</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[cname]" type="text" id="inputContact" placeholder="Contact Name">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputAddress">Address</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[address]" type="text" id="inputAddress" placeholder="Address" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputAddress">Address 2</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[address2]" type="text" id="inputAddress2" placeholder="Address 2">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputTown">Suburb/Town</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[town]" type="text" id="inputTown" placeholder="Suburb/Town" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputState">State</label>
		    <div class="col-sm-7">
		      <select class="form-control" name="data[state]" id="inputState">
		      	<?php foreach ($states as $s){?>
	            <option value="<?php echo $s->id?>"><?php echo $s->title;?></option>
	          <?php }?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputRegion">Region</label>
		    <div class="col-sm-7">
		      <select class="form-control" name="data[region]" id="inputRegion">
	          <?php foreach ($regions as $r){?>
	            <option value="<?php echo $r->id?>"><?php echo $r->title;?></option>
	          <?php }?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputPostcode">Postcode</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[postcode]" type="text" id="inputPostcode" placeholder="Postcode">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputEmail">Email</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[email]" type="text" id="inputEmail" placeholder="Email" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputPhone">Phone</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[phone]" type="text" id="inputPhone" placeholder="Phone" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-5 control-label" for="inputFax">Fax</label>
		    <div class="col-sm-7">
		      <input class="form-control" name="data[fax]" type="text" id="inputFax" placeholder="Fax">
		    </div>
		  </div>
	    <div class="form-group">
	      <label class="col-sm-5 control-label" for="inputApi">API Number</label>
	      <div class="col-sm-7">
	        <input class="form-control" name="data[api]" type="text" id="inputApi" placeholder="API Number" required>
	      </div>
	    </div>
	    <div class="form-group">
	      <label class="col-sm-5 control-label" for="inputCtype">Company Type</label>
	      <div class="col-sm-7">
	        <select class="form-control" name="data[company_id]" id="inputCtype">
	          <option value="1">MedicalVitaDiet</option>
	          <option value="2">BettyBaxter</option>
	          <option value="3">Both</option>
	        </select>
	      </div>
	    </div>
		<div class="form-group">
			<div class="col-sm-offset-5 col-sm-7">
				<button type="submit" class="btn btn-primary">Add Distributor</button>
			</div>
		</div>

		  <!-- Coordinates -->
		  <input type="hidden" name="data[lat]" value="" id="lat" />
		  <input type="hidden" name="data[long]" value="" id="long" />
	</div>
	<div class="col-lg-6 col-lg-offset-1">
		<h2>Setup location</h2>
		<div class="thumbnail col-sm-12">
			<div id="map-canvas" style="width: 100%; height: 470px;"></div>
		</div>
		<div class="col-sm-12 text-center">
			<span id="status" style="width: 100%;" class="alert">Coordinates are not set.</span>
		</div>
		<br/><br/>
		<h2>Trading Hours</h2>

	    <div class="form-group" id="worktime">
	      <div class="col-sm-12">
	        <input name="data[monday]" type="checkbox" id="inputMonday">
	      	<label class="control-label" for="inputMonday">Monday</label>
	      	<span> from </span>
	      	<input name="data[monday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[monday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[tuesday]" type="checkbox" id="inputTuesday">
	      	<label class="control-label" for="inputTuesday">Tuesday</label>
	      	<span> from </span>
	      	<input name="data[tuesday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[tuesday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[wednesday]" type="checkbox" id="inputWednesday">
	      	<label class="control-label" for="inputWednesday">Wednesday</label>
	      	<span> from </span>
	      	<input name="data[wednesday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[wednesday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[thursday]" type="checkbox" id="inputThursday">
	      	<label class="control-label" for="inputThursday">Thursay</label>
	      	<span> from </span>
	      	<input name="data[thursday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[thursday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[friday]" type="checkbox" id="inputFriday">
	      	<label class="control-label" for="inputFriday">Friday</label>
	      	<span> from </span>
	      	<input name="data[friday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[friday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[saturday]" type="checkbox" id="inputSaturday">
	      	<label class="control-label" for="inputSaturday">Saturday</label>
	      	<span> from </span>
	      	<input name="data[saturday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[saturday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	      <div class="col-sm-12">
	        <input name="data[sunday]" type="checkbox" id="inputSunday">
	      	<label class="control-label" for="inputSunday">Sunday</label>
	      	<span> from </span>
	      	<input name="data[sunday_start]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="08:00" type="text"/>
	      	<span> to </span>
	      	<input name="data[sunday_end]" class="form-control" disabled="disabled" style="width: 62px; display: inline-block; margin: 0 6px;" placeholder="23:00" type="text"/>
	      </div>
	    </div>
	</div>
</form>
