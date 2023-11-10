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
// Routes for the web (web.php)
$webRoutes = require_once __DIR__.'/../routes/web.php';
$webRouter = new \Bootstrap\Routes($webRoutes, 'web');

// Routes for the API (api.php)
$apiRoutes = require_once __DIR__.'/../routes/api.php';
$apiRouter = new \Bootstrap\Routes($apiRoutes, 'api');
