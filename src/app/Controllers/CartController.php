<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Traits\CartItemOperationsTrait;
use App\Utils\Auth;
use App\Models\Image;
use App\Models\Product;
use App\Models\Cart;
use App\Utils\SessionManager;
use App\Utils\Location;
use App\Models\CartItem;

class CartController extends AbstractController
{
	use CartItemOperationsTrait;
	public function index(): void
	{
		$cart = (new Cart())->read(Auth::getUserId(), 'userId');
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
	public function removeItemFromCart(): ?int
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['productId'])) {
				$productId = (int) $_POST['productId'];
				$quantityToRemove = (int) $_POST['quantity'];
				$userCart = (new Cart())->read(Auth::getUserId(), 'userId');
				$userCartItems = $this->getUserCartItems($userCart);

				$userItem = $this->getUserItem($productId, $userCartItems);
				$userItem->setHiddenProps('product');
				if ($userItem !== null && $userItem->getQuantity() >= $quantityToRemove) {
					if ($userItem->getQuantity() === $quantityToRemove) {
						$affectedUserItem = $userItem->delete();
						$this->redirectWithMessage('success', "Product has been deleted from the cart", '/products');
						return $affectedUserItem;
					} else {
						$userItem->setQuantity($userItem->getQuantity() - $quantityToRemove);
						$deletedItemId = $userItem->update();
						$this->redirectWithMessage('failure', "Product has been deleted from the cart", '/products');
						return $deletedItemId;
					}
				}
			}
			$this->redirectWithMessage('failure', "Product has not been deleted, try again", '/products');
			return null;
		}
		$this->redirectWithMessage('failure', "Product has not been deleted, try again", '/products');
		return null;
	}

	private function redirectWithMessage(string $messageName, string $messageContent, string $redirectLink): void
	{
		SessionManager::setFlashMessage($messageName, $messageContent);
		Location::redirect($redirectLink);
	}

	private function findCartItem(int $cartId, int $productId): ?CartItem
	{
		$conditions = [
			['where' => 'cartId', 'value' => $cartId],
			['where' => 'productId', 'value' => $productId]
		];
		return (new CartItem())->findWithConditions($conditions) ?? null;
	}


}