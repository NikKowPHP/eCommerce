<?php
declare(strict_types=1);

namespace App\Utils;

class Validator
{
	public static function validateEmail(string $email):bool
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	public static function validatePassword(string $password):bool
	{
		return strlen($password) >= 4;
	}
	public static function validateRegistrationData(string $email, string $password):bool
	{
		return self::validateEmail($email) && self::validatePassword($password);
	}
	public static function validateLoginData(string $email, string $password):bool
	{
		return self::validateEmail($email) && !empty($password);
	}
}