<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 19:30
 */

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController
{
    /**
     * @param Request $request
     * @param string[] $name
     * @return Response
     */
    function index(Request $request, array $data) : Response {
        $response = new Response();
        $response->write("Hello " . $data['name']);
        return $response;
    }
}