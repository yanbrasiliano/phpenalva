<?php

// Routes for web
$route[] = ['GET', '/', 'WelcomeController@index'];
$route[] = ['GET', '/api', 'WelcomeController@apiIndex'];
$route[] = ['POST', '/login', 'AuthController@login'];
$route[] = ['POST', '/logout', 'AuthController@logout'];

$route[] = ['POST', '/api/posts', 'PostController@store'];
$route[] = ['GET', '/contact', 'WelcomeController@contact'];
$route[] = ['GET', '/posts', 'PostController@index'];
$route[] = ['GET', '/post/{id}', 'PostController@show'];
$route[] = ['GET', '/user/create', 'UserController@store'];
$route[] = ['DELETE', '/user/delete/{id}', 'UserController@delete'];
$route[] = ['PUT', '/api/post/{id}', 'PostController@update'];
$route[] = ['DELETE', '/api/post/{id}', 'PostController@delete'];

return $route;
