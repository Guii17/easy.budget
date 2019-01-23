<?php

namespace Application\Home;

// On inclut les différentes classes que nous aurions besoin

use Application\Home\Actions\HomeIndex;
use Components\Core;
use Components\Renderer\RendererInterface;
use Components\Router\Router;
use Psr\Container\ContainerInterface;

class HomeCore extends Core
{

    // On ajoute le fichier de configuration
    const DEFINITIONS = __DIR__ . '/Config.php';

    // On appel la fonction constructrice afin de lui passer le container

    /**
     * HomeCore constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        // On définit le dossier des vues
        $container->get(RendererInterface::class)->addPath('home', __DIR__ . '/Displays');
        // On construit le router
        $router = $container->get(Router::class);
        // Ajout des routes
        $router->get($container->get('home.prefix'), HomeIndex::class, 'home.index');
    }
}