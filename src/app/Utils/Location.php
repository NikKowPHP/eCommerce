<?php
declare(strict_types=1);

namespace App\Utils;

class	Location
{
	public static function redirect(string $link):void
	{
		header("Location: $link");
	}
}