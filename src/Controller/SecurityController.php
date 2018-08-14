<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 22:21
 */

namespace App\Controller;


use Lean\Controller\BaseController;

class SecurityController extends BaseController
{
    function login() {
        return $this->response('<h2>Login Page</h2>');
    }

    function login_fail() {
        return $this->redirect('/login');
    }
}
