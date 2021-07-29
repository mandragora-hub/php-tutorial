<?php

use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigExtension;
use Slim\Psr7\Factory\UriFactory;
use Dotenv\Exception\InvalidPathException;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv(__DIR__ . '/../'))->load();
} catch (InvalidPathException $e) {
    //
}

$container = new DI\Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$container->set('settings', function () {
    return [
        'app' => [
            'name' => getenv('APP_NAME')
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'sampledb',
            'username' => 'sampleuser',
            'password' => '1234',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ];
});

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container->set('db', function ($container) use ($capsule) {
    return $capsule;
});

$container->set('view', function ($container) use ($app) {
    $twig = new Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);

    $twig->addExtension(
        new TwigExtension(
            $app->getRouteCollector()->getRouteParser(),
            (new UriFactory)->createFromGlobals($_SERVER),
            '/'
        )
    );

    return $twig;
});

require_once __DIR__ . '/../routes/web.php';
