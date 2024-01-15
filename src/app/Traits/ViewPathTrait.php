<?php
declare(strict_types=1);
namespace App\Traits;

use App\Exceptions\ViewNotFoundException;

trait ViewPathTrait 
{
	protected function includeView(string $viewPath, array $data = []): self
	{
		try {
			if (!file_exists($viewPath)) {
				throw new ViewNotFoundException(basename($viewPath), $viewPath);
			}
			extract($data);
			include $viewPath;
		} catch (ViewNotFoundException $e) {
			echo $e->getMessage();
		}
		return $this;
	}
}