<?php
class Router
{
	protected $routes = [];
	
	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}


}