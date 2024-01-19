<?php
$routes = [
	'GET /' => 'HomeController@index',

	'GET /signup' => 'RegisterController@index',
	'GET /login' => 'LoginController@index',
	'POST /logout' => 'LogoutController@logout',

	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',
	'POST /products' => 'CartController@addProduct',

	'GET /admin/products' => 'ProductController@index',
	'GET /admin/product/{id}' => 'ProductController@show',
	'GET /admin/product/create' => 'ProductController@create',
	'POST /admin/product/store' => 'ProductController@store',
	'POST /admin/product/{id}' => 'ProductController@destroy',
	'GET /admin/product/edit/{id}' => 'ProductController@edit',
	'POST /admin/product/update' => 'ProductController@update',

	'GET /admin/users' => 'UserController@index',
	'POST /admin/user/update' => 'UserController@update',
	'GET /admin/user/create' => 'UserController@create',
	'GET /admin/user/{id}' => 'UserController@show',
	'POST /admin/user/{id}' => 'UserController@destroy',
	'POST /admin/user/store' => 'UserController@store',
	'GET /admin/user/edit/{id}' => 'UserController@edit',

	'POST /admin/carts' => 'CartController@index',
	'GET /admin/carts' => 'CartController@index',

	'POST /users/signup' => 'RegisterController@register',
	'POST /users/login' => 'LoginController@login',
];