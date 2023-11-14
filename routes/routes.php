<?php

// Routes for web
$route[] = ['GET', '/', 'WelcomeController@index'];
$route[] = ['GET', '/contact', 'WelcomeController@contact'];
$route[] = ['GET', '/posts', 'PostController@index'];
$route[] = ['GET', '/post/{id}', 'PostController@show'];

// Routes for API
$route[] = ['GET', '/api', 'WelcomeController@apiIndex'];
$route[] = ['POST', '/api/posts', 'PostController@store'];
$route[] = ['PUT', '/api/post/{id}', 'PostController@update'];
$route[] = ['DELETE', '/api/post/{id}', 'PostController@delete'];

return $route;
