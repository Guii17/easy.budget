<?php

namespace Components\System\Middlewares;

use Components\Manage\Actions\RouterAwareAction;
use Components\Manage\Session\FlashService;
use Components\Manage\Session\ISession;
use Components\System\Exception\ForbbidenException;
use Components\System\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ForbbidenMiddleware
{
    private $loginPath;

    private $session;

    private $router;

    use RouterAwareAction;

    public function __construct(/*string $loginPath,*/ISession $session, Router $router)
    {
        //$this->loginPath = $loginPath;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  callable               $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {
            return $next($request);
        } catch (ForbbidenException $exception) {
            $this->session->set('auth.redirect', $request->getUri()->getPath());
            (new FlashService($this->session))->error('Vous devez possèder un compte pour accéder à cette page.');
            return $this->redirect('users.login');
        }
    }
}
