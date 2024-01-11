<?php
declare(strict_types=1);

namespace App\Utils;

class SessionManager
{
	public static function startSession():void
	{
		session_start();
	}
	public static function regenerateSessionId():void
	{
		session_regenerate_id(true);
	}
	public static function setSessionValue(string $key, $value):void
	{
		$_SESSION[$key] = $value;
	}
	public static function getSessionValue(string $key)
	{
		return $_SESSION[$key]?? null;
	}
	public static function destroySession():void
	{
		unset($_SESSION);
	}
	

}