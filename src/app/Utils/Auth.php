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
	public static function getUserId(): ?int
	{
		return SessionManager::getSessionValue('user_id') ?? null;
	}
	public static function logIn(int $userId): void
	{
		// TODO: Auth token
		SessionManager::regenerateSessionId();
		SessionManager::setSessionValue('user_id', $userId);
		Cookie::set('user_id', (string) $userId, Cookie::getMonthExpiration());
	}
	public static function logOut(int $userId): void
	{
		Cookie::delete('user_id');
		SessionManager::destroySession();
	}
}