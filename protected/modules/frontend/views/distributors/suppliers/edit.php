<div class="col-lg-12">
	<h1>Edit supplier</h1>
	<form class="form-horizontal" action="" method="POST" role="form">
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="inputName">Supplier Name</label>
				<div class="controls">
					<input value="<?php echo $supplier->title;?>" class="form-control" name="data[title]" type="text" id="inputName" placeholder="Supplier name">
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Edit Supplier</button>
		</div>
	</form>
	<hr/>
</div>