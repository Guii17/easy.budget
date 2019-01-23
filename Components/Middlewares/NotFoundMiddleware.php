<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15/01/2019
 * Time: 12:49
 */

namespace Components\Middlewares;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return new Response(404, [], 'Erreur 404');
    }
}