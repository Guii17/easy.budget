<?php

namespace Components\System\Middlewares;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoutePrefixedMiddleware
{
    private $container;

    private $prefix;

    private $middleware;

    public function __construct(ContainerInterface $container, string $prefix, string $middleware)
    {
        $this->container = $container;
        $this->prefix = $prefix;
        $this->middleware = $middleware;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        if (strpos($path, $this->prefix) === 0) {
            return $this->container->get($this->middleware)->__invoke($request, $next);
        }

        return $next($request);
    }
}
