<?php
declare(strict_types=1);
namespace App\Models;

use App\Database\Database;
use App\Services\DatabaseModelService;
use ReflectionProperty;

abstract class Model
{
	protected Database $database;

	protected static array $hiddenProps = [];

	protected DatabaseModelService $dbOperations;

	public function __construct(Database $database)
	{
		$this->dbOperations = new DatabaseModelService($database);
		$this->database = $database;
	}
	protected function initDatabase(): void
	{
		$this->database = new Database();
	}

	protected function getVisibleProps(): array
	{
		$visibleProps = [];
		array_push(static::$hiddenProps, 'database', 'tableName');

		$reflector = new \ReflectionClass($this);
		$properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);

		foreach ($properties as $property) {
			$property->setAccessible(true);
			$fieldName = $property->getName();
			if ($fieldName !== 'id' && !in_array($fieldName, static::$hiddenProps)) {
				$visibleProps[$fieldName] = $property->getValue($this);
			}
		}
		return $visibleProps;
	}
	public static function setHiddenProps(string ...$values): void
	{
		static::$hiddenProps = array_merge(static::$hiddenProps, $values);
	}
	public static function getHiddenProps(): array
	{
		return static::$hiddenProps;
	}

	protected function save(): ?int
	{
		try {
			$fields = $this->getVisibleProps();

			$fieldNames = implode(', ', array_keys($fields));
			$placeholders = ':' . implode(', :', array_keys($fields));

			$pdo = $this->database->getConnection();
			$query = "INSERT INTO " . $this->getTableName() . " ($fieldNames) VALUES ($placeholders)";
			$stmt = $pdo->prepare($query);
			foreach ($fields as $key => $value) {
				$stmt->bindValue(":$key", $value);
			}
			$stmt->execute();
			$lastInsertId = $pdo->lastInsertId();
			$lastInsertId = $this->dbOperations->insertAndGetLastId($query, $fields);

			return $lastInsertId ? (int) $lastInsertId : null;

		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return null;
		}

	}
	public function update(): ?int
	{
		try {
			$fields = $this->getVisibleProps();
			$setStatements = [];
			foreach ($fields as $key => $value) {
				$setStatements[] = "$key = :$key";
			}
			$setClause = implode(', ', $setStatements);
			$query = "UPDATE " . $this->getTableName() . " SET $setClause WHERE id = :id";

			$rowCount = $this->dbOperations->executeUpdate($query, $fields + ['id' => $this->getId()]);
			return $rowCount;

		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return null;
		}

	}

	public function findAll(): array
	{
		try {
			$query = "SELECT * FROM " . $this->getTableName();
			$allData = $this->dbOperations->fetchAll($query);
			$convertedData = $this->convertRows($allData);
			return $this->instantiateArrayOfClasses($convertedData);
		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return [];
		}
	}
	public function findAllBy(string $where, string|int $value): array
	{
		try {
			$query = "SELECT * FROM " . $this->getTableName() . " WHERE $where = :value";
			$allData = $this->dbOperations->fetchAll($query, [':value' => $value]);
			$convertedData = $this->convertRows($allData);
			return $this->instantiateArrayOfClasses($convertedData);
		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
			return [];
		}
	}
	private function instantiateArrayOfClasses(array $classes): ?array
	{
		return array_map(function ($item) {
			$instance = new static($this->database);
			return $instance->instantiate($item);
		}, $classes) ?: [];
	}
	
	protected function executeDatabaseOperation(callable $operation):?callable
	{
		try {
			return $operation();
		} catch (\PDOException $e) {
			echo "Error: ". $e->getMessage();
			return null;
		}

	}

	protected function findWithConditions(array $conditions): ?static
	{

		try {
			$pdo = $this->database->getConnection();
			$query = "SELECT * FROM " . $this->getTableName() . " WHERE ";

			foreach ($conditions as $index => $condition) {
				$column = $condition['where'] ?? 'id';
				$value = $condition['value'] ?? null;
				$query .= ($index > 0 ? ' AND ' : '') . "$column = :value";

			}
			$stmt = $pdo->prepare($query);
			foreach ($conditions as $index => $condition) {
				$value = $condition['value'] ?? null;
				$stmt->bindParam(':value', $value);
			}
			$stmt->execute();
			$foundData = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
			if ($foundData) {
				$foundData = $this->convertRow($foundData);
				$this->instantiate($foundData);
				return $this;
			}
			return null;
		} catch (\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			return null;
		}

	}
	public function read(int|string $value, ?string $column = null): ?static
	{
		try {
			$pdo = $this->database->getConnection();
			$query = "SELECT * FROM " . $this->getTableName() . " WHERE ";

			$column ? $query .= "$column=:value" : $query .= "id= :value";

			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':value', $value);
			$stmt->execute();
			$foundData = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
			if ($foundData) {
				$foundData = $this->convertRow($foundData);
				$this->instantiate($foundData);
				return $this;
			}
			return null;
		} catch (\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			return null;
		}
	}
	protected function destroy(): ?int
	{
		try {
			$pdo = $this->database->getConnection();
			$query = "DELETE FROM " . $this->getTableName() . " WHERE id=:id";
			$id = static::getId();

			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			return $stmt->rowCount();

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
	protected function castProp(?string $value): mixed
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

	public function getDatabase(): Database
	{
		return $this->database;
	}
	protected function getCount(string $column = 'quantity', string $where = '', string|int $value = ''): ?int
	{
		try {
			$this->initDatabase();
			$pdo = $this->database->getConnection();
			$query = "SELECT COUNT($column) as count FROM " . $this->getTableName();
			if ($where && $value) {
				$query .= " WHERE $where=:value";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(':value', $value);
			} else {
				$stmt = $pdo->prepare($query);
			}
			$stmt->execute();
			$allData = $stmt->fetch(\PDO::FETCH_ASSOC);
			return (int) $allData['count'] ?? null;

		} catch (\PDOException $e) {
			echo "connection failed: " . $e->getMessage();
		}
	}
}