<?php
$routes = [
	'GET /' => 'HomeController@index',

	'GET /signup' => 'RegisterController@index',
	'GET /login' => 'LoginController@index',
	'POST /logout' => 'LogoutController@logout',

	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',

	// ADMIN Views 
	'GET /admin/products' => 'ProductController@index',
	'GET /admin/product/{id}' => 'ProductController@show',
	'GET /admin/users' => 'UserController@index',
	'GET /admin/carts' => 'CartController@index',

	// Admin Crud
	'GET /admin/product/create' => 'ProductController@create',
	'POST /admin/product/store' => 'ProductController@store',
	'GET /admin/product/remove/{id}' => 'ProductController@destroy',
	'GET /admin/product/edit/{id}' => 'ProductController@edit',
	'POST /admin/product/update' => 'ProductController@update',

	'POST /admin/users/create/{id}' => 'UserController@index',
	'GET /admin/users/remove/{id}' => 'UserController@destroy',
	'POST /admin/carts' => 'CartController@index',

	'POST /users/signup' => 'RegisterController@register',
	'POST /users/login' => 'LoginController@login',
];