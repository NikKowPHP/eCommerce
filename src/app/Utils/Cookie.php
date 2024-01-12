<?php
declare(strict_types=1);

namespace App\Utils;

class Cookie
{
	public static function set(string $name, string $value, int $expiry = 0)
	{
		setcookie($name, $value, $expiry);
	}
	public static function get(string $name): ?string
	{
		return $_COOKIE[$name] ?? null;
	}
	public static function delete(string $name): void
	{
		self::set($name, '', time() - 3600);
	}
}