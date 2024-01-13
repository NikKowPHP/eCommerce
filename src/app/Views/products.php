<?php foreach($products as $product): ?>

	<div class="col-md-6">
		<h3><?= $product->getName() ?></h3>
		<p><?= $product->getDescription() ?></p>
	</div>

	<?php endforeach;  ?>
