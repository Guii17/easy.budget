<?php

namespace Components\System\Router;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Register and match routes.
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string          $path
     * @param string|callable $callable
     * @param string          $name
     */
    public function get(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }

    /**
     * @param string          $path
     * @param string|callable $callable
     * @param string          $name
     */
    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }

    /**
     * Génère les route du CRUD.
     *
     * @param string   $prefixPath
     * @param $callable
     * @param string   $prefixName
     */
    public function routeCrud(string $prefixPath, $callable, string $prefixName)
    {
        // Normal en GET
        $this->get($prefixPath, $callable, $prefixName.'.index');
        // Création d'un élément en GET
        $this->get($prefixPath.'/create', $callable, $prefixName.'.create');
        // Soumission de la création d'un élément POST
        $this->post($prefixPath.'/create', $callable);
        // Modification d'un élément en GET
        $this->get($prefixPath."/update/{id:\d+}", $callable, $prefixName.'.update');
        // Soumission de la modification d'un élément POST
        $this->post($prefixPath."/update/{id:\d+}", $callable);
        // Supression d'un élement en DELETE
        $this->delete($prefixPath."/delete/{id:\d+}", $callable, $prefixName.'.delete');
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }

        return null;
    }

    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        if (!empty($queryParams)) {
            return $uri.'?'.http_build_query($queryParams);
        }

        return $uri;
    }
}
