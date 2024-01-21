<div class="container mx-auto">
	<div class="flex items-center">
		<span class="text-lg font-bold m-2">Cart price</span>
		<span class="text-lg font-bold m-2">
			<?= $cart->getCheckoutPrice() ?>$
		</span>
		<form class="mt-4" action="/cart/checkout" method="post">
			<input class="p-2 bg-blue-500 text-white rounded-md " type="submit" value="Purchase">
		</form>
	</div>
	<div class="flex flex-wrap justify-around mt-8">

		<?php foreach ($cart->getItems() as $item): ?>
			<?php
			$product = $item->getProduct();
			$userCartItemQuantity = $item->getQuantity();

			?>

			<div class="w-full md:w-1/3  mb-8 mx-2 border ">
				<img class="card-img-top" src="<?= $product->getThumbnail() ?>" alt="product image">
				<div class="card-body m-4 ">
					<h5 class="card-title text-lg font-semibold">
						<?= $product->getName() ?>
					</h5>
					<p class="card-text">
						<?= $product->getDescription() ?>
					</p>
					<h5 class="card-text">
						<?= $product->getPrice() ?> $
					</h5>
				</div>
				<div class="card-footer pb-4">
					<form action="/products/remove" method="POST">
						<input type="hidden" name="productId" value=<?= $product->getId() ?>>

						<div class="form__footer-control flex justify-center items-center">
							<input class="w-1/3 md:w-1/6 m-2 border pl-4" type="number" name="quantity"
								value="<?= $userCartItemQuantity ?>">
							<button
								class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"
								type="submit">Remove from cart</button>
						</div>
					</form>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>