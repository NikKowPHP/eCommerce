<?php
namespace App\Database;

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
					productId INT NOT NULL,
					imageUrl VARCHAR(255) NOT NULL,
					FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE )",

				"CREATE TABLE IF NOT EXISTS users (
						id INT AUTO_INCREMENT PRIMARY KEY,
						username VARCHAR(255) NOT NULL,
						email VARCHAR(255) NOT NULL,
						password VARCHAR(255) NOT NULL,
						registrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
				)",
				"CREATE TABLE IF NOT EXISTS carts (
						id INT AUTO_INCREMENT PRIMARY KEY,
						userId INT NOT NULL,
						createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
						FOREIGN KEY (userId) REFERENCES users(id)
				)",
				"CREATE TABLE IF NOT EXISTS cart_items (
						id INT AUTO_INCREMENT PRIMARY KEY,
						cartId INT NOT NULL,
						productId INT NOT NULL,
						quantity INT DEFAULT 1,
						FOREIGN KEY (cartId) REFERENCES carts(id) ON DELETE CASCADE,
						FOREIGN KEY (productId) REFERENCES products(id)
				)",
			];
			foreach ($queries as $query) {
				$pdo->exec($query);
			}
			echo "Tables created successfully";
		} catch (\PDOException $e) {
			echo "Error creating tables: " . $e->getMessage();
		}
	}
	public function insertInitialData(): void
	{
		try {
			$pdo = $this->database->getConnection();

			$insertQueries = [
				"INSERT INTO products (name, description, price) VALUES 
                    ('Product 1', 'Description 1', 19.99)",
				"INSERT INTO images (productId, imageUrl) VALUES 
                    (1, 'path_to_image_1.jpg'), 
                    (1, 'path_to_image_2.jpg')",
				"INSERT INTO users (username, email) VALUES 
                    ('user1', 'user1@example.com')",
				"INSERT INTO carts (userId) VALUES (1)",
				"INSERT INTO cart_items (cartId, productId) VALUES (1,1)",
			];
			foreach ($insertQueries as $insertion) {
				$pdo->exec($insertion);

			}
			echo "Initial data inserted successfully";
		} catch (\PDOException $e) {
			echo "Error inserting initial data: " . $e->getMessage();
		}
	}
	public function dropTables():void
	{
		try {
			$pdo = $this->database->getConnection();

			$tablesToDrop = [
				'cart_items',
				'carts',
				'images',
				'products',
				'users',
			];
			foreach ($tablesToDrop as $table) {
				$pdo->exec("DROP TABLE IF EXISTS $table");

			}
			echo "TABLES DROP SUCCESSFULLY";
		} catch (\PDOException $e) {
			echo "Error inserting initial data: " . $e->getMessage();
		}

	}
}