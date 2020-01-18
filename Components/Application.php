<?php

namespace Components;

use Application\AppKernel;
use Components\System\Middlewares\RoutePrefixedMiddleware;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private $bundles = [];

    private $definition;

    private $container;

    private $middlewares;

    private $index = 0;

    private $listBundles;

    public function __construct(string $definition, array $listBundles = [])
    {
        $this->definition = $definition;
        $this->listBundles = $listBundles;
        foreach($this->listBundles as $oneBundle) {
            $this->addBundle($oneBundle);
        }
    }

    public function addBundle(string $bundle): self
    {
        $this->bundles[] = $bundle;

        return $this;
    }

    public function pipe(string $routePrefix, ?string $middleware = null): self
    {
        if ($middleware === null) {
            $this->middlewares[] = $routePrefix;
        } else {
            $this->middlewares[] = new RoutePrefixedMiddleware($this->getContainer(), $routePrefix, $middleware);
        }

        return $this;
    }

    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if ($middleware === null) {
            throw new \Exception('Aucun middleware n\'a intercepté cette requête');
        }

        if (is_callable($middleware)) {
            return call_user_func_array($middleware, [$request, [$this, 'process']]);
        }

        if ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->bundles as $bundle) {
            $this->getContainer()->get($bundle);
        }

        try {
            return $this->process($request);
        } catch (\Exception $e) {
        }
    }

    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->definition);
            foreach ($this->bundles as $bundle) {
                if ($bundle::DEFINITIONS) {
                    $builder->addDefinitions($bundle::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }

        return $this->container;
    }

    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            if (is_string($this->middlewares[$this->index])) {
                $middleware = $this->container->get($this->middlewares[$this->index]);
            } else {
                $middleware = $this->middlewares[$this->index];
            }
            ++$this->index;

            return $middleware;
        }

        return null;
    }
}
