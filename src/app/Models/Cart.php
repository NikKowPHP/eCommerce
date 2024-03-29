<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;
use App\Models\Model;
use App\Models\CartItem;
use App\Utils\Auth;


class Cart extends Model
{
	private int $id;
	private int $userId;
	private string $createdAt;
	private array $items;


	public function __construct(Database $database, int $userId = 0, array $items = [])
	{
		$this->userId = $userId;
		$this->items = $items;

		parent::__construct($database);
	}
	public function getTableName(): string
	{
		return 'carts';
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}
	public function setCreatedAt(string $createdAt): void
	{
		$this->createdAt = $createdAt;
	}
	public function findItem(Product $product): ?CartItem
	{

		$conditions = [
			['where' => 'cartId', 'value' => $this->id],
			['where' => 'productId', 'value' => $product->getId()]
		];
		$foundItem = (new CartItem($this->database))->findWithConditions($conditions);
		if ($foundItem)
			$foundItem->setProduct($product);
		return $foundItem;

	}
	public function findItems(): array
	{
		$cartItem = new CartItem($this->database);
		$cartItems = $cartItem->findAllBy('cartId', $this->id);

		// Instantiate product inside cartItem
		$cartItems = array_map(function ($cartItem) {
			$cartItem->findProduct($cartItem->getProductId());
			return $cartItem;
		}, $cartItems);

		$this->setItems($cartItems);
		return $cartItems;
	}
	public function addItem(Product $product, int $quantity = 1): ?int
	{
		$conditions = [
			['where' => 'cartId', 'value' => $this->id],
			['where' => 'productId', 'value' => $product->getId()]
		];
		$foundItem = (new CartItem($this->database))->findWithConditions($conditions);
		if ($foundItem) {
			$foundItem->setHiddenProps('product');
			$foundItem->setQuantity($quantity);
			return $foundItem->update();
		}
		$cartItem = new CartItem($this->database, $this->id, $product->getId(), $quantity);
		return $cartItem->storeItem();
	}
	public function store(): ?int
	{

		$this->setHiddenProps('createdAt', 'items');
		return $this->save();
	}
	public function find(): ?self
	{
		$userId = Auth::getUserId();
		$this->setHiddenProps('id');
		return $this->read($userId, 'userId');

	}
	public function setItems(array $items): void
	{
		$this->items = $items;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function getUserId(): int
	{
		return $this->userId;
	}
	public function getItems(): array
	{
		return $this->items;
	}
	public function getCheckoutPrice(): ?float
	{
		return $this->calculateCart();

	}
	private function calculateCart(): ?float
	{
		$cartItems = $this->getItems();
		$price = 0;
		foreach ($cartItems as $cartItem) {
			$itemPrice = $cartItem->getProduct()->getPrice();
			$price += $itemPrice;
		}
		return $price;
	}
}