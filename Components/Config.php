<?php

use Components\Manage\Session\ISession;
use Components\Manage\Session\PHPSession;
use Components\System\Renderer\Extensions\CsrfExtension;
use Components\System\Renderer\Extensions\FlashExtension;
use Components\System\Renderer\Extensions\FormBuilderExtension;
use Components\System\Renderer\Extensions\PaginateExtension;
use Components\System\Renderer\Extensions\RouterTwigExtension;
use Components\System\Renderer\Extensions\TextExtension;
use Components\System\Renderer\Extensions\TimeExtension;
use Components\System\Renderer\IRenderer;
use Components\System\Renderer\TwigRendererFactory;
use Components\System\Router\Router;
use function DI\object;
use function DI\factory;
use Psr\Container\ContainerInterface;

return array(
    // Gestion de la base de données
    'database.username' => \DI\env('db_username', 'root'),
    'database.password' => \DI\env('db_password', ''),
    'database.host' => \DI\env('db_host', 'localhost'),
    'database.name' => \DI\env('db_name', 'monsupersite'),
    \PDO::class => function (ContainerInterface $c) {
        return new PDO(
            'mysql:host='.$c->get('database.host').
            ';dbname='.$c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    },
    'views.path' => dirname(__DIR__).'/Web/FrontDesign',
    'twig.extensions' => array(
        \DI\get(RouterTwigExtension::class),
        \DI\get(PaginateExtension::class),
        \DI\get(FlashExtension::class),
        \DI\get(TextExtension::class),
        \DI\get(TimeExtension::class),
        \DI\get(CsrfExtension::class),
        \DI\get(FormBuilderExtension::class),
    ),
    ISession::class => object(PHPSession::class),
    Router::class => object(),
    IRenderer::class => factory(TwigRendererFactory::class),
    \Components\System\Middlewares\CsrfMiddleware::class => object()->constructor(\DI\get(ISession::class)),
);
