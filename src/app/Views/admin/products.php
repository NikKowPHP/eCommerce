<div class="container col-md-6">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">First</th>
				<th scope="col">Last</th>
				<th scope="col">Handle</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product): ?>
				<tr>
					<th scope="row"><?= $product->getId() ?></th>
					<td><?= $product->getName() ?></td>
					<td><?= $product->getDescription() ?></td>
					<td>
						<a href="/admin/products/remove/<?= $product_id ?>">Remove</a>
					</td>
					<td>
						<a href="/admin/products/edit?id=<?= $product_id ?>">Edit</a>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
</div>