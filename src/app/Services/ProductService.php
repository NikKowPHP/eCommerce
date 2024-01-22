<?php
declare(strict_types=1);
namespace App\Services;

use App\Database\Database;

require_once(__DIR__ . '/../../config/constants.php');
use App\Models\Image;
use App\Models\File;
use App\Models\Product;

class ProductService
{
	private Database $database;
	public function __construct(Database $database)
	{
		$this->database = $database;
	}
	public function createProduct(string $name, string $description, float $price): ?int
	{
		try {
			$pdo = (new Product($this->database))->getDatabase()->getConnection();
			$pdo->beginTransaction();

			$product = new Product($this->database);
			if ($product->read($name, 'name')) {
				$pdo->rollBack();
				return null;
			}

			$product = new Product($this->database, $name, $description, $price);

			// Write the product to the database
			if ($productId = $product->write()) {
				$product->setId($productId);
				// handle file upload
				$uploadedFileName = File::upload('file', IMAGE_UPLOAD_PATH);
				if ($uploadedFileName !== null) {
					$image = new Image($this->database, $productId, $uploadedFileName);
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
					$image = new Image($this->database, $product->getId(), $uploadedFileName);
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