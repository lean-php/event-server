<?php

namespace Lean;

use Aura\Router\RouterContainer;
use League\Plates\Engine;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Kernel
{
    /**
     * @var RouterContainer
     */
    protected $router;

    /**
     * @var Engine
     */
    protected $templates;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        // Instantiate and configure router
        $this->router = new RouterContainer();
        $map = $this->router->getMap();
        require '../config/routes.php';

        // Instantiate and configure template engine
        $this->templates = new Engine('../templates');
        $this->templates->setFileExtension('tpl');
        $this->templates->addData(['title' => 'FlüAG']);
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
            $controller = new $controllerClass($this->templates);

            // Invoke action
            $response = call_user_func([$controller, $actionName], $request, $route->attributes);
        } else {

            $response = (new Response())->withStatus(404);
            $response->write('Lost in space');

        }

        return $response;
    }
}