<?php

namespace Bootstrap;

require __DIR__.'/../vendor/autoload.php';

// Treats all errors as exceptions.
set_exception_handler(function ($e) {
    $errorDetails = [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'status_code' => 500,
        'trace' => $e->getTraceAsString(),
    ];

    include __DIR__.'/../app/Views/System/exception.phtml';
    exit;
});

// Loads environment variables from .env file.
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/*
This file takes care of the initialization of all the files in the application.
It is the first file to be called in the application.
*/
$routes = require_once __DIR__.'/../routes/routes.php';
$router = new \Bootstrap\Routes($routes);
