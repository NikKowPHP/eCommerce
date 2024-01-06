<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Traits\ViewPathTrait;


class ProductController
{
	use ViewPathTrait;
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/products.php';
		$this->includeView($viewPath);
	}
}