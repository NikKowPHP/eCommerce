<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Utils\Auth;
use App\Models\Image;
use App\Models\Product;
use App\Models\Cart;
use App\Utils\SessionManager;
use App\Utils\Location;

class CartController extends AbstractController
{
	public function index(): void
	{
		$cart = new Cart();
		$cart->read(Auth::getUserId(), 'userId');
		$cart->findItems();

		$viewPath = __DIR__ . '/../Views/cart.php';
		$this->includeView($viewPath, ['cart' => $cart]);
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
	public function addProduct(): ?int
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$productId = $_POST['productId'];

			if ($productId) {
				$product = (new Product())->read($productId);
				$cart = (new Cart())->find();
				if ($cart) {
					$cartItemId = $cart->addItem($product);
				} else {
					$cart = new Cart(Auth::getUserId());
					$cart->store();
				}
					$cartItemId = $cart->addItem($product);

				if ($cartItemId) {
					SessionManager::setFlashMessage('success', "{$product->getName()} has been stored");
					Location::redirect('/products');
					return $cartItemId;
				}
				SessionManager::setFlashMessage('failure', "{$product->getName()} has not been added, try again");
				return null;
			}
		}
	}
}