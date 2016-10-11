<?php

namespace app\action;

use app\session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Logout
 */
class LogoutAction implements ActionInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Run the action
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->session->set('userId', 0);
        return $response->withHeader('Location', '/');
    }
}
