<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Traits\ViewPathTrait;

abstract class AbstractController 
{
	use ViewPathTrait;
	abstract public function index(): void;
}