<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;
use App\Models\File;


class Image extends File
{
	private int $id;
	private int $productId;
	private string $imageUrl;
	public function __construct(int $productId = 0, string $imageUrl = '')
	{
		$this->productId = $productId;
		$this->imageUrl = $imageUrl;
	}
	public function getTableName(): string
	{
		return 'images';
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function setProductId(int $productId): void
	{
		$this->productId = $productId;
	}
	public function setImageUrl(string $imageUrl): void
	{
		$this->imageUrl = $imageUrl;
	}
	public function getImageUrl(): string
	{
		return $this->imageUrl;
	}
	public function write(): ?int
	{
		return $this->save();
	}
}