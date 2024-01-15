<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;
use App\Models\CartItem;


class Cart extends Model
{
	private int $id;
	private int $userId;
	private string $createdAt;
	private array $items;
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
		$this->userId= $userId;
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