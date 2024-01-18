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
		</div>

	<?php endforeach; ?>
</div>