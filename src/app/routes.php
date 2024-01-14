<?php
$routes = [
	'GET /' => 'HomeController@index',
	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',
	'GET /signup' => 'RegisterController@index',
	'GET /login' => 'LoginController@index',
	'GET /admin/products' => 'ProductController@index',
	'GET /admin/users' => 'UserController@index',
	'GET /admin/carts' => 'CartController@index',
	// ADMIN CRUD
	'POST /admin/product/create/{id}' => 'ProductController@index',
	'GET /admin/product/remove/{id}' => 'UserController@destroy',
	'POST /admin/users/create/{id}' => 'UserController@index',
	'GET /admin/users/remove/{id}' => 'UserController@destroy',
	'POST /admin/carts' => 'CartController@index',
	'POST /logout' => 'LogoutController@logout',
	'POST /users/signup' => 'RegisterController@register',
	'POST /users/login' => 'LoginController@login',
];