<?php

// Front Controller
// Request -> Kernel -> Response

// Autoloader
require '../vendor/autoload.php';

// Create request from globals
$request = \Slim\Http\Request::createFromGlobals($_SERVER);

// Create the app kernel
$kernel = new \App\Kernel();

// Handle request
$response = $kernel->handle($request);

// Send the response
$kernel->respond($response);