<div class="container">
	<div class="flex justify-around ">

		<?php foreach ($products as $product): ?>
			<?php
			$isProductInCart = $isProductInUserCart($product->getId());

			$userCartItemQuantity = null;

			if ($isProductInCart) {
				$userItem = $getUserItem($product->getId());
				$userCartItemQuantity = $userItem->getQuantity();
			}
			?>

			<div class=" w-full relative border rounded-md mb-3 mx-4 hover:shadow-sm">
				<a href="/product/<?= $product->getId() ?>">
					<img class="w-full mb-3" src="<?= $product->getThumbnail() ?>" alt="product image">
				</a>
				<div class="card-body  pb-14 px-4 ">
					<h5 class="card-title">
						<?= $product->getName() ?>
					</h5>
					<p class="card-text">
						<?= $product->getDescription() ?>
					</p>
					<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
				</div>
				<div class="card-footer absolute bottom-0 lelf-0 pb-4">
					<?php if ($isProductInCart): ?>
						<form action="/products/remove" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>

							<div class="form__footer-control d-flex justify-content-center">
								<input class="w-[30px] m-2 border rounded-md" type="number" name="quantity"
									value="<?= $userCartItemQuantity ?>">
								<button class="p-2 bg-red-500 text-white" type="submit">Remove from cart</button>
							</div>
						</form>

					<?php else: ?>
						<form action="/products" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>

							<div class="form__footer-control d-flex justify-content-center">
								<input class="border rounded-md w-[40px] m-2" type="number" name="quantity"
									value="<?= $userCartItemQuantity ?? 1 ?>">
								<button class="p-2 bg-blue-500 text-white" type="submit">Add to cart</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>