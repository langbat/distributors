<div class="col-lg-12">
	<h1>Edit group</h1>
	<form class="form-horizontal" action="" method="POST" role="form">
		<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="inputName">Group Name</label>
				<div class="controls">
					<input value="<?php echo $group->title;?>" class="form-control" name="data[title]" type="text" id="inputName" placeholder="Group name">
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Edit Group</button>
		</div>
	</form>
	<hr/>
</div>