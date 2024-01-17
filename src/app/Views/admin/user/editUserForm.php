<?php use App\Utils\SessionManager ?>
<?php echo SessionManager::getFlashMessage('success') ?>
<div class="container col-md-6">
	<h1>Edit User</h1>
	<form action="/admin/user/update" method="POST">
		<input type="hidden" name="id" value="<?= $user->getId() ?>">
		<div class="form-group m-2">
			<label>
				<input name="username" type="text" class="form-control" placeholder="Enter username"
					value="<?= $user->getUsername() ?>">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="email" type="email" class="form-control" placeholder="Enter email"
					value="<?= $user->getEmail() ?>">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="password" type="password" class="form-control" placeholder="Enter password"
					value="">
			</label>
		</div>

		<button type="submit" class="btn btn-primary m-2">Update</button>
	</form>
</div>