<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiVilleControllerrechercheVilleService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.rhw1PeZ.App\Controller\ApiVilleController::rechercheVille()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.rhw1PeZ.App\\Controller\\ApiVilleController::rechercheVille()'] = ($container->privates['.service_locator.rhw1PeZ'] ?? $container->load('get_ServiceLocator_Rhw1PeZService'))->withContext('App\\Controller\\ApiVilleController::rechercheVille()', $container);
    }
}
