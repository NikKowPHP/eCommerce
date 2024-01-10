<?php
$routes = [
	'GET /' => 'HomeController@index',
	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',
];
?>