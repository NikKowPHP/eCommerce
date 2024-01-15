<?php
declare(strict_types=1);
namespace App\Services;

require_once(__DIR__ . '/../../../config/constants.php');
use App\Models\Image;
use App\Models\File;
use App\Models\Product;

class ProductService
{
	public function createProduct(string $name, string $description, float $price): ?int
	{
		try {
			$pdo = (new Product())->getDatabase()->getConnection();
			$pdo->beginTransaction();

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$name = $_POST['name'];
				$description = $_POST['description'];
				$price = (float) $_POST['price'];
				$product = new Product();
				if ($product->read($name, 'name')) {
					$pdo->rollBack();
					return null;
				}

				$product = new Product($name, $description, $price);

				// Write the product to the database
				if ($productId = $product->write()) {
					$product->setId($productId);
					// handle file upload
					$uploadedFileName = File::upload('file', IMAGE_UPLOAD_PATH);
					if ($uploadedFileName !== null) {
						$image = new Image($productId, $uploadedFileName);
						$image->write();
					} else {
						$pdo->rollBack();
						return null;
					}
				}
				$pdo->commit();
				return $productId;
			}

		} catch (\PDOException $e) {
			$pdo->rollBack();
			echo 'Transaction failed: ' . $e->getMessage();
			return null;
		}
	}
}