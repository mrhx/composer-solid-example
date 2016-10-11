<?php
/**
 * Application init code
 * @link https://github.com/mrhx/composer-solid-example
 */

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

if (!empty($config['debug'])) {
    ini_set('display_errors', true);
}

$container = new League\Container\Container();

$container->delegate(new League\Container\ReflectionContainer());

$router = new League\Route\RouteCollection($container);

require __DIR__ . '/config/container.php';
require __DIR__ . '/config/router.php';

try {
    $response = $router->dispatch($container->get('request'), $container->get('response'));
} catch (League\Route\Http\Exception\NotFoundException $e) {
    $response = $container->get('response')->withStatus(404);
    $response->getBody()->write(
        $container->get(app\ViewInterface::class)->render('404')
    );
}

$container->get('emitter')->emit($response);
