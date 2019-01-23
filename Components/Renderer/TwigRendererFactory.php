<?php

namespace Components\Renderer;


use Psr\Container\ContainerInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/Displays');
        $twig = new Twig_Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }
        return new TwigRenderer($loader, $twig);
    }
}
