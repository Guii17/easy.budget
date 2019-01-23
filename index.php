<?php

use Application\Home\HomeCore;
use Components\Application;
use Components\Middlewares\CsrfMiddleware;
use Components\Middlewares\MethodMiddleware;
use Components\Middlewares\NotFoundMiddleware;
use Components\Middlewares\RouterMiddleware;
use Components\Middlewares\DispatcherMiddleware;
use GuzzleHttp\Psr7\ServerRequest;

require 'vendor/autoload.php';

$app = (new Application('Components/Config.php'))
    ->addCore(HomeCore::class)

    //->pipe(TrailingSlashMiddleware::class)
    ->pipe(MethodMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);

if (php_sapi_name() !== "cli") {
    $response = $app->run(ServerRequest::fromGlobals());
    \Http\Response\send($response);
}
