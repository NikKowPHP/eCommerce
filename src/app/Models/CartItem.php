<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;
use App\Models\Product;
use App\Utils\Auth;


class CartItem extends Model
{
	private int $id;
	private int $cartId;
	private int $productId;
	private int $quantity;
	private Product $product;

	public function __construct(int $cartId = 0, int $productId = 0, int $quantity = 1)
	{
		$this->cartId = $cartId;
		$this->productId = $productId;
		$this->quantity = $quantity;
	}
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
	public function findProduct(int $productId): self
	{
		$product = (new Product())->read($productId);
		$this->product = $product;
		return $this;
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
	public function storeItem(): ?int
	{
		$this->setHiddenProps('database', 'product');
		return $this->save();
	}
	public function updateQuantity(): void
	{
		$quantity = $this->count();
		$this->setQuantity($quantity);
	}
	private function count(): ?int
	{
		return $this->getCount('quantity', 'productId', $this->productId);
	}
	public function delete(): ?int
	{
		$this->setHiddenProps('database','product');

		return $this->destroy();
	}

}