<?php
declare(strict_types=1);
namespace App\Traits;

use App\Exceptions\ViewNotFoundException;

trait ViewPathTrait 
{
	protected function includeView(string $viewPath): bool
	{
		try {
			if (!file_exists($viewPath)) {
				throw new ViewNotFoundException(basename($viewPath), $viewPath);
			}
			include $viewPath;
			return true;
		} catch (ViewNotFoundException $e) {
			echo $e->getMessage();
			return false;
		}
	}
}