<?php
declare(strict_types=1);
namespace App\Utils;

use App\Database\Database;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Image;
use App\Services\ProductService;
use App\Controllers\ProductController;

class Container
{
	protected array $instances = [];
	protected Database $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	public function __call(string $name, array $args)
	{
		$method = 'get' . ucfirst($name);
		if (method_exists($this, $method)) {
			return call_user_func_array([$this, $method], $args);
		}
		throw new \BadMethodCallException("Method {$method} not found in " . static::class);
	}
	public function getDatabase(): Database
	{
		return $this->database;
	}

	private function resolveDependencies(string $class):array
	{
		$reflection = new \ReflectionClass($class);
		$constructor = $reflection->getConstructor();
		if($constructor === null){
			return [];
		}
		$parameters = $constructor->getParameters();
		$dependencies = [];
		foreach($parameters as $parameter) {
			$dependencyClass = $parameter->getType();
			if($dependencyClass === null || $dependencyClass->isBuiltin()){
				throw new \RuntimeException("Unable to resolve dependecy for parameter {$parameter->getName()} in {$class}.");
			}
			$dependencies[] = $this->getInstance($dependencyClass->getName());
		}
		return $dependencies;
	}

	private function getInstance(string $class): mixed
	{

		if (!isset($this->instances[$class])) {
			$dependencies = $this->resolveDependencies($class);

			$this->instances[$class] = new $class(...$dependencies);
		}

		return $this->instances[$class];

	}

}