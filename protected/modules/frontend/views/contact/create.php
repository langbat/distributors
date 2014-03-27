<div class="col-lg-12"><h1>Create new contact log</h1></div>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="/js/jquery.ajaxupload.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/blitzer/jquery-ui.min.css"/>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
<![endif]-->
<script type="text/javascript">
	$(window).ready(function(){
		$('#inputDate').datepicker({
			dateFormat: 'yy-mm-dd',
		});
	});
</script>
<script type="text/javascript">
	jQuery(function ($) {
        // Set fieldname
        $.ajaxUploadSettings.name = 'uploads[]';
        // Set promptzone
        $('#outside a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'outside'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#outside').find('input').val(data['filename']);
		        $('#outside').find('img').attr('src', data['file']);
	        }
        });
        $('#before a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'before'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#before').find('input').val(data['filename']);
		        $('#before').find('img').attr('src', data['file']);
	        }
        });
        $('#after a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'after'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#after').find('input').val(data['filename']);
		        $('#after').find('img').attr('src', data['file']);
	        }
        });
        $('#display a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'display'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#display').find('input').val(data['filename']);
		        $('#display').find('img').attr('src', data['file']);
	        }
        });
        $('#optional a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'optional'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#optional').find('input').val(data['filename']);
		        $('#optional').find('img').attr('src', data['file']);
	        }
        });
        $('#staff a').ajaxUploadPrompt({
        	method : 'POST',
        	data: {"photo": 'staff'},
		    processData: false,
		    contentType: 'application/json',
	        url : '/contact/upload',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#staff').find('input').val(data['filename']);
		        $('#staff').find('img').attr('src', data['file']);
	        }
        });
	});
</script>
<form class="form" action="" role="form" method="POST">
	<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-5 col-sm-12">
			<div class="form-group">
				<label class="control-label" for="inputName">Store Name</label>
				<div class="controls">
					<input class="form-control" name="data[store_id]" type="text" id="inputName" value="<?php echo $distributor->title;?>" disabled="disabled">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputDate">Date</label>
				<div class="controls">
					<input class="form-control" name="data[log_date]" type="text" id="inputDate" value="<?php echo date('Y-m-d');?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputMethod">Contact Method</label>
				<div class="controls">
					<select class="form-control" name="data[contact_method]" id="inputMethod">
						<option value="1">Visited</option>
						<option value="2">Phoned</option>
						<option value="3">Received a call from</option>
						<option value="4">Cold Called</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputReason">Contact Reason</label>
				<div class="controls">
					<select class="form-control" name="data[contact_reason]" id="inputReason">
						<option value="1">Training & Merchandising</option>
						<option value="2">Courtesy Call</option>
						<option value="3">Returning Call</option>
						<option value="4">Store phoned office</option>
						<option value="5">Merchandising</option>
						<option value="6">Other</option>
						<option value="7">Cold Call</option>
						<option value="8">Training</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-7 col-sm-12">
			<label class="control-label" style="text-align: left;" for="inputComment">Contact Comment</label>
			<textarea class="form-control" name="data[contact_comment]" rows="7" required></textarea>
		</div>
	</div>
	</div>
	<div id="photos" class="col-lg-12" style="margin-top: 30px;">
	    <h2>Photos (optional)</h2>
	    <div class="row">
	        <div id="outside" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[outside]" value="">
	            <div align="center"><strong>Outside</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="before" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[before]" value="">
	            <div align="center"><strong>Before</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="after" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[after]" value="">
	            <div align="center"><strong>After</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="display" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[display]" value="">
	            <div align="center"><strong>Display 1</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="optional" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[optional]" value="">
	            <div align="center"><strong>Optional</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="staff" class="col-lg-2 col-sm-2">
	        	<input type="hidden" name="photos[staff]" value="">
	            <div align="center"><strong>Staff</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	    </div>
	</div>
	<div>
		<div class="col-lg-12 text-center" style="margin-bottom: 20px;">
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Add Contact Log</button>
			<button type="submit" name="data[action]" value="draft" class="btn">Save Draft</button>
		</div>
	</div>
</form>