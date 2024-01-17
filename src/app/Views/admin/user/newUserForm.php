<div class="container col-md-6">
	<form action="/admin/user/store" method="POST" >
		<div class="form-group m-2">
			<label>
				<input name="username" type="text" class="form-control" placeholder="Enter user name">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="email" type="email" class="form-control" placeholder="Enter email">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="password" type="password" class="form-control" placeholder="Enter password">
			</label>
		</div>
		<button type="submit" class="btn btn-primary m-2">Create</button>
	</form>
</div>