<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Database\Database;
use App\Models\CartItem;
use App\Models\Image;
use App\Models\Product;
use App\Models\Cart;
use App\Traits\CartItemOperationsTrait;
use App\Utils\Auth;

class ProductController extends AbstractController
{
	use CartItemOperationsTrait;
	private Database $database;
	public function __construct(Database $database)
	{
		$this->database = $database;
	}
	public function index(): void
	{

		$viewPath = __DIR__ . '/../Views/products.php';
		$product = new Product($this->database);
		$products = $product->findAll();
		$userId = Auth::getUserId();

		$isProductInUserCart = null;
		$getUserItem = null;
		$userCartItems = [];

		if ($userId) {
			$userCart = (new Cart($this->database))->read(Auth::getUserId(), 'userId');
			$userCartItems = $this->getUserCartItems($userCart);
			if (!empty($userCartItems)) {
				$this->updateUserCartItemsQuantity($userCartItems);

				$isProductInUserCart = function (int $productId) use ($userCartItems): bool {
					return $this->isProductInCart($productId, $userCartItems);
				};

				$getUserItem = function (int $productId) use ($userCartItems): ?CartItem {
					return $this->getUserItem($productId, $userCartItems);
				};
			}
		}
		$this->includeView($viewPath, ['products' => $products, 'userItems' => $userCartItems, 'isProductInUserCart' => $isProductInUserCart, 'getUserItem' => $getUserItem]);

	}

	private function isProductInCart(int $productId, ?array $userCartItems): bool
	{
		if ($userCartItems !== null) {
			foreach ($userCartItems as $userItem) {
				if ($userItem->getProductId() === $productId) {
					return true;
				}
			}
		}
		return false;
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
		$product = new Product($this->database);
		$product->read($id);
		$image = new Image($this->database);
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$cart = (new Cart($this->database))->read(Auth::getUserId(), 'userId');
		$cartItem = $cart->findItem($product);
		$viewPath = __DIR__ . '/../Views/public/product.php';
		$this->includeView($viewPath, ['cartItem' => $cartItem, 'product' => $product]);
	}
}