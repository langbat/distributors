<div class="col-lg-12">
	<h1>Delete group</h1>
	<form class="form-horizontal" action="" method="POST" role="form">
		<p>Are you sure, that you want to delete <?php echo $group->title;?> group?</p>
		<div class="col-lg-12">
			<a class="btn btn-default" href="/distributors/groups/list">No</a>
			<button type="submit" name="data[action]" value="save" class="btn btn-primary">Yes</button>
		</div>
	</form>
	<hr/>
</div>