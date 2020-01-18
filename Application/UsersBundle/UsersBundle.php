<?php

namespace Application\UsersBundle;

use Application\UsersBundle\Actions\LoginAction;
use Application\UsersBundle\Actions\RegisterAction;
use Components\System\Renderer\IRenderer;
use Components\System\Router\Router;
use Psr\Container\ContainerInterface;

class UsersBundle
{
    const DEFINITIONS = __DIR__ . '/Resources/Config/Config.php';
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * UsersBundle constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->container->get(IRenderer::class)->addPath('home', __DIR__.'/Resources/Views');
        $router = $this->container->get(Router::class);
        $router->get($this->container->get('users.prefix') . '/login', LoginAction::class, 'users.login');
        $router->get($this->container->get('users.prefix') . '/register', RegisterAction::class, 'users.register');
    }
}
