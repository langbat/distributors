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
					<input class="form-control" name="data[log_date]" type="text" id="inputDate" value="<?php echo date('Y-m-d', strtotime($contact_log->log_date));?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputMethod">Contact Method</label>
				<div class="controls">
					<select class="form-control" name="data[contact_method]" id="inputMethod">
						<option <?php if ($contact_log->contact_method == 1){ echo 'selected="selected"';}?> value="1">Visited</option>
						<option <?php if ($contact_log->contact_method == 2){ echo 'selected="selected"';}?> value="2">Phoned</option>
						<option <?php if ($contact_log->contact_method == 3){ echo 'selected="selected"';}?> value="3">Received a call from</option>
						<option <?php if ($contact_log->contact_method == 4){ echo 'selected="selected"';}?> value="4">Cold Called</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputReason">Contact Reason</label>
				<div class="controls">
					<select class="form-control" name="data[contact_reason]" id="inputReason">
						<option <?php if ($contact_log->contact_reason == 1){ echo 'selected="selected"';}?> value="1">Training & Merchandising</option>
						<option <?php if ($contact_log->contact_reason == 2){ echo 'selected="selected"';}?> value="2">Courtesy Call</option>
						<option <?php if ($contact_log->contact_reason == 3){ echo 'selected="selected"';}?> value="3">Returning Call</option>
						<option <?php if ($contact_log->contact_reason == 4){ echo 'selected="selected"';}?> value="4">Store phoned office</option>
						<option <?php if ($contact_log->contact_reason == 5){ echo 'selected="selected"';}?> value="5">Merchandising</option>
						<option <?php if ($contact_log->contact_reason == 6){ echo 'selected="selected"';}?> value="6">Other</option>
						<option <?php if ($contact_log->contact_reason == 7){ echo 'selected="selected"';}?> value="7">Cold Call</option>
						<option <?php if ($contact_log->contact_reason == 8){ echo 'selected="selected"';}?> value="8">Training</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-7 col-sm-12">
			<label class="control-label" style="text-align: left;" for="inputComment">Contact Comment</label>
			<textarea class="form-control" name="data[contact_comment]" rows="7" required><?php echo $contact_log->contact_comment?></textarea>
		</div>
	</div>
	</div>
	<div class="col-lg-12">
	<div id="photos" class="row" style="margin-top: 30px;">
	    <h2>Photos (optional)</h2>
	    <div class="row-fluid">
	        <div id="outside" class="col-lg-2">
	        	<input type="hidden" name="photos[outside]" value="">
	            <div align="center"><strong>Outside</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="before" class="col-lg-2">
	        	<input type="hidden" name="photos[before]" value="">
	            <div align="center"><strong>Before</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="after" class="col-lg-2">
	        	<input type="hidden" name="photos[after]" value="">
	            <div align="center"><strong>After</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="display" class="col-lg-2">
	        	<input type="hidden" name="photos[display]" value="">
	            <div align="center"><strong>Display 1</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="optional" class="col-lg-2">
	        	<input type="hidden" name="photos[optional]" value="">
	            <div align="center"><strong>Optional</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	        <div id="staff" class="col-lg-2">
	        	<input type="hidden" name="photos[staff]" value="">
	            <div align="center"><strong>Staff</strong></div>
	            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        </div>
	    </div>
	</div>
	</div>
	<div class="col-lg-12" style="text-align: center;">
		<button type="submit" name="data[action]" value="save" class="btn btn-primary">Edit Contact Log</button>
		<?php if ($contact_log->status == 0){?>
			<button type="submit" name="data[action]" value="draft" class="btn">Save Draft</button>
		<?php }?>
	</div>
</form>