<?php
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 14.08.2018
 * Time: 22:15
 */

namespace Lean\Event;


use League\Event\AbstractEvent;
use Slim\Http\Response;

class KernelRequestEvent extends AbstractEvent
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    public function getName()
    {
        return Events::REQUEST;
    }
}