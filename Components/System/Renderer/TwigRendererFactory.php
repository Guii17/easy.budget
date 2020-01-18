<?php

namespace Components\System\Renderer;

use Psr\Container\ContainerInterface;

class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return TwigRenderer
     */

    /**
     * @param ContainerInterface $container
     *
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $viewpath = $container->get('views.path');
        $loader = new \Twig_Loader_Filesystem($viewpath);
        $twig = new \Twig_Environment(
            $loader, [
            'debug' => true,
            ]
        );
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addExtension(new \Twig_Extensions_Extension_Intl());
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        return new TwigRenderer($loader, $twig);
    }
}
