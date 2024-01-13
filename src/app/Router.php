<?php
declare(strict_types=1);
namespace App;

class Router
{
	protected array $routes = [];
	protected int $parametr;

	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
	public function handleRequest(string $method, string $uri, string $namespace): mixed
	{
		foreach ($this->routes as $route => $handler) {
			[$routeMethod, $routeUri] = explode(' ', $route);
			if ($method === $routeMethod && $this->matchRoute($routeUri, $uri)) {
				return $this->handleRoute($handler, $namespace);
			}
			// if ($this->matchRoute($route, $method, $uri)) {
			// 	return $this->handleRoute($handler);
			// }
		}
		return null;
	}
	protected function matchRoute(string $routeUri, string $uri): bool
	{
		if (strpos($routeUri, '{') !== false) {
			$pattern = preg_replace('/\/{\w+}/', '/(\w+)', $routeUri);
			$pattern = str_replace('/', '\/', $pattern);
			if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
				$_GET['id'] = $matches[1];
				$this->parametr = (int) $matches[1];
				return true;
			}
			return false;
		}
		return $uri === $routeUri;
	}
	protected function handleRoute(string $handler, string $namespace): mixed
	{
		list($controller, $action) = explode('@', $handler);
		// $namespace = 'App\Controllers\\';
		$controller = $namespace . $controller;
		$controllerInstance = new $controller();
		$param = isset($this->parametr) ? $this->parametr : null;
		return $controllerInstance->$action($param);
	}


}