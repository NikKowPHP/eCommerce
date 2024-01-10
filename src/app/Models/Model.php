<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;
use ReflectionProperty;

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
	protected function save(): bool
	{
		try {
			$this->initDatabase();
			$reflector = new \ReflectionClass($this);
			$properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);
			$fields = [];
			foreach ($properties as $property) {
				$property->setAccessible(true);
				$fieldName = $property->getName();
				if ($fieldName !== 'id')
					$fields[$fieldName] = $property->getValue($this);
			}
			unset($fields['database']);
			$fieldNames = implode(', ', array_keys($fields));
			$placeholders = ':' . implode(', :', array_keys($fields));

			$pdo = $this->database->getConnection();
			$query = "INSERT INTO " . $this->getTableName() . " ($fieldNames) VALUES ($placeholders)";
			$stmt = $pdo->prepare($query);
			foreach ($fields as $key => $value) {
				$stmt->bindValue(":$key", $value);
			}
			$stmt->execute();

			return true;

		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return false;
		}

	}

	public function findAll(): array
	{
		try {
			$this->initDatabase();
			$pdo = $this->database->getConnection();
			$query = "SELECT * FROM " . $this->getTableName();
			$stmt = $pdo->prepare($query);
			$stmt->execute();
			$allData = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

			if ($allData) {
				return $this->convertRows($allData);
			}
			return [];
		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return [];
		}
	}
	public function findAllBy(string $where, string|int $value): array
	{
		try {
			$this->initDatabase();
			$pdo = $this->database->getConnection();
			$query = "SELECT * FROM " . $this->getTableName() . " WHERE $where = :value";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':value', $value);
			$stmt->execute();
			$allData = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
			$convertedData = $this->convertRows($allData);
			if ($convertedData) {
				return array_map(function ($item) {
					$instance = new static();
					return $instance->instantiate($item);
				}, $convertedData);
			}
			return [];
		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return [];
		}
	}

	public function read(int $id, ?string $column = null): ?static
	{
		try {
			$pdo = $this->database->getConnection();
			$query = "SELECT * FROM " . $this->getTableName() . " WHERE ";

			$column ? $query .= "$column=:id" : $query .= "id = :id";

			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			$foundData = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
			if ($foundData) {
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
	protected function convertRows(array $rows): array
	{
		return array_map(function ($row) {
			return $this->convertRow($row);
		}, $rows);
	}
	abstract protected function getTableName(): string;
}