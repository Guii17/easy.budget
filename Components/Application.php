<?php

namespace Components;

use Application\AppKernel;
use Components\System\Middlewares\RoutePrefixedMiddleware;
use DI\ContainerBuilder;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
        if (is_null($middleware)) {
            throw new \Exception('Aucun middleware n\'a intercepté cette requête');
        } elseif (is_callable($middleware)) {
            return call_user_func_array($middleware, [$request, [$this, 'process']]);
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->bundles as $bundle) {
            $this->getContainer()->get($bundle);
        }
        return $this->process($request);
    }

    /**
     * @return ContainerInterface
     */
    private function getContainer(): ContainerInterface
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

    /**
     * @return object
     */
    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->container->get($this->middlewares[$this->index]);
            $this->index++;
            return $middleware;
        }
        return null;
    }

}
