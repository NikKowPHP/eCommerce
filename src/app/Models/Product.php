<?php
namespace App\Models;

declare(strict_types=1);

class Product
{
	private int $id;
	private string $title;
	private string $description;
	private array $images;

	public function __construct(
		int $id = 0,
		string $title = '',
		string $description = '',
		array $images = []
	) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->images = $images;
	}

}