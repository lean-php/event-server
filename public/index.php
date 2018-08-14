<?php

// Front Controller
// Request -> Kernel -> Response

// Autoloader
require '../vendor/autoload.php';

// Create request from globals
$request = \Slim\Http\Request::createFromGlobals($_SERVER);

$response = new \Slim\Http\Response();
$response->getBody()->write('<p>Front Controller with wrapped message objects');
$response->getBody()->write('<p>Hello ' . $request->getQueryParam('name', 'World'));

// Extremly simple response sending
echo $response->getBody();
