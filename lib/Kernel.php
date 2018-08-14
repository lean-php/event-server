<?php

namespace Lean;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class Kernel
{
    function handle(Request $request): Response
    {
        $response = new \Slim\Http\Response();
        $response->getBody()->write('<p>Front Controller with wrapped message objects and kernel class');
        $response->getBody()->write('<p>Hello ' . $request->getQueryParam('name', 'World'));
        return $response;
    }
}