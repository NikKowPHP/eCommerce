<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Exceptions\ViewNotFoundException;

class ProductController
{
	public function index(): void
	{
		try {
			$viewPath = __DIR__ . '/./Views/products.php';
			if (!file_exists($viewPath)) {
				throw new ViewNotFoundException("products.php", $viewPath);
			}
			include $viewPath;
		} catch (ViewNotFoundException $e) {
			echo $e->getMessage();

		}
	}
}