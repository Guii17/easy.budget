<?php

namespace Components\System\Renderer\Extensions;

use Components\System\Router\Router;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;

class PaginateExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']]),
        ];
    }

    public function paginate(Pagerfanta $paginatedResults, string $route, array $queryArgs = []): string
    {
        $view = new TwitterBootstrap4View();

        return $view->render(
            $paginatedResults, function (int $page) use ($route, $queryArgs) {
                if ($page > 1) {
                    $queryArgs['pages'] = $page;
                }

                return $this->router->generateUri($route, [], $queryArgs);
            }
        );
    }
}
