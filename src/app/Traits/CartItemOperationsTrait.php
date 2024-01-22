<?php
declare(strict_types=1);
namespace App\Traits;

use App\Models\CartItem;
use App\Models\Cart;

trait CartItemOperationsTrait
{
	private function getUserItem(int $productId, ?array $userCartItems): ?CartItem
	{
		if ($userCartItems !== null) {
			foreach ($userCartItems as $userItem) {
				if ($userItem->getProductId() === $productId) {
					$userItem->updateQuantity();
					return $userItem;
				}
			}
		}
		return null;
	}
	private function getUserCartItems(Cart $userCart): ?array
	{
		return (new CartItem($this->database))->findAllBy('cartId', $userCart->getId()) ?? null;
	}

}