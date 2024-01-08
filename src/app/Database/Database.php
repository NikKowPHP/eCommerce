<?php
namespace App\Database;

require_once(__DIR__."/../../config/database.php");

class Database
{
	private \PDO $pdo;

	public function __construct()
	{
		$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
		try {
			$this->pdo = new \PDO($dsn, DB_USER, DB_PASSWORD);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			die();
		}
	}
	public function getConnection(): \PDO
	{
		return $this->pdo;
	}
}