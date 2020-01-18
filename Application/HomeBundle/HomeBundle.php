<?php

namespace Application\HomeBundle;

use Application\HomeBundle\Actions\HomepageAction;
use Components\System\Renderer\IRenderer;
use Components\System\Router\Router;
use Psr\Container\ContainerInterface;

class HomeBundle
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
        $router->get($this->container->get('home.prefix'), HomepageAction::class, 'home.index');
    }
}
