<?php
declare(strict_types=1);
namespace App\Exceptions;

use RuntimeException;

class ViewNotFoundException extends RuntimeException
{
	protected $viewName;
	protected $attemptedPath;

	public function __construct(string $viewName, string $attemptedPath, string $message = "", int $code = 0, \Throwable $previous = null)
	{
		$this->viewName = $viewName;
		if ($message === '') {
			$message = "View file '$viewName' not found at '$attemptedPath'";
		}
		parent::__construct($message, $code, $previous);
	}
	public function getViewName(): string
	{
		return $this->viewName;
	}
	public function getAttemptedPath(): string
	{
		return $this->attemptedPath;
	}
}