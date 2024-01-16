<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

use App\Controllers\Admin\AbstractAdminController;
use App\Models\Image;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends AbstractAdminController
{
	private ProductService $productService;

	public function __construct()
	{
		$this->productService = new ProductService();
	}

	public function index(): void
	{
		$product = new Product();
		$products = $product->findAll();
		$viewPath = __DIR__ . '/../../Views/admin/products.php';
		$this->includeView($viewPath, ['products' => $products]);
	}
	public function show(int $id): void
	{
		$product = new Product();
		$product->read($id);
		$image = new Image();
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$viewPath = __DIR__ . '/../../Views/product.php';
		$this->includeView($viewPath, ['product' => $product]);
	}
	public function create(): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/newProductForm.php';
		$this->includeView($viewPath);

	}
	public function store(): ?int
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = (float) $_POST['price'];

			return $this->productService->createProduct($name, $description, $price);
		}

	}
	public function edit(): void
	{

	}
	public function update(): void
	{

	}
	public function destroy(): void
	{

	}
}