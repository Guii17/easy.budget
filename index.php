<?php

require 'vendor/autoload.php';

$cores = [
    \App\Blog\BlogModule::class
];

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
foreach ($cores as $core) {
    if ($core::DEFINITIONS) {
        $builder->addDefinitions($core::DEFINITIONS);
    }
}
$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container = $builder->build();

$app = new \Components\Application($container, $cores);
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);