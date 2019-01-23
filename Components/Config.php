<?php

use function DI\factory;
use function DI\object;
use Components\Renderer\RendererInterface;
use Components\Renderer\TwigRendererFactory;
use Components\Router\Router;
use Library\Extensions\Twig\RouterTwigExtension;
use Library\Extensions\Twig\FlashExtension;
use Library\Extensions\Twig\FormExtension;
use Library\Extensions\Twig\TextExtension;
use Library\Extensions\Twig\TimeExtension;


return array(
    // Gestion de la base de données
    'database.username' => \DI\env('db_username', 'root'),
    'database.password' => \DI\env('db_password', ''),
    'database.host' => \DI\env('db_host', 'localhost'),
    'database.name' => \DI\env('db_name', 'monsupersite'),
    \PDO::class => function (\Psr\Container\ContainerInterface $c) {
        return new PDO(
            'mysql:host=' . $c->get('database.host') .
            ';dbname=' . $c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    },
    'views.path' => dirname(__DIR__) . '/Displays',
    'twig.extensions' => [
        \DI\get(RouterTwigExtension::class),
        \DI\get(TextExtension::class),
        \DI\get(TimeExtension::class)
    ],
    Router::class => object(),
    RendererInterface::class => factory(TwigRendererFactory::class),
);
