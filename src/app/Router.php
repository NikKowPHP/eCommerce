<?php
declare(strict_types=1);
namespace App;
use App\Database\Database;
use App\Utils\Container;

class Router
{
	protected array $routes = [];
	protected int $parametr;

	protected Container $container;

	public function __construct(array $routes, Container $container)
	{
		$this->routes = $routes;
		$this->container = $container;
	}
	public function handleRequest(string $method, string $uri, string $namespace): mixed
	{
		foreach ($this->routes as $route => $handler) {
			[$routeMethod, $routeUri] = explode(' ', $route);
			if ($method === $routeMethod && $this->matchRoute($routeUri, $uri)) {
				return $this->handleRoute($handler, $namespace);
			}
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
		$database = new Database();
		list($controller, $action) = explode('@', $handler);
		$controller = $namespace . $controller;

		
		$controllerInstance = new $controller($database);
		$param = isset($this->parametr) ? $this->parametr : null;
		return $controllerInstance->$action($param);
	}


}