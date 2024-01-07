<?php
namespace App;

class DatabasePopulator
{
	protected Database $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}
	public function createTables(): void
	{
		try {
			$pdo = $this->database->getConnection();
			$queries = [
				"CREATE TABLE IF NOT EXISTS products (
           id INT AUTO_INCREMENT PRIMARY KEY,
						name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL
          )",
				"CREATE TABLE IF NOT EXISTS images (
					id INT AUTO_INCREMENT PRIMARY KEY,
					product_id INT NOT NULL,
					image_url VARCHAR(255) NOT NULL,
					FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE )",

				"CREATE TABLE IF NOT EXISTS users (
						id INT AUTO_INCREMENT PRIMARY KEY,
						username VARCHAR(255) NOT NULL,
						email VARCHAR(255) NOT NULL
				)",
				"CREATE TABLE IF NOT EXISTS carts (
						id INT AUTO_INCREMENT PRIMARY KEY,
						user_id INT NOT NULL,
						created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
						FOREIGN KEY (user_id) REFERENCES users(id)
				)",
				"CREATE TABLE IF NOT EXISTS cart_items (
						id INT AUTO_INCREMENT PRIMARY KEY,
						cart_id INT NOT NULL,
						user_id INT NOT NULL,
						quantity INT DEFAULT 1,
						FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
						FOREIGN KEY (product_id) REFERENCES products(id)
				)",
			];
			foreach($queries as $query) {
				$pdo->exec($query);
			}
			echo "Tables created successfully";
		} catch(\PDOException $e) {
			echo "Error creating tables: " .$e->getMessage();
		}
	}
}