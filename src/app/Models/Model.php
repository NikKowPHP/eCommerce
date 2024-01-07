<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;

abstract class Model
{
	protected Database $database;

	public function __construct()
	{
		$this->initDatabase();
	}
	protected function initDatabase(): void
	{
		$this->database = new Database();
	}
	public function read(int $id): ?static
	{
		try {
			$pdo = $this->database->getConnection();

			$query = "SELECT * FROM " . $this->getTableName() . " WHERE id = :id";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			$foundData = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
			if($foundData) {
				$foundData = $this->convertRow($foundData);
			}
			$this->instantiate($foundData);
			return $this;
		} catch (\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			return null;
		}
	}
	protected function instantiate(array $data): static
	{
		foreach ($data as $key => $value) {
			$setterMethod = 'set' . ucfirst($key);
			if (method_exists($this, $setterMethod)) {
				$this->$setterMethod($value);
			}
		}
		return $this;
	}
	protected function castProp(string $value): mixed
	{
		if (is_numeric($value)) {
			if ((int) $value == $value) {
				return (int) $value;
			} elseif ((float) $value == $value) {
				return (float) $value;
			}
		}
		return $value;
	}
	protected function convertRow(array $row): array
	{
		$convertedRow = [];
		foreach ($row as $key => $value) {
			$convertedRow[$key] = $this->castProp($value);
		}
		return $convertedRow;
	}
	abstract protected function getTableName(): string;
}