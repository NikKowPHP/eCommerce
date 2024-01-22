<?php

declare(strict_types=1);

namespace App\Services;

use App\Database\Database;
use PDO;

class DatabaseModelService
{
	protected Database $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}
	protected function executeQuery(string $query, array $params = []): \PDOStatement
	{
		$pdo = $this->database->getConnection();
		$stmt = $pdo->prepare($query);

		foreach ($params as $key => $value) {
			$stmt->bindValue($key, $value);
		}
		$stmt->execute();
		return $stmt;
	}
	protected function fetchAll(string $query, array $params = []): array
	{
		$stmt = $this->executeQuery($query, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}
	protected function fetch(string $query, array $params = []): ?array
	{
		$stmt = $this->executeQuery($query, $params);
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}


}