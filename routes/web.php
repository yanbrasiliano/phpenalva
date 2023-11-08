<?php

$route[] = ['GET', '/', 'WelcomeController@index'];
$route[] = ['GET', '/contact', 'WelcomeController@contact'];
$route[] = ['GET', '/posts', 'PostController@index'];
$route[] = ['GET', '/post/{id}', 'PostController@findById'];

return $route;
