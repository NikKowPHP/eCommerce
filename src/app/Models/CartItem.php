<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;
use App\Models\Product;


class CartItem extends Model
{
	private int $id;
	private int $cartId;
	private int $productId;
	private int $quantity;
	private Product $product;

	public function getTableName(): string
	{
		return 'cart_items';
	}
	 public function getId(): int
	 {
			 return $this->id;
	 }

	 public function getCartId(): int
	 {
			 return $this->cartId;
	 }

	 public function getProductId(): int
	 {
			 return $this->productId;
	 }

	 public function getQuantity(): int
	 {
			 return $this->quantity;
	 }
	public function getProduct(): Product
	{
		return $this->product;
	}
	public function findProduct(): void
	{
		$product = new Product();
		$product->read($this->productId);
		$this->product = $product;
	}

	 // Setters
	 public function setId(int $id): void
	 {
			 $this->id = $id;
	 }

	 public function setCartId(int $cartId): void
	 {
			 $this->cartId = $cartId;
	 }

	 public function setProductId(int $productId): void
	 {
			 $this->productId = $productId;
	 }

	 public function setQuantity(int $quantity): void
	 {
			 $this->quantity = $quantity;
	 }
}