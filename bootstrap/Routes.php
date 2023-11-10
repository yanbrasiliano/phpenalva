<?php

namespace Bootstrap;

class Routes
{
    protected $routes;
    protected $routeType;

    public function __construct(array $routes, $routeType)
    {
        $this->routeType = $routeType;
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
            if ($route[3] === $this->routeType || !isset($route[3])) {
                $parts = explode('@', $route[2]);
                $newRoutes[] = [
                    'method' => $route[0],
                    'path' => $route[1],
                    'controller' => $parts[0],
                    'action' => $parts[1],
                ];
            }
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

                if (count($urlArray) == count($routeArray)) {
                    $matched = true;
                    $params = [];

                    for ($i = 0; $i < count($routeArray); ++$i) {
                        if (strpos($routeArray[$i], '{') !== false) {
                            $params[] = $urlArray[$i];
                            $routeArray[$i] = $urlArray[$i]; // Replace the parameter with its value
                        } elseif ($routeArray[$i] != $urlArray[$i]) {
                            $matched = false;
                            break;
                        }
                    }

                    if ($matched) {
                        $controllerName = $route['controller'];
                        $action = $route['action'];

                        // Create controller instance
                        $controller = Controller::createController($controllerName);

                        // Get the request object
                        $request = $this->getRequest();

                        // Add the request object to the parameters
                        $params[] = $request;

                        // Call the controller action
                        call_user_func_array([$controller, $action], $params);

                        return; // Exit the loop as we found a matching route
                    }
                }
            }

            // If no matching route is found
            return Controller::pageNotFound();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
