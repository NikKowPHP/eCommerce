<?php
declare(strict_types=1);
namespace App\Helpers;

class NavigationHelper
{
	public static function isLinkActive(string $url, string $currentUrl): string
	{
		if ($url === $currentUrl) {
			return 'font-bold';
		}
		return '';
	}
	public static function isAdminLayout(string $url, string $currentUrl): bool
	{
		return str_contains($currentUrl, $url);
	}
	public static function getControllerNamespace(string $currentUri): string
	{
		if (str_contains($currentUri, '/admin')) {
			return 'App\Controllers\Admin\\';
		}
		return 'App\Controllers\\';
	}

}