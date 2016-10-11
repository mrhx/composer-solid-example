<?php
/**
 * Container configuration
 */

$container->share('response', Zend\Diactoros\Response::class);
$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);
$container->share(app\validator\ValidatorFactoryInterface::class, app\validator\ValitronFactory::class);
$container->share(app\model\UserFactoryInterface::class, app\model\UserFactory::class);

$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals();
});

$container->share(app\view\ViewInterface::class, function () use ($container) {
    return new app\view\TwigView(
        __DIR__ . '/../views',
        __DIR__ . '/../tmp',
        $container->get(app\country\CountryListInterface::class)
    );
});

$container->share(app\country\CountryListInterface::class, function () {
    return new app\country\CountryList(__DIR__ . '/../vendor/umpirsky/country-list/data');
});

$container->share(app\session\SessionInterface::class, function () use ($container) {
    return new app\session\AuraSession($container->get('request')->getCookieParams());
});

$container->share(PDO::class, function () use ($config) {
    $pdo = new PDO($config['database.dsn'], $config['database.user'], $config['database.password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
});

$container->share(FluentPDO::class, function () use ($container) {
    return new FluentPDO($container->get(PDO::class));
});

$container->share(app\repository\UserRepositoryInterface::class, app\repository\UserRepository::class)
    ->withArgument(FluentPDO::class)
    ->withArgument(app\model\UserFactoryInterface::class);
