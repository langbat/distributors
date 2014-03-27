<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="/js/jquery.ajaxupload.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/blitzer/jquery-ui.min.css"/>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
<![endif]-->
<script type="text/javascript">
	jQuery(function($) {
        // Set fieldname
        $.ajaxUploadSettings.name = 'uploads[]';
        // Set promptzone
        $('#photo').ajaxUploadPrompt({
        	method : 'POST',
		    processData: false,
		    contentType: 'application/json',
	        url : '/products/photo',
	        beforeSend : function () {
	        },
	        onprogress : function (e) {
	        },
	        error : function () {
	        },
	        success : function (data) {
		        data = $.parseJSON(data);
		        $('#photo').find('input').val(data['filename']);
		        $('#photo').find('img').attr('src', data['file']);
	        }
        });
	});
</script>

<div class="col-lg-12 clearfix">
	<h1>Create new product</h1>
	<form class="form-horizontal" action="" method="POST" role="form">
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="inputCategory">Category</label>
				<div class="controls">
					<select class="form-control" name="data[category_id]" id="inputCategory">
						<?php foreach($categories as $cat){?>
							<option value="<?php echo $cat->id;?>"><?php echo $cat->title;?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputApiPde">API PDE</label>
				<div class="controls">
					<input class="form-control" name="data[api_pde]" type="text" id="inputApiPde" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputCompanyPde">Company PDE</label>
				<div class="controls">
					<input class="form-control" name="data[company_pde]" type="text" id="inputCompanyPde" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputName">Product Name</label>
				<div class="controls">
					<input class="form-control" name="data[name]" type="text" id="inputName" placeholder="Product name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPrice">Base Price</label>
				<div class="controls">
					<input class="form-control" name="data[price]" type="text" id="inputPrice" placeholder="14.32">
				</div>
			</div>
		</div>
		<div class="col-lg-5 col-lg-offset-1 col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<div id="photo" class="">
					<label for="">Photo</label>
		        	<input type="hidden" name="data[photo]" value="">
		            <a class="thumbnail" href="#"><img class="img-rounded" src="/images/upload-photo.png"/></a>
	        	</div>
			</div>
		</div>
		<div class="col-lg-12">
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Add Product</button>
		</div>
	</form>
</div>
<br/>