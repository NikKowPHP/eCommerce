<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

use App\Traits\ViewPathTrait;

abstract class AbstractAdminController
{
	use ViewPathTrait;
	abstract public function index(): void;
	abstract public function show(int $id): void;
	abstract public function create(): void;
	abstract public function store(): ?int;
	abstract public function edit(int $id): void;
	abstract public function update(): bool;
	abstract public function destroy(int $id): ?bool;
}