<div class="col-lg-12">
<h1>Create new product category</h1>
<form class="form-horizontal" action="" method="POST" role="form">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="inputName">Category Name</label>
				<div class="controls">
					<input class="form-control" name="data[name]" type="text" id="inputName" placeholder="Category name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="inputCompany">Company</label>
				<div class="controls">
					<select class="form-control" name="data[company_id]" id="inputCompany">
						<?php foreach($companies as $company){?>
							<option value="<?php echo $company->id;?>"><?php echo $company->title;?></option>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Add Category</button>
		</div>
	</div>
</form>
<hr/>
</div>