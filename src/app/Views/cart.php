<h1>This is a cart page</h1>
<pre>

</pre>

<h1>Cart owner<?= $cart->getUserId() ?></h1>
<h1>Cart number <?= $cart->getId() ?></h1>
<div>
	<?php foreach($cart->getItems() as $item): ?>

		<h1> product id <?= $item->getProductId() ?></h1>
		<h1> quantity <?= $item->getQuantity() ?></h1>

		<?php endforeach; ?>
</div>