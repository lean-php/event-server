<?php

namespace Lean;

use Aura\Router\RouterContainer;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\AbstractListener;
use League\Event\Emitter;
use League\Plates\Engine;
use Lean\Event\KernelRequestEvent;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Kernel
{
    /**
     * @var Container
     */
    protected $di;

    /**
     * @var RouterContainer
     */
    protected $router;

    /**
     * @var Engine
     */
    protected $templates;

    /**
     * @var Emitter
     */
    protected $emitter;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        // Instantiate event emitter
        $this->emitter = new Emitter();

        // Instantiate and configure dependency injection container
        $this->di = new Container();
        $this->di->delegate(
            new ReflectionContainer()
        );

        // Instantiate and configure router
        $this->router = new RouterContainer();
        $map = $this->router->getMap();
        require '../config/routes.php';

        // Instantiate and configure template engine
        $this->templates = new Engine('../templates');
        $this->templates->setFileExtension('tpl');
        $this->templates->addData(['title' => 'FlüAG']);

        $this->di->add(Engine::class, function () {
            return $this->templates;
        });
    }

    function handle(Request $request): Response
    {
        /** @var Response $response */
        $response = null;

        /** @var KernelRequestEvent $event */
        $event = $this->emitter->emit(new KernelRequestEvent(), $request);
        if ($event->isPropagationStopped() && $event->getResponse() != null) {
            return $event->getResponse();
        }

        // Route matching
        $matcher = $this->router->getMatcher();
        $route   = $matcher->match($request);

        if ($route) {
            // Extract controller and action
            $controllerClass = '\\App\\Controller\\' .ucfirst($route->attributes['controller']) . 'Controller';
            $actionName = $route->attributes['action'];

            // Instantiate Controller
            //$this->di->add($controllerClass);
            $controller = $this->di->get($controllerClass);

            // Invoke action
            $response = call_user_func([$controller, $actionName], $request, $route->attributes);
        } else {

            $response = (new Response())->withStatus(404);
            $response->write('Lost in space');

        }

        return $response;
    }

    function registerListener(string $event, AbstractListener $listener) {
        $this->emitter->addListener($event, $listener);
    }

    /**
     * Send the response to the client (simplified Slim version
     *
     * @param ResponseInterface $response
     */
    public function respond(ResponseInterface $response)
    {
        // Send response
        if (!headers_sent()) {
            // Headers
            foreach ($response->getHeaders() as $name => $values) {
                $first = stripos($name, 'Set-Cookie') === 0 ? false : true;
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), $first);
                    $first = false;
                }
            }
            // Set the status _after_ the headers, because of PHP's "helpful" behavior with location headers.
            // See https://github.com/slimphp/Slim/issues/1730
            // Status
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ), true, $response->getStatusCode());
        }
        // Body
        if (!$this->isEmptyResponse($response)) {
            $body = $response->getBody();
            echo $body;
        }
    }

    /**
     * Helper method, which returns true if the provided response must not output a body and false
     * if the response could have a body.
     *
     * @see https://tools.ietf.org/html/rfc7231
     *
     * @param ResponseInterface $response
     * @return bool
     */
    protected function isEmptyResponse(ResponseInterface $response)
    {
        if (method_exists($response, 'isEmpty')) {
            return $response->isEmpty();
        }
        return in_array($response->getStatusCode(), [204, 205, 304]);
    }

}