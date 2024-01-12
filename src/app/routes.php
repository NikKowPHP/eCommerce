<?php
$routes = [
	'GET /' => 'HomeController@index',
	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',
	'GET /signup' => 'RegisterController@index',
	'GET /login' => 'LoginController@index',
	'POST /logout' => 'LogoutController@logout',
	'POST /users/signup' => 'RegisterController@register',
	'POST /users/login' => 'LoginController@login',
];