<?php
declare(strict_types=1);
namespace App\Utils;
use App\Database\Database;
use App\Models\Product;
use App\Services\ProductService;
use App\Controllers\ProductController;



class Container
{
	protected array $instances = [];

	public function getDatabase(): Database
	{
		if (!isset($this->instances['database'])) {
			$this->instances['database'] = new Database();
		}
		return $this->instances['database'];
	}

	public function getProductModel(): Product
	{
		if (!isset($this->instances['productModel'])) {
			$this->instances['productModel'] = new Product($this->getDatabase());
		}
		return $this->instances['productModel'];
	}
	public function getProductService(): ProductService
	{
		if (!isset($this->instances['productService'])) {
			$this->instances['productService'] = new ProductService($this->getDatabase());
		}

		return $this->instances['productService'];
	}

	public function getProductController(): ProductController
	{
		if (!isset($this->instances['productController'])) {
			$this->instances['productController'] = new ProductController(
				$this->getProductService(),
				$this->getProductModel(),
				$this->getImageModel()
			);
		}

		return $this->instances['productController'];
	}


}