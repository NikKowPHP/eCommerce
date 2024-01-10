<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Cart;

class CartController extends AbstractController
{
	public function index(): void
	{
		$cart = new Cart();
		//TODO: User id implementation
		$cart->read(1, 'userId');
		$cart->findItems();
		
		$viewPath = __DIR__ . '/../Views/cart.php';
		$this->includeView($viewPath, ['cart'=> $cart]);
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