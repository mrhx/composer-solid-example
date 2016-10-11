<?php
/**
 * Router configuration
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$actions = [
    '/' => app\action\IndexAction::class,
    'signup' => app\action\SignupAction::class,
    'logout' => app\action\LogoutAction::class,
];

foreach ($actions as $route => $className) {
    $router->map(
        ['GET', 'POST'],
        $route,
        function (ServerRequestInterface $request, ResponseInterface $response) use ($container, $className) {
            return $container->get($className)->run($request, $response);
        }
    );
}
