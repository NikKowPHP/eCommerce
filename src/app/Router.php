<?php
class Router
{
	protected $routes = [];
	
	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
	public function handleRequest($method, $uri)
	{
		$route = $method .''.$uri;
		if(array_key_exists($route, $this->routes)) {
			return $this->handleRoute($this->routes[$route]);
		}
		return $this->error404();
	}
	protected function handleRoute($handler) 
	{
		list($controller, $action) = explode('@',$handler);
		$controllerInstance = new $controller;
		return $controllerInstance->$action();
	}
	protected function error404()
	{
		header($_SERVER["SERVER_PROTOCOL"]. "404 Not Found");
		echo "404 Not Found";
	}


}