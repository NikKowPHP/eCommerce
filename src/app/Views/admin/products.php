<div class="container col-md-12">
	<div><a class="btn btn-primary m-4" href="/admin/products/create">Add a new product</a></div>

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
					<th scope="row"><?= $product->getId() ?></th>
					<td><?= $product->getName() ?></td>
					<td><?= $product->getDescription() ?></td>
					<td>
						<a class="btn btn-danger w-75 m-0" href="/admin/products/remove/<?= $product_id ?>">Remove</a>
					</td>
					<td>
						<a class="btn btn-secondary" href="/admin/products/edit?id=<?= $product_id ?>">Edit</a>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
</div>