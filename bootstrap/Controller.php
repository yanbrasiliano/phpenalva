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
    $controllerClass = 'App\\Controllers\\' . $controller;

    if (!class_exists($controllerClass)) {
      throw new \Exception("Controller not found: $controllerClass");
    }

    return $dependency !== null
      ? new $controllerClass($dependency)
      : new $controllerClass();
  }


  public function getModel($model)
  {
    $objModel = '\\App\\Models\\' . $model;

    return new $objModel($this->connection->getDatabase());
  }
  public static function pageNotFound()
  {
    $viewPath = __DIR__ . '/../app/Views/System/notFound.phtml';

    if (!file_exists($viewPath)) {
      throw new \Exception('View path not found.', 404);
    }

    return require_once $viewPath;
  }
}
