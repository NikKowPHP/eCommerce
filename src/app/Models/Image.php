<?php
declare(strict_types=1);
namespace App\Models;

use App\Models\Model;


class Image extends Model
{
	private int $id;
	private int $product_id;
	private string $image_url;
	public function getTableName():string
	{
		return 'images';
	}
	public function setId(int $id):void
	{
		$this->id = $id;
	}
	public function setProductId(int $product_id):void
	{
		$this->product_id = $product_id;
	}
	public function setImageUrl(string $image_url):void
	{
		$this->image_url= $image_url;
	}
}