<div class="container">
	<div class="d-flex justify-content-around ">

		<?php foreach ($products as $product): ?>
			<?php
			$isProductInCart = false;

			foreach ($userItems as $userItem) {
				if ($userItem->getProductId() === $product->getId()) {
					$isProductInCart = true;
					break;
				}
			}
			?>

			<div class="card col-md-6 mb-3 mx-4">
				<?php if ($product->getThumbnail()): ?>
					<img class="card-img-top" src="/images/<?= $product->getThumbnail() ?>" alt="Card image cap">
				<?php endif; ?>
				<div class="card-body pb-4 px-4 ">
					<h5 class="card-title">
						<?= $product->getName() ?>
					</h5>
					<p class="card-text">
						<?= $product->getDescription() ?>
					</p>
					<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
					<p class="card-text"><small class="text-muted">
							<?= $userItem->getQuantity() ?>
						</small></p>
				</div>
				<div class="card-footer pb-4">
					<?php if ($isProductInCart): ?>
						<form action="/products/remove" method="GET">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>
							<input type="hidden" name="_method" value="POST">
							<button class="btn btn-danger" type="submit">Remove from cart</button>
						</form>

					<?php else: ?>
						<form action="/products" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>
							<button class="btn btn-primary" type="submit">Add to cart</button>
						</form>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>