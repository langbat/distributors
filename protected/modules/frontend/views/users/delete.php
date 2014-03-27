<h1>Delete Representative</h1>
<?php if (!isset($success)){?>
<form class="form-horizontal" action="" method="POST">
<h2>Are you sure, that you want to delete <?php echo $user->username; ?>?</h2>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-danger">Delete User</button>
			<button type="cancel" class="btn">Cancel</button>
		</div>
	</div>
</form>
<?php }else{ ?>
	User was successfully delete!
	<a href="/users/list">Back to users list</a> or <a href="/users/add">Create new user</a>
<?php }?>