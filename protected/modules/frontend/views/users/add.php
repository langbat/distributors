<h1>Add new Representative</h1>
<?php if (!isset($success)){?>
<form class="form-horizontal" action="" method="POST">
	<div class="control-group">
		<label class="control-label" for="inputRole">Role</label>
		<div class="controls">
			<select name="data[role]" id="inputRole">
				<option value="representative">Representative</option>
				<option value="admin">Administrator</option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputUsername">Login</label>
		<div class="controls">
			<input name="data[username]" type="text" id="inputUsername" placeholder="Username" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Password</label>
		<div class="controls">
			<input name="data[password]" type="text" id="inputPassword" placeholder="Password">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputFname">First Name</label>
		<div class="controls">
			<input name="data[fname]" type="text" id="inputFname" placeholder="First Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputLname">Last Name</label>
		<div class="controls">
			<input name="data[lname]" type="text" id="inputLname" placeholder="Last Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input name="data[email]" type="text" id="inputEmail" placeholder="example@example.com" required>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Add User</button>
		</div>
	</div>
</form>
<?php }else{ ?>
New user was successfully created!
	<a href="/users/list">Back to users list</a> or <a href="/users/add">Create new user</a>
<?php }?>