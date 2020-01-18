<?php

use Application\AppKernel;
use Components\Application;
use Components\System\Middlewares\DispatcherMiddleware;
use Components\System\Middlewares\MethodMiddleware;
use Components\System\Middlewares\NotFoundMiddleware;
use Components\System\Middlewares\RouterMiddleware;
use Middlewares\Whoops;

require '../vendor/autoload.php';

$kernel = new AppKernel();
$application = new Application(dirname(__DIR__) . '/Components/Config.php', $kernel->registerBundles());
$application->pipe(MethodMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);

if (php_sapi_name() !== 'cli') {
    $response = $application->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
    \Http\Response\send($response);
}