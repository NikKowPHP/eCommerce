<?php
namespace App\Models;
declare(strict_types=1);
use App\Database;

abstract class Model
{
	protected Database $database;

	public function __construct()
	{
		$this->initDatabase();
	}
	protected function initDatabase():void
	{
		$this->database = new Database();
	}
	public function read(int $id): ?self 
	{
		try {
			$pdo = $this->database->getConnection();

			$query = "SELECT * FROM " . $this->getTableName(). " WHERE id = :id";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC) ?:null;
		} catch(\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			return null;
		}
	}
	abstract protected function getTableName():string;
}