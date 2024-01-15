<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

require_once(__DIR__.'/../../../config/constants.php');
use App\Controllers\Admin\AbstractAdminController;
use App\Models\Image;
use App\Models\File;
use App\Models\Product;

class ProductController extends AbstractAdminController
{
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
		$viewPath = __DIR__ . '/../Views/product.php';
		$this->includeView($viewPath, ['product' => $product]);
	}
	public function create(): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/newProductForm.php';
		$this->includeView($viewPath);

	}
	public function store(): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = (float) $_POST['price'];
			$product = new Product($name, $description, $price);
			if ($productId = $product->write()) {
				$product->setId($productId);
				// handle file upload
				$uploadedFileName = File::upload('file', IMAGE_UPLOAD_PATH);
				if ($uploadedFileName !== null) {
					$image = new Image($productId, $uploadedFileName);
					$image->write();
				} else {
				}
			}
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