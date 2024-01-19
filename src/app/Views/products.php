<div class="container">

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
		<div class="col-md-6">
			<h3>
				<?= $product->getName() ?>
			</h3>
			<p>
				<?= $product->getDescription() ?>
			</p>
			<?php if ($product->getThumbnail()): ?>
				<img width="100%" src="/images/<?= $product->getThumbnail() ?>" alt="">
			<?php endif; ?>

			<?php if ($isProductInCart): ?>
				<form action="/products/remove" method="GET">
					<input type="hidden" name="productId" value=<?= $product->getId() ?>>
					<input type="hidden" name="_method" value="POST">
					<button type="submit">Remove from cart</button>
				</form>


			<?php else: ?>
				<form action="/products" method="POST">
					<input type="hidden" name="productId" value=<?= $product->getId() ?>>
					<button type="submit">Add to cart</button>
				</form>
			<?php endif; ?>
		</div>

	<?php endforeach; ?>
</div>