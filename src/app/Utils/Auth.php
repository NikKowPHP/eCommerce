<?php
declare(strict_types=1);
namespace App\Utils;

use App\Utils\SessionManager;
class Auth
{
	public static function isLoggedIn(): bool
	{
		return SessionManager::getSessionValue('user_id') !== null;
	}
	public static function logIn(int $userId): void
	{
		SessionManager::regenerateSessionId();
		SessionManager::setSessionValue('user_id', $userId);
	}
	public static function logOut(int $userId): void
	{
		SessionManager::destroySession();
	}
}