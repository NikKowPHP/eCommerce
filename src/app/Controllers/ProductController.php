<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Image;
use App\Models\Product;

class ProductController extends AbstractController
{
	public function index(): void
	{
		$product = new Product();
		$products = $product->findAll();

		$viewPath = __DIR__ . '/../Views/products.php';
		$this->includeView($viewPath, ['products'=> $products]);
	}
	public function show(int $id): void
	{
		$product = new Product();
		$product->read($id);
		$image = new Image();
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$viewPath = __DIR__ . '/../Views/product.php';
		$this->includeView($viewPath, ['product' => $product]);
	}
}