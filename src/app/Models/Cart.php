<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;
use App\Models\CartItem;
use App\Utils\Auth;


class Cart extends Model
{
	private int $id;
	private int $userId;
	private string $createdAt;
	private array $items;


	public function __construct(int $userId = 0, array $items = [])
	{
		$this->userId = $userId;
		$this->items = $items;

		parent::__construct();
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
	public function findItems(): array
	{
		$cartItem = new CartItem();
		$cartItems = $cartItem->findAllBy('cartId', $this->id);

		// Instantiate product inside cartItem
		$cartItems = array_map(function ($cartItem) {
			$cartItem->findProduct();
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
		$foundItem = (new CartItem())->findWithConditions($conditions);
		if ($foundItem) {
			$foundItem->setHiddenProps('product');
			$foundItem->setQuantity($quantity);
			return $foundItem->update();
		}
		$cartItem = new CartItem($this->id, $product->getId(), $quantity);
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
}