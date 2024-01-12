<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Utils\Location;
use App\Utils\SessionManager;
use App\Utils\Auth;

class LogoutController
{
	public function logout(): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId = SessionManager::getSessionValue('user_id')) {
			Auth::logOut($userId);
			Location::redirect('/login');
		}
	}
}