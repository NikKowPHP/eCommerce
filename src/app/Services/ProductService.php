<?php
declare(strict_types=1);
namespace App\Services;

require_once(__DIR__ . '/../../config/constants.php');
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

		} catch (\PDOException $e) {
			$pdo->rollBack();
			echo 'Transaction failed: ' . $e->getMessage();
			return null;
		}
	}

	public function updateProduct(Product $product): bool
	{
		try {
			$pdo = $product->getDatabase()->getConnection();
			$pdo->beginTransaction();

			$result = $product->update();
			if ($result) {
				$uploadedFileName = File::upload('file', IMAGE_UPLOAD_PATH);

				if ($uploadedFileName !== null) {
					$image = new Image($product->getId(), $uploadedFileName);
					$image->write();
				} else {
					$pdo->rollBack();
					return false;
				}
			}
			$pdo->commit();
			return true;
		} catch (\PDOException $e) {
			$pdo->rollBack();
			echo 'Transaction failed: ' . $e->getMessage();
			return false;
		}
	}
}