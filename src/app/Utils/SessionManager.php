<?php
declare(strict_types=1);

namespace App\Utils;

class SessionManager
{
	public static function startSession(): void
	{
		session_start();
	}
	public static function regenerateSessionId(): void
	{
		session_regenerate_id(true);
	}
	public static function setSessionValue(string $key, $value): void
	{
		$_SESSION[$key] = $value;
	}
	public static function getSessionValue(string $key)
	{
		return $_SESSION[$key] ?? null;
	}
	public static function destroySession(): void
	{
		session_destroy();
	}
	public static function setFlashMessage(string $key, string $message): void
	{
		$_SESSION['flash_messages'][$key] = $message;
	}
	public static function getFlashMessage(string $key): ?string
	{
		if ($message = $_SESSION['flash_messages'][$key] ?? null) {
			unset($_SESSION['flash_messages'][$key]);
			return $message;
		}
		return null;
	}
}