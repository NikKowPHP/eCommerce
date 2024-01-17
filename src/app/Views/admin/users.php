<div class="container col-md-12">
	<div><a class="btn btn-primary m-4" href="/admin/user/create">Add a new user</a></div>

	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Email</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
				<tr>
					<th scope="row">
						<?= $user->getId() ?>
					</th>
					<td>
						<?= $user->getUsername() ?>
					</td>
					<td>
						<?= $user->getEmail() ?>
					</td>
					<td>
						<form action="/admin/user/<?= $user->getId() ?>" method="POST">
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
						</form>

					</td>
					<td>
						<a class="btn btn-secondary" href="/admin/user/edit/<?= $user->getId() ?>">Edit</a>
					</td>
					<td>
						<a class="btn btn-primary" href="/admin/user/<?= $user->getId() ?>">
							Show
						</a>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
</div>