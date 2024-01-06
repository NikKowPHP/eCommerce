<?php
declare(strict_types=1);
namespace App\Controllers;

class HomeController extends AbstractController
{
	public function index(): void
	{
		$viewPath = __DIR__ . '/../Views/home.php';
		$this->includeView($viewPath);
	}
}