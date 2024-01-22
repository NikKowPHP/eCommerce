<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;
use App\Models\Model;


class Product extends Model
{
	private int $id;
	private string $name;
	private string $description;
	private float $price;
	private ?string $thumbnail;
	private array $images;
	private string $tableName;

	public function __construct(
		Database $database,
		string $name = '',
		string $description = '',
		float $price = 0.0,
	) {
		$this->name = $name;
		$this->description = $description;
		$this->price = $price;
		$this->tableName = 'products';
		parent::__construct($database);
	}
	public function setId(int|string $id): void
	{
		$id = (int) $id;
		$this->id = $id;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}
	public function setPrice(float $price): void
	{
		$this->price = $price;
	}
	public function setImages(array $images): void
	{
		$this->images = $images;
	}
	public function getImages(): array
	{
		return $this->images;
	}
	public function getName(): string
	{
		return $this->name;
	}
	public function getDescription(): string
	{
		return $this->description;
	}
	public function getPrice(): float
	{
		return $this->price;
	}
	public function getId(): int
	{
		return $this->id;
	}

	public function write(): ?int
	{
		$this->setHiddenProps('images');
		return $this->save();
	}


	public function create(array $data): void
	{

	}
	public function remove(): ?bool
	{
		return $this->destroy();
	}
	protected function getTableName(): string
	{
		return $this->tableName;
	}
	public function getThumbnail():string
	{
		$thumbnail = $this->thumbnail;
		$pathToPublicImages = '/images/';
		if($thumbnail) {
			return $pathToPublicImages. $thumbnail;
		}
		return 'https://placehold.co/600x400?text=No+Image';
	}
	public function setThumbnail(?string $thumbnail):void
	{
		$this->thumbnail = $thumbnail;
	}

}