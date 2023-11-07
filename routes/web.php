<?php

$route[] = ['GET', '/', 'WelcomeController@index'];
$route[] = ['GET', '/posts', 'PostController@index'];
$route[] = ['GET', '/post/{id}', 'PostController@findById'];

return $route;
