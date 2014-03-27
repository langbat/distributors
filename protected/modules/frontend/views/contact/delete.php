<h1>Delete Contact Log</h1>
<?php if (!isset($success)){?>
<form class="form-horizontal" action="" method="POST">
<h2>Are you sure, that you want to delete this contact log?</h2>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-danger">Delete Log</button>
			<button type="cancel" class="btn">Cancel</button>
		</div>
	</div>
</form>
<?php }else{ ?>
	Contact log was successfully delete!
	<a href="/contact/list">Back to contact log list</a>
<?php }?>