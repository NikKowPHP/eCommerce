<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\CartItem;
use App\Models\Image;
use App\Models\Product;
use App\Models\Cart;
use App\Utils\Auth;

class ProductController extends AbstractController
{
	public function index(): void
	{
		$product = new Product();
		$products = $product->findAll();
		$userCart = (new Cart())->read(Auth::getUserId(), 'userId');
		$userCartItems = $this->getUserCartItems($userCart);
		$this->updateUserCartItemsQuantity($userCartItems);

		$viewPath = __DIR__ . '/../Views/products.php';
		$this->includeView($viewPath, ['products' => $products, 'userItems' => $userCartItems]);
	}

	private function getUserCartItems(Cart $userCart): ?array
	{
		return (new CartItem)->findAllBy('cartId', $userCart->getId()) ?? null;
	}
	private function updateUserCartItemsQuantity(?array $userCartItems): void
	{
		if ($userCartItems !== null) {
			foreach ($userCartItems as $cartItem) {
				$cartItem->updateQuantity();
			}
		}
	}
	public function show(int $id): void
	{
		$product = new Product();
		$product->read($id);
		$image = new Image();
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$viewPath = __DIR__ . '/../Views/product.php';
		$this->includeView($viewPath, ['product' => $product]);
	}
}