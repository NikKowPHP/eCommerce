<?php

require_once("../vendor/autoload.php");
require_once("../app/routes.php");

use App\Router;

$router = new Router($routes);
$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->handleRequest($method, $uri);

?>