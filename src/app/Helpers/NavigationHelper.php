<?php
declare(strict_types=1);
namespace App\Helpers;

class NavigationHelper
{
	public static function isLinkActive(string $url, string $currentUrl): string
	{
		if ($url === $currentUrl) {
			return 'active';
		}
		return '';
	}
}