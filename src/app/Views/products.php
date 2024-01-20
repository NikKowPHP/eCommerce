<div class="container">
	<div class="d-flex justify-content-around ">

		<?php foreach ($products as $product): ?>
			<?php
			$isProductInCart = $isProductInUserCart($product->getId());

			$userCartItemQuantity = null;

			if ($isProductInCart) {
				$userItem = $getUserItem($product->getId());
				$userCartItemQuantity = $userItem->getQuantity();
			}

			?>

			<div class="card col-md-6 mb-3 mx-4">
					<img class="card-img-top" src="<?= $product->getThumbnail() ?>" alt="product image">
				<div class="card-body pb-4 px-4 ">
					<h5 class="card-title">
						<?= $product->getName() ?>
					</h5>
					<p class="card-text">
						<?= $product->getDescription() ?>
					</p>
					<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
				</div>
				<div class="card-footer pb-4">
					<?php if ($isProductInCart): ?>
						<form action="/products/remove" method="GET">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>
							<input type="hidden" name="_method" value="POST">

							<div class="form__footer-control d-flex justify-content-center">
								<input class="w-25 form-control m-2" type="number" name="quantity" value="<?= $userCartItemQuantity ?>">
								<button class="btn btn-danger" type="submit">Remove from cart</button>
							</div>
						</form>

					<?php else: ?>
						<form action="/products" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>
							<button class="btn btn-primary" type="submit">Add to cart</button>
							<label>
								<input class="w-50%  form-control" type="number" name="quantity" value="<?= $userCartItemQuantity ?>">
							</label>
						</form>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>