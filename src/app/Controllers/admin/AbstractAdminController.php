<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Traits\ViewPathTrait;

abstract class AbstractAdminController
{
	use ViewPathTrait;
	abstract public function index(): void;
	abstract public function show(): void;
	abstract public function create(): void;
	abstract public function store(): void;
	abstract public function edit(): void;
	abstract public function update(): void;
	abstract public function destroy(): void;
}