<?php

namespace app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Basic action interface
 */
interface ActionInterface
{
    /**
     * Run the action
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response);
}
