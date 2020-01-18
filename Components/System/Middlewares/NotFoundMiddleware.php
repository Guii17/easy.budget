<?php

namespace Components\System\Middlewares;

use Components\Actions\RouterAwareAction;
use Components\System\Router\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{
    /**
     * @var Router
     */
    private $router;

    use RouterAwareAction;

    /**
     * NotFoundMiddleware constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return new Response(404, [], 'Erreur 404');
    }
}
