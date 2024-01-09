<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;


class Cart extends Model
{
	private int $id;
	private int $userId;
	private string $createdAt;
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
}