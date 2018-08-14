<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 20:41
 */

namespace Lean\Controller;


use App\Service\DB;
use League\Plates\Engine;
use Slim\Http\Response;

class BaseController
{
    /** @var Engine */
    protected $templates;

    /**
     * BaseController constructor.
     * @param Engine $templates
     */
    public function __construct(Engine $templates, DB $db)
    {
        $this->templates = $templates;
    }

    function render(string $template, array $data): Response {
        $body = $this->templates->render($template, $data);
        return $this->response($body);
    }

    function response(string $body = '', $statusCode = 200): Response {
        $response = (new Response())->withStatus($statusCode);
        $response->getBody()->write($body);
        return $response;
    }

    function redirect(string $location, $statusCode = 302): Response {
        $response = (new Response())->withRedirect('/login', $statusCode);
        return $response;
    }
}