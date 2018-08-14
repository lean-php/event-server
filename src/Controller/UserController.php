<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 19:30
 */

namespace App\Controller;


use Lean\Controller\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param string[] $name
     * @return Response
     */
    function index(Request $request, array $data) : Response {
        return $this->render('user/welcome', $data);
    }
}