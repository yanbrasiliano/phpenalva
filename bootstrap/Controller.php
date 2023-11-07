<?php

namespace Bootstrap;

class Controller
{
    public static function createController($controller)
    {
        $controllerClass = 'App\\Controllers\\'.$controller;

        if (class_exists($controllerClass)) {
            return new $controllerClass();
        } else {
            throw new \Exception("Controller not found: $controllerClass");
        }
    }

    public static function pageNotFound()
    {
        if (file_exists(__DIR__.'/../app/Views/error.phtml')) {
            return require_once __DIR__.'/../app/Views/error.phtml';
        } else {
            throw new \Exception('View path not found.', 404);
        }
    }
}
