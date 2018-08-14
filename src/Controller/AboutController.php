<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 21:00
 */

namespace App\Controller;


use Lean\Controller\BaseController;

class AboutController extends BaseController
{
    function index() {
        return $this->response('<h1>About</h1>');
    }
}
