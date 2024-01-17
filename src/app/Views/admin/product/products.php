<div class="container col-md-12">
	<div><a class="btn btn-primary m-4" href="/admin/product/create">Add a new product</a></div>

	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product): ?>
				<tr>
					<th scope="row">
						<?= $product->getId() ?>
					</th>
					<td>
						<?= $product->getName() ?>
					</td>
					<td>
						<?= $product->getDescription() ?>
					</td>
					<td>
						<form action="/admin/product/<?= $product->getId() ?>" method="POST">
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
						</form>

					</td>
					<td>
						<a class="btn btn-secondary" href="/admin/product/edit/<?= $product->getId() ?>">Edit</a>
					</td>
					<td>
						<a class="btn btn-primary" href="/admin/product/<?= $product->getId() ?>">
							Show
						</a>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
</div>