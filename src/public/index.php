<?php
declare(strict_types=1);
use App\Helpers\NavigationHelper;
use App\Utils\SessionManager;

require_once("../vendor/autoload.php");
require_once("../app/routes.php");

use App\Router;

SessionManager::startSession();

echo SessionManager::getFlashMessage('success');
echo SessionManager::getFlashMessage('failure');
// Instantiate the router
$router = new Router($routes);
$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Capture the output from the controller method
ob_start();
$namespace = NavigationHelper::getControllerNamespace($uri);
$router->handleRequest($method, $uri, $namespace);
$bodyContent = ob_get_clean();

if (NavigationHelper::isAdminLayout('/admin', $uri)) {
	include("../app/Views/admin/layoutAdmin.php");
} else {
	include("../app/Views/layout.php");
}
