<?php

namespace Components\System\Middlewares;

use Components\Database\IAuthentificate;
use Components\Session\ISession;
use Components\Exception\ForbbidenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoggedInMiddleware
{

    /**
     * @var IAuthentificate
     */
    private $auth;

    public function __construct(IAuthentificate $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $user = $this->auth->getUser();
        if (is_null($user)) {
            throw new ForbbidenException();
        }
        return $next($request->withAttribute('user', $user));
    }
}
