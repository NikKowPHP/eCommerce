<?php
declare(strict_types=1);
namespace App\Controllers;

class ProductController extends AbstractController
{
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/products.php';
		$this->includeView($viewPath);
	}
	public function show(int $id):void
	{
		$viewPath = __DIR__ . '/../Views/product.php';
		$this->includeView($viewPath);
	}
}