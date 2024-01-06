<?php
declare(strict_types=1);

require_once("../vendor/autoload.php");
require_once("../app/routes.php");

use App\Router;

// Instantiate the router
$router = new Router($routes);
$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Capture the output from the controller method
ob_start();
$router->handleRequest($method, $uri);
$bodyContent = ob_get_clean();

include("../app/Views/layout.php");

?>