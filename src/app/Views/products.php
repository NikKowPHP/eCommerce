<div class="container">

	<?php foreach ($products as $product): ?>

		<div class="col-md-6">
			<h3>
				<?= $product->getName() ?>
			</h3>
			<p>
				<?= $product->getDescription() ?>

			</p>
			<?php if ($product->getThumbnail()): ?>
				<img src="/images/<?= $product->getThumbnail() ?>" alt="">
			<?php endif; ?>

			<form action="/products" method="POST">
				<input type="hidden" name="productId" value=<?= $product->getId() ?>>
				<button type="submit">Add to cart</button>
			</form>

			
			<form action="/products/remove" method="GET">
				<input type="hidden" name="productId" value=<?= $product->getId() ?>>
				<input type="hidden" name="_method" value="POST" >
				<button type="submit">Remove from cart</button>
			</form>
		</div>

	<?php endforeach; ?>
</div>