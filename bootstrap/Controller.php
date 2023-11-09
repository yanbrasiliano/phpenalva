<?php

namespace Bootstrap;

use Core\BaseDatabase;

class Controller
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new BaseDatabase();
    }

    public static function createController($controller, $dependency = null)
    {
        $controllerClass = 'App\\Controllers\\'.$controller;

        if (class_exists($controllerClass)) {
            if ($dependency !== null) {
                return new $controllerClass($dependency);
            } else {
                return new $controllerClass();
            }
        } else {
            throw new \Exception("Controller not found: $controllerClass");
        }
    }

    public function getModel($model)
    {
        $objModel = '\\App\\Models\\'.$model;

        return new $objModel($this->connection->getDatabase());
    }

    public static function pageNotFound()
    {
        if (file_exists(__DIR__.'/../app/Views/System/notFound.phtml')) {
            return require_once __DIR__.'/../app/Views/System/notFound.phtml';
        } else {
            throw new \Exception('View path not found.', 404);
        }
    }
}
