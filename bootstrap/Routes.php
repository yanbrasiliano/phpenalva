<?php

namespace Bootstrap;

use Core\BaseDatabase;
use Core\BaseAuthenticate;

class Routes
{
  protected $routes;
  protected $connection;
  public function __construct(array $routes)
  {
    $this->connection = new BaseDatabase();
    $this->setRoutes($routes);
    $this->run();
  }

  private static function getUrl()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  private function setRoutes($routes)
  {
    $newRoutes = [];


    foreach ($routes as $route) {
      $parts = explode('@', $route[2]);


      $newRoutes[] = [
        'method' => $route[0],
        'path' => $route[1],
        'controller' => $parts[0],
        'action' => $parts[1],
        'auth' => isset($route[3]) && $route[3] == 'auth'
      ];
    }

    $this->routes = $newRoutes;
  }

  private function getRequest()
  {
    $request = new \stdClass();
    $request->get = (object) $_GET;
    $request->post = (object) $_POST;

    return $request;
  }

  private function run()
  {
    $url = $this->getUrl();
    $urlArray = explode('/', $url);

    try {
      foreach ($this->routes as $route) {
        $routeArray = explode('/', $route['path']);

        if ($route['method'] == $_SERVER['REQUEST_METHOD'] && count($urlArray) == count($routeArray)) {
          $matched = true;
          $params = [];

          for ($i = 0; $i < count($routeArray); ++$i) {
            if (strpos($routeArray[$i], '{') !== false) {
              $params[] = $urlArray[$i];
              $routeArray[$i] = $urlArray[$i];
            } elseif ($routeArray[$i] != $urlArray[$i]) {
              $matched = false;
              break;
            }
          }

          if ($matched) {
            $controllerName = $route['controller'];
            $controller = Controller::createController($controllerName);

            if ($route['auth']) {
              $conn = $this->connection->getDatabase();
              $auth = new \Core\BaseAuthenticate(new \App\Models\User($conn));
              if (!$auth->check()) {
                $controller->forbidden();
                return;
              }
            }

            $action = $route['action'];
            $request = $this->getRequest();
            $params[] = $request;
            call_user_func_array([$controller, $action], $params);
            return;
          }
        }
      }

      return Controller::pageNotFound();
    } catch (\Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
}
