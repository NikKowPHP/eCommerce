<?php
$product;
if ($cartItem)
	$product = $cartItem->getProduct();
?>
<div class="container">
	<div class="product mx-auto">
		<h1 class="text-xl font-bold text-center mb-6">
			<?= $product->getName() ?>
		</h1>
		<img class="w-full mb-3" src="<?= $product->getThumbnail() ?>" alt="product image">
		<p class="product__description ">
			<?= $product->getDescription() ?>
		</p>

		<div class="product__control flex justify-around">
					<?php if ($cartItem): ?>
						<form action="/products/remove" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>

							<div class="form__footer-control d-flex justify-content-center">
								<input class="w-[30px] m-2 border rounded-md" type="number" name="quantity"
									value="<?= $cartItem->getQuantity() ?>">
								<button class="p-2 bg-red-500 text-white" type="submit">Remove from cart</button>
							</div>
						</form>

					<?php else: ?>
						<form action="/products" method="POST">
							<input type="hidden" name="productId" value=<?= $product->getId() ?>>

							<div class="form__footer-control d-flex justify-content-center">
								<input class="border rounded-md w-[40px] m-2" type="number" name="quantity"
									value="1">
								<button class="p-2 bg-blue-500 text-white" type="submit">Add to cart</button>
							</div>
						</form>
					<?php endif; ?>


		</div>
	</div>
</div>