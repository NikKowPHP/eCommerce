<?php
require_once('../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use App\Router;

class RouterTest extends TestCase
{
	public function testValidRoute()
	{
		// Arrange 
		$routes = [
			'GET /' => 'HomeController@index',
			'GET /products' => 'ProductController@index',
		];
		$router = new Router($routes);

		// Act 
		$result = $router->handleRequest('GET', '/');

		// Assert
		$this->expectOutputString('Home controller index');
		$this->assertEquals(null, $result);
	}
}