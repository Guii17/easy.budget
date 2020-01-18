<?php

namespace Components\Manage\Actions;

use Components\Router\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Rajoute des méthode liée à l'utilisation du Router.
 *
 * Trait RouterAwareAction
 */
trait RouterAwareAction
{
    /**
     * Renvoie une réponse de redirection.
     *
     * @param string $path
     * @param array  $params
     *
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);

        return (new Response())
            ->withStatus(301)
            ->withHeader('Location', $redirectUri);
    }
}
