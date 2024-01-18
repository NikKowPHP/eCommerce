<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

use App\Controllers\Admin\AbstractAdminController;
use App\Models\Image;
use App\Models\Product;
use App\Services\ProductService;
use App\Utils\Location;
use App\Utils\SessionManager;

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
		$viewPath = __DIR__ . '/../../Views/admin/product/products.php';
		$this->includeView($viewPath, ['products' => $products]);
	}
	public function show(int $id): void
	{
		$product = new Product();
		$product->read($id);
		$image = new Image();
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$viewPath = __DIR__ . '/../../Views/admin/product/product.php';
		$this->includeView($viewPath, ['product' => $product]);
	}
	public function create(): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/product/newProductForm.php';
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
	// Renders edit view
	public function edit($id): void
	{
		$viewPath = __DIR__ . '/../../Views/admin/product/editProductView.php';
		$product = new Product();
		$product->read($id);
		$image = new Image();
		$images = $image->findAllBy('productId', $id);
		$product->setImages($images);
		$this->includeView($viewPath, ['product' => $product]);
	}
	// Updates the product
	public function update(): bool
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$productId = (int) $_POST['id'];

			if (!(new Product())->read($productId)) {
				return false;
			}
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = (float) $_POST['price'];
			$product = new Product($name, $description, $price);
			$product->setId($productId);
			$product->setHiddenProps('images');

			if ($this->productService->updateProduct($product)) {
				SessionManager::setFlashMessage('success', "Product {$product->getName()} has been updated");
				Location::redirect('/admin/product/edit/' . $product->getId());
				return true;
			}
			SessionManager::setFlashMessage('failure', "Product {$product->getName()} has not been updated, try again");
			Location::redirect('/admin/product/edit/' . $product->getId());
			return false;
		}
		Location::redirect('/');
		return false;
	}
	public function destroy(int $id): ?bool
	{
		// Checks whether hidden input with value _method exists
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
			$product = (new Product())->read($id);
			if ($product->getId()) {
				
				if ($product->remove()) {
					SessionManager::setFlashMessage('success', "Product {$product->getName()} has been deleted");
					Location::redirect('/admin/products');
					return true;
				}
				SessionManager::setFlashMessage('failure', "Product not found or could not be deleted");
				Location::redirect('/admin/products');
				return false;
			}
		}
		Location::redirect('/');
		return null;
	}
}