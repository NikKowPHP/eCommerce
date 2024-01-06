<?php
declare(strict_types=1);
namespace App;

class Router
{
	protected $routes = [];
	
	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
	public function handleRequest(string $method, string $uri):mixed
	{
		$route = $method .' '.$uri;
		if(array_key_exists($route, $this->routes)) {
			return $this->handleRoute($this->routes[$route]);
		}
		return null;
	}
	protected function handleRoute(string $handler):mixed
	{
		list($controller, $action) = explode('@',$handler);
		$namespace = 'App\Controllers\\';
		$controller = $namespace . $controller;
		$controllerInstance = new $controller;
		return $controllerInstance->$action();
	}


}