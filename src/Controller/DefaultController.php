<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 19:38
 */

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class DefaultController
{
    function index(Request $request) {
        $response = new Response();
        $response->write("Homepage");
        return $response;
    }
}