<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;


class Product extends Model
{
	private int $id;
	private string $name;
	private string $description;
	private float $price;
	private array $images;
	private string $tableName;

	public function __construct(
		int $id = 0,
		string $name = '',
		string $description = '',
		float $price = 0.0,
		array $images = []
	) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->images = $images;
		$this->tableName = 'products';
		parent::__construct();
	}
	public function setId(int|string $id):void
	{
		$id = (int) $id;
		$this->id = $id;
	}
	public function setName(string $name):void
	{
		$this->name = $name;
	}
	public function setDescription(string $description):void
	{
		$this->description = $description;
	}
	public function setPrice(float $price):void
	{
		$this->price = $price;
	}
	public function setImages(array $images):void
	{
		$this->images = $images;
	}
	public function getImages():array
	{
		return $this->images;
	}
	public function getName():string
	{
		return $this->name;
	}
	public function getDescription():string
	{
		return $this->description;
	}
	public function getPrice():float
	{
		return $this->price;
	}
	
	
	public function create(array $data): void
	{

	}
	protected function getTableName(): string
	{
		return $this->tableName;
	}

}