<?php

/*
This file takes care of the initialization of all the files in the application.
It is the first file to be called in the application.
*/
$routes = require_once __DIR__.'/../routes/web.php';
$router = new \Bootstrap\Routes($routes);
