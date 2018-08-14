<?php

namespace App\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;
use Lean\Event\KernelRequestEvent;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthListener extends AbstractListener
{
    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @param Request|null $request
     * @return void
     */
    public function handle(EventInterface $event, Request $request = null)
    {
        if (substr($request->getUri()->getPath(), 0, 6) == '/admin') {

            /** @var KernelRequestEvent $requestEvent */
            $requestEvent = $event;

            $response = (new Response())->withStatus(403);
            $response->getBody()->write('Not authorized');
            $requestEvent->setResponse($response);

            $event->stopPropagation();
        }
    }
}