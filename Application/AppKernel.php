<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/03/2019
 * Time: 17:48
 */

namespace Application;

use Application\HomeBundle\HomeBundle;
use Application\UsersBundle\UsersBundle;
use Twig\Loader\LoaderInterface;

class AppKernel
{
    /**
     * @return array List of bundles
     */
    public function registerBundles()
    {
        $bundles = array(
            HomeBundle::class,
            UsersBundle::class
        );

        return $bundles;
    }

    /**
     * Charge le fichier de configuration de chaque bundle
     *
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
