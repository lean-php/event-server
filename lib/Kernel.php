<?php

namespace Lean;

use Aura\Router\RouterContainer;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Kernel
{
    /**
     * @var RouterContainer
     */
    protected $router;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->router = new RouterContainer();
        $map = $this->router->getMap();
        require '../config/routes.php';
    }

    function handle(Request $request): Response
    {
        /** @var Response $response */
        $response = null;

        // Route matching
        $matcher = $this->router->getMatcher();
        $route   = $matcher->match($request);

        if ($route) {
            // Extract controller and action
            $controllerClass = '\\App\\Controller\\' .ucfirst($route->attributes['controller']) . 'Controller';
            $actionName = $route->attributes['action'];

            // Instantiate Controller
            $controller = new $controllerClass;
            // Invoke action
            $response = call_user_func([$controller, $actionName], $request, $route->attributes);
        } else {

            $response = (new Response())->withStatus(404);
            $response->write('Lost in space');

        }

        return $response;
    }
}