<?php
namespace App;

declare(strict_types=1);
class Router
{
	protected $routes = [];
	
	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
	public function handleRequest(string $method, string $uri):void
	{
		$route = $method .' '.$uri;
		if(array_key_exists($route, $this->routes)) {
			return $this->handleRoute($this->routes[$route]);
		}
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