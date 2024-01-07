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
						product_id INT NOT NULL,
						quantity INT DEFAULT 1,
						FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
						FOREIGN KEY (product_id) REFERENCES products(id)
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
				"INSERT INTO images (product_id, image_url) VALUES 
                    (1, 'path_to_image_1.jpg'), 
                    (1, 'path_to_image_2.jpg')",
				"INSERT INTO users (username, email) VALUES 
                    ('user1', 'user1@example.com')",
				"INSERT INTO carts (user_id) VALUES (1)",
				"INSERT INTO cart_items (cart_id, product_id) VALUES (1,1)",
			];
			echo "Initial data inserted successfully";
		} catch(\PDOException $e) {
			echo "Error inserting initial data: " . $e->getMessage();
		}
	}
}