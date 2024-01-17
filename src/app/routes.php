<?php
$routes = [
	'GET /' => 'HomeController@index',

	'GET /signup' => 'RegisterController@index',
	'GET /login' => 'LoginController@index',
	'POST /logout' => 'LogoutController@logout',

	'GET /products' => 'ProductController@index',
	'GET /products/{id}' => 'ProductController@show',
	'GET /cart' => 'CartController@index',

	'GET /admin/products' => 'ProductController@index',
	'GET /admin/product/{id}' => 'ProductController@show',
	'GET /admin/product/create' => 'ProductController@create',
	'POST /admin/product/store' => 'ProductController@store',
	'POST /admin/product/{id}' => 'ProductController@destroy',
	'GET /admin/product/edit/{id}' => 'ProductController@edit',
	'POST /admin/product/update' => 'ProductController@update',

	'GET /admin/users' => 'UserController@index',
	'POST /admin/users' => 'UserController@destroy',
	'GET /admin/user/{id}' => 'UserController@show',
	'GET /admin/user/create' => 'UserController@create',
	'POST /admin/user/create' => 'UserController@store',
	'GET /admin/user/edit/{id}' => 'UserController@edit',
	'POST /admin/user/edit/{id}' => 'UserController@update',

	'POST /admin/carts' => 'CartController@index',
	'GET /admin/carts' => 'CartController@index',

	'POST /users/signup' => 'RegisterController@register',
	'POST /users/login' => 'LoginController@login',
];