<?php
namespace App;
class Router
{
	protected $routes = [];
	
	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
	public function handleRequest($method, $uri)
	{
		$route = $method .' '.$uri;
		if(array_key_exists($route, $this->routes)) {
			return $this->handleRoute($this->routes[$route]);
		}
	}
	protected function handleRoute($handler) 
	{
		list($controller, $action) = explode('@',$handler);
		$namespace = 'App\Controllers\\';
		$controller = $namespace . $controller;
		$controllerInstance = new $controller;
		return $controllerInstance->$action();
	}


}